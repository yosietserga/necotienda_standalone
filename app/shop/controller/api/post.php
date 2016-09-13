<?php

class ControllerApiPost extends Controller {

    public function get() {
        $Url = new Url($this->registry);
        $id = isset($this->request->get['id']) ? (int) $this->request->get['id'] : 0;
        $type = isset($this->request->get['type']) ? (int) $this->request->get['type'] : 'post';
        $post_info = $this->modelPost->getProduct($id);

        if ($post_info) {
            $customerGroups = $this->modelPost->getProperty($id, 'customer_groups', 'customer_groups');
            if (($this->customer->isLogged() && in_array($this->customer->getCustomerGroupId(), $customerGroups)) || in_array(0, $customerGroups)) {
                $cached = $this->cache->get('post.api.json.get.' .
                        $id .
                        $this->config->get('config_language_id') . "." .
                        $this->config->get('config_currency') . "." .
                        $this->config->get('config_store_id')
                );
                
                $this->load->library('user');
                
                if ($cached && (!$this->user->isLogged() || $this->request->hasQuery('np'))) {
                    $this->response->setOutput($cached, $this->config->get('config_compression'));
                } else {
                    //Models
                    $this->load->auto('content/post');
                    $this->load->auto('content/category');

                    $this->load->auto('tool/image');
                    $this->load->auto('store/review');

                    $this->document->breadcrumbs = array();
                    $this->document->breadcrumbs[] = array(
                        'href' => Url::createUrl('store/home'),
                        'text' => $this->language->get('text_home'),
                        'separator' => false
                    );

                    if (isset($this->request->get['path'])) {
                        $path = '';
                        foreach (explode('_', $this->request->get['path']) as $path_id) {
                            $category_info = $this->modelCategory->getCategory($path_id);
                            $path .= (!$path) ? $path_id : '_' . $path_id;
                            if ($category_info) {
                                $this->document->breadcrumbs[] = array(
                                    'href' => Url::createUrl('store/category', array('path' => $path)),
                                    'text' => $category_info['name'],
                                    'separator' => $this->language->get('text_separator')
                                );
                            }
                        }
                    }
                    
                    $this->document->breadcrumbs[] = array(
                        'href' => $Url::createUrl('content/post', array(
                            'post_id'=>$id,
                            'type'=> $type
                        )),
                        'text' => $post_info['name'],
                        'separator' => $this->language->get('text_separator')
                    );

                    $this->data['breadcrumbs'] = $this->document->breadcrumbs;

                    $average = ($this->config->get('config_review')) ? $this->modelReview->getAverageRating($id) : $average = false;

                    $this->data['redirect'] = $Url::createUrl('content/post', array(
                        'post_id'=>$id,
                        'type'=> $type
                    ));

                    $image = isset($post_info['image']) ? $post_info['image'] : $image = 'no_image.jpg';
                    $this->data['popup'] = NTImage::resizeAndSave($image, $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
                    $this->data['thumb'] = NTImage::resizeAndSave($image, $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));

                    $this->data['post_info'] = $post_info;
                    $this->data['description'] = htmlspecialchars($post_info['description'], ENT_QUOTES, 'UTF-8');
                    $this->data['post_id'] = $id;
                    $this->data['post_type'] = $type;
                    $this->data['average'] = $average;

                    $this->data['categories'] = $this->modelCategory->getCategoriesByPost(array('post_id' => $id));
                    $this->data['related'] = $this->modelPost->getAll(array(
                        'post_id' => $id,
                        'func' => 'related',
                    ));

                    $this->modelPost->updateStats($id, $type, (int) $this->customer->getId());

                    $this->data['tags'] = array();

                    $results = $this->modelPost->getTags($id);

                    foreach ($results as $result) {
                        if ($result['tag']) {
                            $this->data['tags'][] = array(
                                'tag' => $result['tag'],
                                'href' => Url::createUrl('store/search', array('q' => $result['tag']))
                            );
                        }
                    }

                    if (!$this->user->isLogged()) {
                        $this->cacheId = 'post.api.json.get.' .
                                $id .
                                $this->config->get('config_language_id') . "." .
                                $this->config->get('config_currency') . "." .
                                (int) $this->config->get('config_store_id');
                    }

                    $this->load->library('json');
                    $this->response->setOutput(Json::encode($this->data), $this->config->get('config_compression'));
                }
            } else {
                $this->error404();
            }
        } else {
            $this->error404();
        }
    }

    protected function error404() {
        header("HTTP/1.0 404 Not Found", true, 404);
        $this->data['response'] = '404';
        $this->data['error'] = 'Post not found';
        
        $this->load->library('json');
        $this->response->setOutput(Json::encode($this->data), $this->config->get('config_compression'));
    }

    protected function error401() {
        header("HTTP/1.0 401 Not Authorized", true, 401);
        $this->data['response'] = '401';
        $this->data['error'] = 'Access Not Authorized';
        
        $this->load->library('json');
        $this->response->setOutput(Json::encode($this->data), $this->config->get('config_compression'));
    }

    public function all() {
	    if (($this->request->server['REQUEST_METHOD'] == 'GET')) {
            $data['type'] = $this->request->hasQuery('type') ? $this->request->getQuery('type') : 'post';
            $data['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
            $data['limit'] = $this->request->hasQuery('limit') ? $this->request->getQuery('limit') : $this->config->get('config_catalog_limit');

            $this->load->model('content/post');
            $this->load->model('store/review');
            $data['start'] = ($data['page'] - 1) * $data['limit'];
            $post_total = $this->modelPost->getAllToal($data);
            if ($post_total) {
                $this->setHeaders();
                $results = $this->modelPost->getAll($data);
                foreach ($results as $result) {
                    $image = !empty($result['image']) ? $result['image'] : 'no_image.jpg';

                    if ($this->config->get('config_review')) {
                        $rating = $this->modelReview->getAverageRating($result['post_id']);
                    } else {
                        $rating = false;
                    }

                    $this->data['results'][] = array(
                        'post_id' => $result['post_id'],
                        'name' => $result['name'],
                        'type' => $result['type'],
                        'overview' => $result['meta_description'],
                        'rating' => $rating,
                        'stars' => sprintf($this->language->get('text_stars'), $rating),
                        'image' => NTImage::resizeAndSave($image, 38, 38),
                        'lazyImage' => NTImage::resizeAndSave('no_image.jpg', $this->config->get('config_image_post_width'), $this->config->get('config_image_post_height')),
                        'thumb' => NTImage::resizeAndSave($image, $this->config->get('config_image_post_width'), $this->config->get('config_image_post_height')),
                        'href' => Url::createUrl('content/post', array('post_id' => $result['post_id'], 'type'=>$data['type']))
                    );
                }
                $this->load->library('json');
                $this->response->setOutput(Json::encode($this->data), $this->config->get('config_compression'));
            } else {
                $this->error404();
            }
        } else {
            $this->error404();
        }
    }
    
    public function create() {
        $this->setHeaders();
        
        $this->load->library('json');
        $this->response->setOutput(Json::encode($this->data), $this->config->get('config_compression'));
    }
    
    public function update() {
        $this->setHeaders();
        
        $this->load->library('json');
        $this->response->setOutput(Json::encode($this->data), $this->config->get('config_compression'));
    }
    
    public function delete() {
        $this->setHeaders();
        
        $this->load->library('json');
        $this->response->setOutput(Json::encode($this->data), $this->config->get('config_compression'));
    }
    
    protected function setHeaders() {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type');
        header('Access-Control-Allow-Methods: GET');
        header("HTTP/1.0 200 Success", true, 200);
    }
}
