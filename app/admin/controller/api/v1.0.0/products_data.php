<?php

    $return = array();

    //TODO: check if the model is unique
    $return['model'] = $this->request->hasPost('model') && !empty($this->request->getPost('model')) ? $this->request->getPost('model') : $data['model'];

    $return['sku'] = $this->request->hasPost('sku') ? $this->request->getPost('sku') : $data['sku'];
    $return['price'] = $this->request->hasPost('price') ? $this->request->getPost('price') : $data['price'];
    $return['date_available'] = $this->request->hasPost('date_available') && !empty($this->request->getPost('date_available')) ? $this->request->getPost('date_available') : $data['date_available'];
    $return['weight'] = $this->request->hasPost('weight') ? $this->request->getPost('weight') : $data['weight'];
    $return['length'] = $this->request->hasPost('length') ? $this->request->getPost('length') : $data['length'];
    $return['width'] = $this->request->hasPost('width') ? $this->request->getPost('width') : $data['width'];
    $return['height'] = $this->request->hasPost('height') ? $this->request->getPost('height') : $data['height'];
    $return['subtract'] = $this->request->hasPost('subtract') ? $this->request->getPost('subtract') : $data['subtract'];
    $return['minimum'] = $this->request->hasPost('minimum') ? $this->request->getPost('minimum') : $data['minimum'];
    $return['cost'] = $this->request->hasPost('cost') ? $this->request->getPost('cost') : $data['cost'];
    $return['image'] = $this->request->hasPost('image') ? $this->request->getPost('image') : $data['image'];
    $return['quantity'] = $this->request->hasPost('quantity') ? $this->request->getPost('quantity') : $data['quantity'];
    $return['status'] = $this->request->hasPost('status') ? $this->request->getPost('status') : $data['status'];

    if ($this->request->hasPost('stores')) $return['stores'] = $this->request->getPost('stores');
    if ($this->request->hasPost('tags')) $return['tags'] = $this->request->getPost('tags');
    if ($this->request->hasPost('options')) $return['options'] = $this->request->getPost('options');
    if ($this->request->hasPost('discounts')) $return['discounts'] = $this->request->getPost('discounts');
    if ($this->request->hasPost('specials')) $return['specials'] = $this->request->getPost('specials');
    if ($this->request->hasPost('downloads')) $return['downloads'] = $this->request->getPost('downloads');
    if ($this->request->hasPost('related')) $return['related'] = $this->request->getPost('related');
    if ($this->request->hasPost('images')) $return['images'] = $this->request->getPost('images');
    if ($this->request->hasPost('categories')) $return['categories'] = $this->request->getPost('categories');
    if ($this->request->hasPost('attributes')) $return['attributes'] = $this->request->getPost('attributes');
    if ($this->request->hasPost('descriptions')) $return['descriptions'] = $this->request->getPost('descriptions');
    if ($this->request->hasPost('customer_groups')) $return['customer_groups'] = $this->request->getPost('customer_groups');