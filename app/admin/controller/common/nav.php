<?php

class ControllerCommonNav extends Controller {

    /**
     * ControllerCommonHeader::index()
     * 
     * @return
     */
    protected function index() {
        
        $this->data['logged'] = $this->user->validSession();
        
        $this->id = 'navigation';
        $this->template = 'common/nav.tpl';

        $this->render();
    }

}
