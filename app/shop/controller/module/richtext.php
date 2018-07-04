<?php

class ControllerModuleRichText extends Module {

    protected function index($widget = null) {
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'richtext';
        $this->data['settings']['width'] = isset($this->data['settings']['width']) ? $this->data['settings']['width'] : 80;
        $this->data['settings']['height'] = isset($this->data['settings']['height']) ? $this->data['settings']['height'] : 80;

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        if ((int) $settings['post_id']) {
            $this->load->model('content/page');
            $this->data['page'] = $this->modelPage->getById($settings['post_id']);

            

            $this->id = 'richtext';

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/richtext.tpl')) {
                $this->template = $this->config->get('config_template') . '/module/richtext.tpl';
            } else {
                $this->template = 'cuyagua/module/richtext.tpl';
            }

            $this->render();
        }
    }
}
