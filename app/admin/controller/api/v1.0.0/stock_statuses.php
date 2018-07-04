<?php

$this->load->auto('localisation/stockstatus');
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
        $filters['id'] = $filters['stock_status_id'] = $this->request->getQuery('id'); //unique index

        //text filters
        $filters['name'] = $this->request->getQuery('name');

        $filters['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
        $filters['sort'] = $this->request->hasQuery('sort') ? $this->request->getQuery('sort') : 't.name';
        $filters['order'] = $this->request->hasQuery('order') ? $this->request->getQuery('order') : 'ASC';
        $filters['limit'] = $this->request->hasQuery('limit') ? $this->request->getQuery('limit') : $this->config->get('config_admin_limit');

        $url = '';
        if ($this->request->hasQuery('id')) $url .= '&id=' . $this->request->getQuery('id');
        if ($this->request->hasQuery('name')) $url .= '&name=' . $this->request->getQuery('name');
        if ($this->request->hasQuery('status')) $url .= '&status=' . $this->request->getQuery('status');
        if ($this->request->hasQuery('page')) $url .= '&page=' . $this->request->getQuery('page');
        if ($this->request->hasQuery('sort')) $url .= '&sort=' . $this->request->getQuery('sort');
        if ($this->request->hasQuery('limit')) $url .= '&limit=' . $this->request->getQuery('limit');

        $total = $this->modelStockstatus->getAllTotal($filters);
        $results = $this->modelStockstatus->getAll($filters);

        foreach ($results as $l => $result) {
            $id = $result['stock_status_id'];

            $items[$l] = array(
                'stock_status_id' => $id,
                'id' => $id,
                'language_id' => $result['language_id'],
                'name' => $result['name']
            );
        }

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $filters['page'];
        $pagination->limit = $filters['limit'];
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = Url::createAdminUrl('api/v1/stock_statuses') . $url . '&page={page}';

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

        $id = $this->modelStockstatus->add($this->prepareData('stock_statuses', $this->request->post));

        $return['status'] = array(
            'code'=>200,
            'message'=>'OK'
        );

        $return['error'] = array(
            'code'=>null,
            'message'=>''
        );

        $return['payload'] = array(
            'stock_status_id'=>$id,
            'id'=>$id
        );
        break;
    case 'put':

        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."stock_status WHERE stock_status_id = '". (int)$this->request->getQuery('id') ."'");

        $stock_status = $query->row;
        $this->request->post = json_decode(file_get_contents('php://input'), true);
        if ($stock_status['stock_status_id']) {
            $this->modelStockstatus->update($stock_status['stock_status_id'], $this->prepareData('stock_statuses', $stock_status));

            $return['status'] = array(
                'code'=>200,
                'message'=>'OK'
            );

            $return['error'] = array(
                'code'=>null,
                'message'=>''
            );

            $return['payload'] = array(
                'stock_status_id'=>$stock_status['stock_status_id'],
                'id'=>$stock_status['stock_status_id']
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
            $this->modelStockstatus->delete($id);
        }
        break;
}