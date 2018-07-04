<?php

    $return = array();

    $return['value'] = $this->request->hasPost('value') && !empty($this->request->getPost('value')) ? $this->request->getPost('value') : $data['value'];

    if ($this->request->hasPost('descriptions')) $return['descriptions'] = $this->request->getPost('descriptions');