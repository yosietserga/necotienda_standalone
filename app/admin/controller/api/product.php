<?php

class ControllerApiProduct extends Controller {

    public function get() {
        $this->load->model('store/product');
        $product_id = isset($this->request->get['id']) ? (int) $this->request->get['id'] : 0;
        $product_info = $this->modelProduct->getProduct($product_id);
    }

    protected function error404() {
        header("HTTP/1.0 404 Not Found", true, 404);
        $this->data['response'] = '404';
        $this->data['error'] = 'Product not found';

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
        $this->setHeaders();
        $this->load->library('json');
        if (($this->request->server['REQUEST_METHOD'] == 'GET')) {
            $cached = $this->cache->get('product.admin.api.json.all');

            if ($cached) {
                echo $cached;
            } else {
                $filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
                $filter_model = isset($this->request->get['filter_model']) ? $this->request->get['filter_model'] : null;
                $filter_quantity = isset($this->request->get['filter_quantity']) ? $this->request->get['filter_quantity'] : null;
                $filter_status = isset($this->request->get['filter_status']) ? $this->request->get['filter_status'] : null;
                $filter_date_start = isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
                $filter_date_end = isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
                $page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
                $sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'pd.name';
                $order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
                $limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');

                $data = array(
                    'filter_name' => $filter_name,
                    'filter_model' => $filter_model,
                    'filter_quantity' => $filter_quantity,
                    'filter_status' => $filter_status,
                    'filter_date_start' => $filter_date_start,
                    'filter_date_end' => $filter_date_end,
                    'sort' => $sort,
                    'order' => $order,
                    'start' => ($page - 1) * $limit,
                    'limit' => $limit
                );

                $this->load->auto('store/product');
                $this->load->auto('library');

                //$this->data['total'] = $this->modelProduct->getAllTotal($data);
                $results = $this->modelProduct->getAll($data);

                foreach ($results as $result) {
                    if ($result['pimage'] && file_exists(DIR_IMAGE . $result['pimage'])) {
                        $image = NTImage::resizeAndSave($result['pimage'], 40, 40);
                    } else {
                        $image = NTImage::resizeAndSave('no_image.jpg', 40, 40);
                    }

                    $this->data['products'][] = array(
                        'product_id' => $result['product_id'],
                        'id' => $result['product_id'],
                        'name' => $result['pname'],
                        'model' => $result['model'],
                        'meta_keywords' => $result['meta_keywords'],
                        'meta_description' => $result['meta_description'],
                        'description' => $result['pdescription'],
                        'sku' => $result['sku'],
                        'ssname' => $result['ssname'],
                        'mname' => $result['mname'],
                        'shipping' => $result['shipping'],
                        'price' => $result['price'],
                        'tctitle' => $result['tctitle'],
                        'date_available' => $result['date_available'],
                        'weight' => $result['weight'],
                        'wctitle' => $result['wctitle'],
                        'length' => $result['length'],
                        'width' => $result['width'],
                        'height' => $result['height'],
                        'lctitle' => $result['lctitle'],
                        'date_added' => $result['date_added'],
                        'date_modified' => $result['date_modified'],
                        'viewed' => $result['viewed'],
                        'subtract' => $result['subtract'],
                        'minimum' => $result['minimum'],
                        'cost' => $result['cost'],
                        'sort_order' => $result['sort_order'],
                        'image' => $image,
                        'quantity' => $result['quantity'],
                        'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
                        'selected' => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected'])
                    );
                }
                /*
                $this->data['filters']['name'] = $filter_name;
                $this->data['filters']['model'] = $filter_model;
                $this->data['filters']['qty'] = $filter_quantity;
                $this->data['filters']['status'] = $filter_status;
                 * 
                 */

                //$this->cache->set('product.admin.api.json.all', Json::encode($this->data));
            }
        } else {
            $this->error401();
        }

        var_dump(headers_list());
        flush();
        ob_end_flush();
        headers_sent($f, $l);
        echo $f . ': ' . $l;
        var_dump(get_headers(HTTP_CATALOG, 1));
        header('Location:http://www.google.com');
        $this->response->setOutput(Json::encode($this->data), $this->config->get('config_compression'));
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
        if (!headers_sent()) {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Content-Type");
            header("Access-Control-Allow-Methods: GET");
            header("Content-Type: application/json");
        } else {
            return false;
        }
    }

}
