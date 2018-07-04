<?php

class ControllerModuleReviews extends Module {

    protected function index($widget = null) {
        $this->load->model('store/review');

        $ot = $oid = false;
        if ($this->request->hasQuery('ot')) $ot = $this->request->getQuery('ot');

        if (!$ot && ($this->request->hasQuery('product_id') || $this->request->hasPost('product_id'))) {
            $ot = 'product';
            $oid = $this->request->hasPost('product_id') ? $this->request->getPost('product_id') : $this->request->getQuery('product_id');
        }

        if (!$ot && ($this->request->hasQuery('post_id') || $this->request->hasPost('post_id'))) {
            $ot = 'post';
            $oid = $this->request->hasPost('post_id') ? $this->request->getPost('post_id') : $this->request->getQuery('post_id');
        }

        if (!$ot && ($this->request->hasQuery('page_id') || $this->request->hasPost('page_id'))) {
            $ot = 'page';
            $oid = $this->request->hasPost('page_id') ? $this->request->getPost('page_id') : $this->request->getQuery('page_id');
        }

        if (!$ot && ($this->request->hasQuery('category_id') || $this->request->hasPost('category_id'))) {
            $ot = 'category';
            $oid = $this->request->hasPost('category_id') ? $this->request->getPost('category_id') : $this->request->getQuery('category_id');
        }

        if (!$ot && ($this->request->hasQuery('post_category_id') || $this->request->hasPost('post_category_id'))) {
            $ot = 'post_category';
            $oid = $this->request->hasPost('post_category_id') ? $this->request->getPost('post_category_id') : $this->request->getQuery('post_category_id');
        }

        if (!$ot && ($this->request->hasQuery('manufacturer_id') || $this->request->hasPost('manufacturer_id'))) {
            $ot = 'manufacturer_id';
            $oid = $this->request->hasPost('manufacturer_id') ? $this->request->getPost('manufacturer_id') : $this->request->getQuery('manufacturer_id');
        }

        if ($oid && $ot) {
            $this->language->load('module/reviews');

            if (isset($widget)) {
                $settings = (array)unserialize($widget['settings']);
                $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
            }

            if (!$settings['module'])
                $settings['module'] = 'reviews';

            $average = ($this->config->get('config_review')) ? $this->modelReview->getAverageRating($oid, $ot) : false;
            $this->data['text_stars'] = sprintf($this->language->get('text_stars'), $average);

            $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $settings['view'];
            $this->loadWidgetAssets($filename);

            $this->data['settings'] = $settings;

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/reviews.tpl')) {
                $this->template = $this->config->get('config_template') . '/module/reviews.tpl';
            } else {
                $this->template = 'cuyagua/module/reviews.tpl';
            }

            $this->id = 'reviews';
            $this->render();
        }
    }
}
