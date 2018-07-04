<?php

$this->load->auto('localisation/weightclass');
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
        $filters['id'] = $filters['length_class_id'] = $this->request->getQuery('id'); //unique index

        //text filters
        $filters['title'] = $this->request->getQuery('title');
        if ($this->request->getQuery('title') || $this->request->getQuery('q')) {
            $filters['queries'] = $this->request->getQuery('title') != $this->request->getQuery('q') ?
                explode(' ', $this->request->getQuery('title') .' '. $this->request->getQuery('q')) : $this->request->getQuery('q');
            $filters['search_in_description'] = $this->request->getQuery('search_in_description');
        }


        $filters['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
        $filters['sort'] = $this->request->hasQuery('sort') ? $this->request->getQuery('sort') : 'td.title';
        $filters['order'] = $this->request->hasQuery('order') ? $this->request->getQuery('order') : 'ASC';
        $filters['limit'] = $this->request->hasQuery('limit') ? $this->request->getQuery('limit') : $this->config->get('config_admin_limit');

        $url = '';
        if ($this->request->hasQuery('id')) $url .= '&id=' . $this->request->getQuery('id');
        if ($this->request->hasQuery('q')) $url .= '&q=' . $this->request->getQuery('q');
        if ($this->request->hasQuery('title')) $url .= '&title=' . $this->request->getQuery('title');
        if ($this->request->hasQuery('status')) $url .= '&status=' . $this->request->getQuery('status');
        if ($this->request->hasQuery('page')) $url .= '&page=' . $this->request->getQuery('page');
        if ($this->request->hasQuery('sort')) $url .= '&sort=' . $this->request->getQuery('sort');
        if ($this->request->hasQuery('limit')) $url .= '&limit=' . $this->request->getQuery('limit');

        $total = $this->modelWeightclass->getAllTotal($filters);
        $results = $this->modelWeightclass->getAll($filters);

        foreach ($results as $l => $result) {
            $id = $result['length_class_id'];

            $items[$l] = array(
                'length_class_id' => $id,
                'id' => $id,
                'value' => $result['value']
            );

            $items[$l]['descriptions'] = $this->modelWeightclass->getDescriptions($id);
        }

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $filters['page'];
        $pagination->limit = $filters['limit'];
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = Url::createAdminUrl('api/v1/length_classes') . $url . '&page={page}';

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

        $id = $this->modelWeightclass->add($this->prepareData('length_classes', $this->request->post));

        $return['status'] = array(
            'code'=>200,
            'message'=>'OK'
        );

        $return['error'] = array(
            'code'=>null,
            'message'=>''
        );

        $return['payload'] = array(
            'length_class_id'=>$id,
            'id'=>$id
        );
        break;
    case 'put':

        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."length_class WHERE length_class_id = '". (int)$this->request->getQuery('id') ."'");

        $length_class = $query->row;
        $this->request->post = json_decode(file_get_contents('php://input'), true);
        if ($length_class['length_class_id']) {
            $this->modelWeightclass->update($length_class['length_class_id'], $this->prepareData('length_classes', $length_class));

            $return['status'] = array(
                'code'=>200,
                'message'=>'OK'
            );

            $return['error'] = array(
                'code'=>null,
                'message'=>''
            );

            $return['payload'] = array(
                'length_class_id'=>$length_class['length_class_id'],
                'id'=>$length_class['length_class_id']
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
            $this->modelWeightclass->delete($id);
        }
        break;
}