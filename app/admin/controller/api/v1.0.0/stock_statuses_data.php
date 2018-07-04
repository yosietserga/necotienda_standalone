<?php

    $return = array();

    $return['language_id'] = $this->request->hasPost('language_id') && !empty($this->request->getPost('language_id')) ? $this->request->getPost('language_id') : $data['language_id'];
    $return['name'] = $this->request->hasPost('name') && !empty($this->request->getPost('name')) ? $this->request->getPost('name') : $data['name'];