<?php

    $return = array();

    $return['name'] = $this->request->hasPost('name') && !empty($this->request->getPost('name')) ? $this->request->getPost('name') : $data['name'];
    $return['code'] = $this->request->hasPost('code') && !empty($this->request->getPost('code')) ? $this->request->getPost('code') : $data['code'];
    $return['locale'] = $this->request->hasPost('locale') && !empty($this->request->getPost('locale')) ? $this->request->getPost('locale') : $data['locale'];
    $return['directory'] = $this->request->hasPost('directory') && !empty($this->request->getPost('directory')) ? $this->request->getPost('directory') : $data['directory'];
    $return['filename'] = $this->request->hasPost('filename') && !empty($this->request->getPost('filename')) ? $this->request->getPost('filename') : $data['filename'];
    $return['status'] = $this->request->hasPost('status') && !empty($this->request->getPost('status')) ? $this->request->getPost('status') : $data['status'];
