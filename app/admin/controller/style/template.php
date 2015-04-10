<?php

/**
 * ControllerStyleTemplate
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerStyleTemplate extends Controller {

    private $error = array();

    /**
     * ControllerStyleTemplate::index()
     * 
     * @see Load
     * @see Document
     * @see Language
     * @see getList
     * @return void
     */
    public function index() {
        $this->load->auto('json');
        $response = Json::decode($this->fetchUrl('http://www.necotienda.org/api/index.php?r=style/template/get'));
        if ($response['response_code']===200) {
            $this->data['templates'] = $response['data']['data'];
        }
        
        $this->template = 'style/template_list.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }
    
    public function install() {}
    public function uninstall() {}
    public function update() {}
    public function buy() {}
    public function download() {}

    private function fetchUrl($url) {
        $curl_handle=curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:20.0) Gecko/20100101 Firefox/20.0');
        $response = curl_exec($curl_handle);
        curl_close($curl_handle);
        return $response;
    }


}
