<?php

class ControllerModulePostList extends Module {

    protected function index($widget = null) {
        $Url = new Url($this->registry);
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');
        $data['featured_posts'] = isset($settings['featured_posts']) ? $settings['featured_posts'] : null;
        
        $data['limit'] = $this->request->hasQuery('limit') ?
            $this->request->getQuery('limit') :
            ((int)$settings['limit']) ? (int)$settings['limit']
                : ((int)$this->config->get('config_catalog_limit')) ? (int)$this->config->get('config_catalog_limit') : 24;
        
        $data['post_type'] = $this->request->hasQuery('post_type') ?
            $this->request->getQuery('post_type') :
            ($settings['post_type']) ? $settings['post_type']
                : 'post';
        
        $data['post_id'] = $this->request->hasPost('post_id') ?
            $this->request->getPost('post_id') :
            $this->request->hasQuery('post_id') ? $this->request->getQuery('post_id') : null;
        
        $data['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
        $data['start'] = ($data['page'] - 1) * $data['limit'];
        $data['show_featured_image'] = (!empty($settings['show_featured_image'])) ? $settings['show_featured_image'] : null;
        
        if ($this->request->hasQuery('post_category_id') || $this->request->hasPost('post_category_id')) {
            $data['post_category_id'] = $this->request->hasPost('post_category_id') ? $this->request->getPost('post_category_id') : $this->request->getQuery('post_category_id');
            $url = $Url::createUrl("content/category", array('post_category_id' => $data['post_category_id']));
        } else {
            $data['post_category_id'] = (!empty($settings['categories'])) ? $settings['categories'] : null;
        }
        
        $data['image_popup_width'] = (!empty($settings['image_popup_width'])) ? $settings['image_popup_width'] : $this->config->get('config_image_popup_width');
        $data['image_popup_height'] = (!empty($settings['image_popup_height'])) ? $settings['image_popup_height'] : $this->config->get('config_image_popup_height');

        $data['image_thumb_width'] = (!empty($settings['image_thumb_width'])) ? $settings['image_thumb_width'] : $this->config->get('config_image_thumb_width');
        $data['image_thumb_height'] = (!empty($settings['image_thumb_height'])) ? $settings['image_thumb_height'] : $this->config->get('config_image_thumb_height');

        $this->data['posts'] = array();
        
        $func = $this->data['settings']['module'];
        if (!$func || !in_array($func, array('random', 'latest', 'featured', 'recommended', 'related', 'popular'))) $func = 'random';
        $this->prefetch($data, $func);

        $this->data['settings']['view'] = $this->data['settings']['view'] ? $this->data['settings']['view'] : 'list';

        if ($this->data['settings']['show_pagination'] && $this->data['total_posts']) {
            $this->load->library('pagination');
            $pagination = new Pagination(true);
            $pagination->total = $this->data['total_posts'];
            $pagination->page = $data['page'];
            $pagination->limit = $data['limit'];
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = $url . '&page={page}';
            if ($this->data['settings']['endless_scroll']) {
                $pagination->ajax = true;
                $pagination->ajaxTarget = isset($this->data['settings']['endless_scroll_target']) ? $this->data['settings']['endless_scroll_target'] : "#{$widget['name']}_results";
            }
            $this->data['pagination'] = $pagination->render();
        }

        $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $this->data['settings']['view'];
        $this->loadWidgetAssets($filename);

        $this->id = 'post_list';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/post_list.tpl')) {
            $this->template = $this->config->get('config_template') . '/module/post_list.tpl';
        } else {
            $this->template = 'cuyagua/module/post_list.tpl';
        }

        if ($this->request->getQuery('resp') == 'async') {
            $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
        } elseif ($this->request->getQuery('resp') == 'json') {
            $data['payload'] = array(
                'results' => $this->data['posts'],
                'pagination' => $this->data['pagination']
            );

            $this->load->library('json');
            $this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));
        } else {
            $this->render();
        }
    }

    protected function prefetch($data, $func = 'random') {
        $Url = new Url($this->registry);
        $this->load->model('content/post');
        
        switch ($func) {
            case 'random':
            default:
                $results = $this->modelPost->getRandomPost($data);
                $this->data['total_posts'] = $this->modelPost->getAllTotal($data);
                break;
            case 'latest':
                $results = $this->modelPost->getLatestPost($data);
                $this->data['total_posts'] = $this->modelPost->getAllTotal($data);
                break;
            case 'featured':
                $data['post_id'] = $data['featured_posts'];
                $results = $this->modelPost->getAll($data);
                $this->data['total_posts'] = $this->modelPost->getAllTotal($data);
                break;
            case 'recommended':
                $results = $this->modelPost->getRecommendedPost($data);
                $this->data['total_posts'] = $this->modelPost->getTotalRecommendedPost($data);
                break;
            case 'related':
                $results = $this->modelPost->getPostRelated($this->request->getQuery('post_id'), $data);
                $this->data['total_posts'] = $this->modelPost->getTotalPostRelated($this->request->getQuery('post_id'), $data);
                break;
            case 'popular':
                $results = $this->modelPost->getPopularPost($data);
                $this->data['total_posts'] = $this->modelPost->getTotalPopularPost($data);
                break;
        }
        
        $this->load->auto('store/review');
        
        $this->data['posts'] = array();
        foreach ($results as $k => $result) {
            if (isset($data['show_featured_image'])) {
                $image = !empty($result['pimage']) ? $result['pimage'] : 'no_image.jpg';
            }
            
            if ($this->config->get('config_review')) {
                $rating = $this->modelReview->getAllAvg(array(
                    'object_type'=>'post',
                    'object_id'=>$result['post_id']
                ));
            } else {
                $rating = false;
            }
            
            $this->data['posts'][$k] = array(
                'post_id' => $result['post_id'],
                'name' => $result['title'],
                'overview' => $result['meta_description'],
                'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
                'rating' => $rating,
                'stars' => sprintf($this->language->get('text_stars'), $rating),
                'popup' => NTImage::resizeAndSave($image, $data['image_popup_width'], $data['image_popup_height']),
                'thumb' => NTImage::resizeAndSave($image, $data['image_thumb_width'], $data['image_thumb_height']),
                'href' => $Url::createUrl('content/post', array('post_id' => $result['post_id'])),
                'created' => $result['created']
            );
        }
    }
}