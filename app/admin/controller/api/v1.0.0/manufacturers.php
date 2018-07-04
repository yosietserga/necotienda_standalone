<?php

$this->load->auto('store/manufacturer');
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
        $filters['id'] = $filters['manufacturer_id'] = $this->request->getQuery('id'); //unique index

        //text filters
        $filters['name'] = $this->request->getQuery('name');
        $filters['image'] = $this->request->getQuery('image');

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

        $total = $this->modelManufacturer->getAllTotal($filters);
        $results = $this->modelManufacturer->getAll($filters);

        foreach ($results as $l => $result) {
            $id = $result['manufacturer_id'];

            $items[$l] = array(
                'manufacturer_id' => $id,
                'id' => $id,
                'name' => $result['name'],
                'viewed' => $result['viewed'],
                'date_added' => $result['date_added'],
                'image' => $result['image']
            );
        }

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $filters['page'];
        $pagination->limit = $filters['limit'];
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = Url::createAdminUrl('api/v1/manufacturers') . $url . '&page={page}';

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

        $id = $this->modelManufacturer->add($this->prepareData('manufacturers', $this->request->post));

        $return['status'] = array(
            'code'=>200,
            'message'=>'OK'
        );

        $return['error'] = array(
            'code'=>null,
            'message'=>''
        );

        $return['payload'] = array(
            'manufacturer_id'=>$id,
            'id'=>$id
        );
        break;
    case 'put':

        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."manufacturer WHERE manufacturer_id = '". (int)$this->request->getQuery('id') ."'");

        $manufacturer = $query->row;
        $this->request->post = json_decode(file_get_contents('php://input'), true);
        if ($manufacturer['manufacturer_id']) {
            $this->modelManufacturer->update($manufacturer['manufacturer_id'], $this->prepareData('manufacturers', $manufacturer));

            $return['status'] = array(
                'code'=>200,
                'message'=>'OK'
            );

            $return['error'] = array(
                'code'=>null,
                'message'=>''
            );

            $return['payload'] = array(
                'manufacturer_id'=>$manufacturer['manufacturer_id'],
                'id'=>$manufacturer['manufacturer_id']
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
            $this->modelManufacturer->delete($id);
        }
        break;
}