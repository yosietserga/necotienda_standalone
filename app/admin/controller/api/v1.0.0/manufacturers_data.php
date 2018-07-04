<?php

    $return = array();

    $return['name'] = $this->request->hasPost('name') && !empty($this->request->getPost('name')) ? $this->request->getPost('name') : $data['name'];
    $return['image'] = $this->request->hasPost('image') ? $this->request->getPost('code') : $data['code'];

    if ($this->request->hasPost('stores')) $return['stores'] = $this->request->getPost('stores');