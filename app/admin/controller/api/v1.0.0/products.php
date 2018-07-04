<?php

$this->load->auto('store/product');
$this->load->auto('store/review');
$this->load->auto('store/attribute');
$this->load->auto('image');
$this->load->auto('json');

$return = array();
$request_type = $this->request->server['REQUEST_METHOD'];

switch(strtolower($request_type)) {
    case 'get':
    default:
        $this->load->auto('pagination');

        $filters = array();
        $items = array();

        //int indexes
        $filters['id'] = $filters['product_id'] = $this->request->getQuery('id'); //unique index
        $filters['category_id'] = $this->request->getQuery('category_id');
        $filters['manufacturer_id'] = $this->request->getQuery('manufacturer_id');
        $filters['language_id'] = $this->request->getQuery('language_id');
        $filters['store_id'] = $this->request->getQuery('store_id');
        $filters['length_class_id'] = $this->request->getQuery('length_class_id');
        $filters['weight_class_id'] = $this->request->getQuery('weight_class_id');
        $filters['stock_status_id'] = $this->request->getQuery('stock_status_id');

        //text filters
        $filters['type'] = $this->request->getQuery('type');
        $filters['model'] = $this->request->getQuery('model'); //unique index

        $filters['title'] = $this->request->getQuery('title');
        if ($this->request->getQuery('title') || $this->request->getQuery('q')) {
            $filters['queries'] = $this->request->getQuery('title') != $this->request->getQuery('q') ?
                explode(' ', $this->request->getQuery('title') .' '. $this->request->getQuery('q')) : $this->request->getQuery('q');
            $filters['search_in_description'] = $this->request->getQuery('search_in_description');
        }

        $filters['price'] = $this->request->getQuery('price');
        $filters['from_price'] = $this->request->getQuery('from_price');
        $filters['to_price'] = $this->request->getQuery('to_price');
        $filters['quantity'] = $this->request->getQuery('quantity');
        $filters['from_quantity'] = $this->request->getQuery('from_quantity');
        $filters['to_quantity'] = $this->request->getQuery('to_quantity');

        //state filters
        $filters['status'] = $this->request->getQuery('status');
        $filters['publish_date_start'] = $this->request->getQuery('publish_date_start');
        $filters['publish_date_end'] = $this->request->getQuery('publish_date_end');

        $filters['date_start'] = $this->request->getQuery('date_start');
        $filters['date_end'] = $this->request->getQuery('date_end');

        $filters['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
        $filters['sort'] = $this->request->hasQuery('sort') ? $this->request->getQuery('sort') : 'td.title';
        $filters['order'] = $this->request->hasQuery('order') ? $this->request->getQuery('order') : 'ASC';
        $filters['limit'] = $this->request->hasQuery('limit') ? $this->request->getQuery('limit') : $this->config->get('config_admin_limit');

        $url = '';
        if ($this->request->hasQuery('q')) $url .= '&q=' . $this->request->getQuery('q');
        if ($this->request->hasQuery('id')) $url .= '&id=' . $this->request->getQuery('id');
        if ($this->request->hasQuery('category_id')) $url .= '&category_id=' . $this->request->getQuery('category_id');
        if ($this->request->hasQuery('manufacturer_id')) $url .= '&manufacturer_id=' . $this->request->getQuery('manufacturer_id');
        if ($this->request->hasQuery('language_id')) $url .= '&language_id=' . $this->request->getQuery('language_id');
        if ($this->request->hasQuery('store_id')) $url .= '&store_id=' . $this->request->getQuery('store_id');
        if ($this->request->hasQuery('length_class_id')) $url .= '&length_class_id=' . $this->request->getQuery('length_class_id');
        if ($this->request->hasQuery('weight_class_id')) $url .= '&weight_class_id=' . $this->request->getQuery('weight_class_id');
        if ($this->request->hasQuery('stock_status_id')) $url .= '&stock_status_id=' . $this->request->getQuery('stock_status_id');
        if ($this->request->hasQuery('type')) $url .= '&type=' . $this->request->getQuery('type');
        if ($this->request->hasQuery('title')) $url .= '&title=' . $this->request->getQuery('title');
        if ($this->request->hasQuery('model')) $url .= '&model=' . $this->request->getQuery('model');
        if ($this->request->hasQuery('quantity')) $url .= '&quantity=' . $this->request->getQuery('quantity');
        if ($this->request->hasQuery('from_quantity')) $url .= '&from_quantity=' . $this->request->getQuery('from_quantity');
        if ($this->request->hasQuery('to_quantity')) $url .= '&to_quantity=' . $this->request->getQuery('to_quantity');
        if ($this->request->hasQuery('price')) $url .= '&price=' . $this->request->getQuery('price');
        if ($this->request->hasQuery('from_price')) $url .= '&from_price=' . $this->request->getQuery('from_price');
        if ($this->request->hasQuery('to_price')) $url .= '&to_price=' . $this->request->getQuery('to_price');
        if ($this->request->hasQuery('status')) $url .= '&status=' . $this->request->getQuery('status');
        if ($this->request->hasQuery('page')) $url .= '&page=' . $this->request->getQuery('page');
        if ($this->request->hasQuery('sort')) $url .= '&sort=' . $this->request->getQuery('sort');
        if ($this->request->hasQuery('limit')) $url .= '&limit=' . $this->request->getQuery('limit');
        if ($this->request->hasQuery('date_end')) $url .= '&date_end=' . $this->request->getQuery('date_end');
        if ($this->request->hasQuery('date_start')) $url .= '&date_start=' . $this->request->getQuery('date_start');
        if ($this->request->hasQuery('publish_date_start')) $url .= '&publish_date_start=' . $this->request->getQuery('publish_date_start');
        if ($this->request->hasQuery('publish_date_end')) $url .= '&publish_date_end=' . $this->request->getQuery('publish_date_end');

        $total = $this->modelProduct->getAllTotal($filters);
        $results = $this->modelProduct->getAll($filters);

        foreach ($results as $l => $result) {
            if ($result['pimage'] && file_exists(DIR_IMAGE . $result['pimage'])) {
                $image = NTImage::resizeAndSave($result['pimage'], 100, 100);
            } else {
                $image = NTImage::resizeAndSave('no_image.jpg', 100, 100);
            }

            $id = $result['pid'];

            $items[$l] = array(
                'product_id' => $id,
                'id' => $id,
                'model' => $result['model'],
                'title' => $result['pname'],
                'meta_keywords' => $result['meta_keywords'],
                'meta_description' => $result['meta_description'],
                'description' => $result['pdescription'],
                'sku' => $result['sku'],
                'stock_status' => $result['ssname'],
                'manufacturer' => $result['mname'],
                'shipping' => $result['shipping'],
                'price' => $result['price'],
                'tax_class' => $result['tctitle'],
                'date_available' => $result['date_available'],
                'weight' => $result['weight'],
                'weight_class' => $result['wctitle'],
                'length' => $result['length'],
                'width' => $result['width'],
                'height' => $result['height'],
                'length_class' => $result['lctitle'],
                'date_added' => $result['created'],
                'date_modified' => $result['date_modified'],
                'viewed' => $result['viewed'],
                'subtract' => $result['subtract'],
                'minimum' => $result['minimum'],
                'cost' => $result['cost'],
                'sort_order' => $result['sort_order'],
                'image' => $image,
                'quantity' => $result['quantity'],
                'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'))
            );

            $items[$l]['stores'] = $this->modelProduct->getStores($id);
            $items[$l]['customer_groups'] = $this->modelProduct->getProperty($id, 'customer_groups', 'customer_groups');
            $items[$l]['descriptions'] = $this->modelProduct->getDescriptions($id);
            $items[$l]['tags'] = $this->modelProduct->getTags($id);
            $items[$l]['options'] = $this->modelProduct->getOptions($id);
            $items[$l]['discounts'] = $this->modelProduct->getDiscounts($id);
            $items[$l]['specials'] = $this->modelProduct->getSpecials($id);
            $items[$l]['downloads'] = $this->modelProduct->getDownloads($id);
            $items[$l]['categories'] = $this->modelProduct->getCategories($id);
            $items[$l]['related'] = $this->modelProduct->getRelated($id);
            $items[$l]['rating'] = round($this->modelReview->getAllAvg(array(
                'object_id'=>$id,
                'object_type'=>'product'
            )), 0);

            /* product attributes */
            $items[$l]['attributes'] = array();
            $this->load->auto('store/attribute');
            foreach ($this->modelProduct->getAllProperties( $id, 'attribute' ) as $attribute) {
                list($name, $attribute_id, $attribute_group_id) = explode(':', $attribute['key']);
                $attrValues[$attribute_group_id][$attribute_id] = $attribute['value'];
            }

            foreach ($attrValues as $att_idx => $attr) {
                $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."product_attribute_group WHERE product_attribute_group_id = ". (int)$att_idx);
                $attribute_group = $query->row;

                $rows = $this->modelAttribute->getAll(array(
                    'product_attribute_group_id'=>$att_idx
                ));
                $items[$l]['attributes'][$att_idx] = $rows[0];
                $items[$l]['attributes'][$att_idx]['categoriesAttributes'] = array_unique($this->modelProduct->getCategoriesByAttributeGroupId($att_idx));
                foreach ($items[$l]['attributes'][$att_idx]['attributes'] as $j => $attribute) {
                    $items[$l]['attributes'][$att_idx]['attributes'][$j]['value'] = $attr[$attribute['product_attribute_id']];
                }
            }
            /* /product attributes */

            /* product images */
            $items[$l]['images'] = array();
            $results = $this->modelProduct->getImages($id);
            foreach ($results as $result) {
                if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                    $items[$l]['images'][] = array(
                        'preview' => NTImage::resizeAndSave($result['image'], 100, 100),
                        'file' => HTTP_IMAGE . $result['image']
                    );
                } else {
                    $items[$l]['images'][] = array(
                        'preview' => NTImage::resizeAndSave('no_image.jpg', 100, 100),
                        'file' => HTTP_IMAGE . $result['image']
                    );
                }
            }
            /* /product images */

        }

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $filters['page'];
        $pagination->limit = $filters['limit'];
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = Url::createAdminUrl('api/v1/products') . $url . '&page={page}';

        $return['status'] = array(
            'code'=>200,
            'message'=>'OK'
        );

        $return['error'] = array(
            'code'=>null,
            'message'=>''
        );

        $return['payload'] = array(
            'results'=>$items,
            'filters'=>$filters,
            'pagination'=>$pagination->render(),
            'total'=>$total
        );
    break;

    case 'post':
        $this->request->post = json_decode(file_get_contents('php://input'), true);

        $id = $this->modelProduct->add($this->prepareData('products', $this->request->post));

        $return['status'] = array(
            'code'=>200,
            'message'=>'OK'
        );

        $return['error'] = array(
            'code'=>null,
            'message'=>''
        );

        $return['payload'] = array(
            'product_id'=>$id,
            'id'=>$id
        );
        break;
    case 'put':
        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."product WHERE product_id = '". (int)$this->request->getQuery('id') ."'");

        $product = $query->row;
        $this->request->post = json_decode(file_get_contents('php://input'), true);
        if ($product['product_id']) {
            $this->modelProduct->update($product['product_id'], $this->prepareData('products', $product));

            $return['status'] = array(
                'code'=>200,
                'message'=>'OK'
            );

            $return['error'] = array(
                'code'=>null,
                'message'=>''
            );

            $return['payload'] = array(
                'product_id'=>$product['product_id'],
                'id'=>$product['product_id']
            );
        } else {
            $this->error404();
            return;
        }
        break;
    case 'delete':
        $this->request->post = json_decode(file_get_contents('php://input'), true);
        $id = $this->request->hasPost('id') ? $this->request->getPost('id') : $this->request->getQuery('id');
        $ids = (is_array($id)) ? $id : array($id);
        foreach ($ids as $id) {
            if (!(int)$id) continue;
            $this->modelProduct->delete($id);
        }
        break;
}