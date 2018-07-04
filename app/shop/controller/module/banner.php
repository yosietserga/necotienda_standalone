<?php

class ControllerModuleBanner extends Module {

    protected function index($widget = null) {
        $this->language->load('module/banner');

        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        if (!$this->data['settings']['module'])
            $this->data['settings']['module'] = 'banner';
        $this->data['settings']['width'] = isset($this->data['settings']['width']) ? $this->data['settings']['width'] : '180px';
        $this->data['settings']['height'] = isset($this->data['settings']['height']) ? $this->data['settings']['height'] : 80;

        $this->data['heading_title'] = isset($settings['title']) ? $settings['title'] : $this->language->get('heading_title');

        if ((int) $settings['banner_id']) {
            $this->data['Image'] = new NTImage;
            $this->load->model('content/banner');
            $this->data['banner'] = $this->modelBanner->getById($settings['banner_id']);

            if (!empty($this->data['banner']['jquery_plugin'])) {

                $this->data['banner']['style'] = "width: ". $this->data['settings']['width'] .";";
                $this->data['banner']['style'] .= "margin: ". $this->data['settings']['margin'] .";";
                $this->data['banner']['style'] .= "padding: ". $this->data['settings']['padding'] .";";
                $this->data['banner']['style'] .= ($settings['float']) ? "float: left;" : "";

                if (file_exists(DIR_JS .'sliders/'. $this->data['banner']['jquery_plugin'] .'/slider.js')) {
                    $this->javascripts = array_merge($this->javascripts, array($this->data['banner']['jquery_plugin'] => HTTP_JS .'sliders/'. $this->data['banner']['jquery_plugin'] .'/slider.js'));
                }
                if (file_exists(DIR_CSS .'sliders/'. $this->data['banner']['jquery_plugin'] .'/slider.css')) {
                    $this->styles = array_merge($this->styles, array(array(
                        'href'=> HTTP_CSS .'sliders/'. $this->data['banner']['jquery_plugin'] .'/slider.css',
                        'media'=>'all'
                    )));
                }
                $filename = $controller = str_replace('controller', '', strtolower(__CLASS__)) . $this->data['banner']['jquery_plugin'];
                $this->loadWidgetAssets($filename);

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/banner/' . $this->data['banner']['jquery_plugin'] . '.tpl')) {
                    $this->template = $this->config->get('config_template') . '/banner/' . $this->data['banner']['jquery_plugin'] . '.tpl';
                } else {
                    $this->template = 'cuyagua/banner/nivo-slider.tpl';
                }
            }

            $this->id = 'banner';
            $this->render();
        }
    }

    public function carousel() {
        $json = array();
        $this->load->model('content/banner');
        $this->load->auto('image');
        $this->load->auto('json');

        $this->data['Image'] = new NTImage;
        $banner = $this->modelBanner->getById($this->request->getQuery('banner_id'));
        $json['results'] = $banner['items'];

        $width = isset($_GET['width']) ? $_GET['width'] : 80;
        $height = isset($_GET['height']) ? $_GET['height'] : 80;
        foreach ($json['results'] as $k => $v) {
            if (!file_exists(DIR_IMAGE . $v['image']))
                $json['results'][$k]['image'] = HTTP_IMAGE . "no_image.jpg";
            $json['results'][$k]['thumb'] = NTImage::resizeAndSave($v['image'], $width, $height);
            $json['results'][$k]['title'] = $v['title'];
            $json['results'][$k]['description'] = $v['description'];
            $json['results'][$k]['link'] = $v['link'];
        }

        if (!count($json['results']))
            $json['error'] = 1;

        $this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
    }
}
