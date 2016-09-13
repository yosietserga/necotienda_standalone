<?php

class ControllerCommonNav extends Controller {

    /**
     * ControllerCommonHeader::index()
     * 
     * @return
     */
    protected function index() {
        $this->load->auto('user/user');
        $image = $this->modelUser->getProperty($this->user->getId(), 'user', 'image');

        if (!empty($image) && file_exists(DIR_IMAGE . $image)) {
            $this->data['avatar'] = NTImage::resizeAndSave($image, 100, 100);
        } else {
            $this->data['avatar'] = NTImage::resizeAndSave('data/profiles/avatar.png', 100, 100);
        }

        $this->data['logged'] = $this->user->validSession();
        
        $this->id = 'navigation';
        $this->template = 'common/nav.tpl';

        $this->render();
    }

}
