<?php

$this->load->auto('localisation/language');
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
        $filters['id'] = $filters['language_id'] = $this->request->getQuery('id'); //unique index

        //text filters
        $filters['name'] = $this->request->getQuery('name');
        $filters['code'] = $this->request->getQuery('code');
        $filters['locale'] = $this->request->getQuery('locale');
        $filters['directory'] = $this->request->getQuery('directory');
        $filters['filename'] = $this->request->getQuery('filename');

        //state filters
        $filters['status'] = $this->request->getQuery('status');

        $filters['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
        $filters['sort'] = $this->request->hasQuery('sort') ? $this->request->getQuery('sort') : 't.name';
        $filters['order'] = $this->request->hasQuery('order') ? $this->request->getQuery('order') : 'ASC';
        $filters['limit'] = $this->request->hasQuery('limit') ? $this->request->getQuery('limit') : $this->config->get('config_admin_limit');

        $url = '';
        if ($this->request->hasQuery('id')) $url .= '&id=' . $this->request->getQuery('id');
        if ($this->request->hasQuery('name')) $url .= '&name=' . $this->request->getQuery('name');
        if ($this->request->hasQuery('code')) $url .= '&code=' . $this->request->getQuery('code');
        if ($this->request->hasQuery('locale')) $url .= '&locale=' . $this->request->getQuery('locale');
        if ($this->request->hasQuery('directory')) $url .= '&directory=' . $this->request->getQuery('directory');
        if ($this->request->hasQuery('filename')) $url .= '&filename=' . $this->request->getQuery('filename');
        if ($this->request->hasQuery('status')) $url .= '&status=' . $this->request->getQuery('status');
        if ($this->request->hasQuery('page')) $url .= '&page=' . $this->request->getQuery('page');
        if ($this->request->hasQuery('sort')) $url .= '&sort=' . $this->request->getQuery('sort');
        if ($this->request->hasQuery('limit')) $url .= '&limit=' . $this->request->getQuery('limit');

        $total = $this->modelLanguage->getAllTotal($filters);
        $results = $this->modelLanguage->getAll($filters);

        foreach ($results as $l => $result) {
            $id = $result['language_id'];

            $items[$l] = array(
                'language_id' => $id,
                'id' => $id,
                'name' => $result['name'],
                'code' => $result['code'],
                'locale' => $result['locale'],
                'directory' => $result['directory'],
                'filename' => $result['filename'],
                'image' => $result['image'],
                'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'))
            );
        }

        $pagination = new Pagination();
        $pagination->total = $total;
        $pagination->page = $filters['page'];
        $pagination->limit = $filters['limit'];
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = Url::createAdminUrl('api/v1/languages') . $url . '&page={page}';

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

        $id = $this->modelLanguage->add($this->prepareData('languages', $this->request->post));

        $return['status'] = array(
            'code'=>200,
            'message'=>'OK'
        );

        $return['error'] = array(
            'code'=>null,
            'message'=>''
        );

        $return['payload'] = array(
            'language_id'=>$id,
            'id'=>$id
        );
        break;
    case 'put':

        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."language WHERE language_id = '". (int)$this->request->getQuery('id') ."'");

        $language = $query->row;
        $this->request->post = json_decode(file_get_contents('php://input'), true);
        if ($language['language_id']) {
            $this->modelLanguage->update($language['language_id'], $this->prepareData('languages', $language));

            $return['status'] = array(
                'code'=>200,
                'message'=>'OK'
            );

            $return['error'] = array(
                'code'=>null,
                'message'=>''
            );

            $return['payload'] = array(
                'language_id'=>$language['language_id'],
                'id'=>$language['language_id']
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
            $this->modelLanguage->delete($id);
        }
        break;
}