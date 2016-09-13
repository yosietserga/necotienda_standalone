<?php

class ControllerCommonHome extends Controller {

    public function index() {
        //tracker
        $this->tracker->track(0, 'home_page');

        if ($this->session->has('ref_email') && !$this->session->has('ref_cid')) {
            $this->data['show_register_form_invitation'] = true;
        }

        $Url = new Url($this->registry);
        $cached = $this->cache->get('home_page.' .
                $this->config->get('config_language_id') . "." .
                $this->request->getQuery('hl') . "." .
                $this->request->getQuery('cc') . "." .
                $this->customer->getId() . "." .
                $this->config->get('config_currency') . "." .
                (int) $this->config->get('config_store_id')
        );
        $this->load->library('user');
        if ($cached && !$this->user->isLogged()) {
            $this->response->setOutput($cached, $this->config->get('config_compression'));
        } else {
            $this->document->title = $this->config->get('config_title_' . $this->config->get('config_language_id'));
            $this->document->description = $this->config->get('config_meta_description_' . $this->config->get('config_language_id'));

            if (!$this->user->isLogged()) {
                $this->cacheId = 'home_page.' .
                        $this->config->get('config_language_id') . "." .
                        $this->request->getQuery('hl') . "." .
                        $this->request->getQuery('cc') . "." .
                        $this->customer->getId() . "." .
                        $this->config->get('config_currency') . "." .
                        (int) $this->config->get('config_store_id');
            }

            $this->loadWidgets();

            if ($scripts)
                $this->scripts = array_merge($this->scripts, $scripts);

            $this->children[] = 'common/nav';
            $this->children[] = 'common/header';
            $this->children[] = 'common/column_left';
            $this->children[] = 'common/column_right';
            $this->children[] = 'common/footer';

            $template = ($this->config->get('default_view_home')) ? $this->config->get('default_view_home') : 'common/home.tpl';
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
                $this->template = $this->config->get('config_template') . '/' . $template;
            } else {
                $this->template = 'cuyagua/' . $template;
            }

            $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
        }
    }

    protected function loadWidgets() {
        $this->load->helper('widgets');
        $widgets = new NecoWidget($this->registry, $this->Route);
        foreach ($widgets->getWidgets('main') as $widget) {
            $settings = (array) unserialize($widget['settings']);
            if ($settings['asyn']) {
                $url = Url::createUrl("{$settings['route']}", $settings['params']);
                $scripts[$widget['name']] = array(
                    'id' => $widget['name'],
                    'method' => 'ready',
                    'script' =>
                    "$(document.createElement('div'))
                        .attr({
                            id:'" . $widget['name'] . "'
                        })
                        .html(makeWaiting())
                        .load('" . $url . "')
                        .appendTo('" . $settings['target'] . "');"
                );
            } else {
                if (isset($settings['route'])) {
                    if (($this->browser->isMobile() && $settings['showonmobile']) || (!$this->browser->isMobile() && $settings['showondesktop'])) {
                        if ($settings['autoload']) {
                            $this->data['widgets'][] = $widget['name'];
                        }
                        
                        $this->children[$widget['name']] = $settings['route'];
                        $this->widget[$widget['name']] = $widget;
                    }
                }
            }
        }

        foreach ($widgets->getWidgets('featuredContent') as $widget) {
            $settings = (array) unserialize($widget['settings']);
            if ($settings['asyn']) {
                $url = Url::createUrl("{$settings['route']}", $settings['params']);
                $scripts[$widget['name']] = array(
                    'id' => $widget['name'],
                    'method' => 'ready',
                    'script' =>
                    "$(document.createElement('div'))
                        .attr({
                            id:'" . $widget['name'] . "'
                        })
                        .html(makeWaiting())
                        .load('" . $url . "')
                        .appendTo('" . $settings['target'] . "');"
                );
            } else {
                if (isset($settings['route'])) {
                    if (($this->browser->isMobile() && $settings['showonmobile']) || (!$this->browser->isMobile() && $settings['showondesktop'])) {
                        if ($settings['autoload']) {
                            $this->data['featuredWidgets'][] = $widget['name'];
                        }
                        
                        $this->children[$widget['name']] = $settings['route'];
                        $this->widget[$widget['name']] = $widget;
                    }
                }
            }
        }
        
        foreach ($widgets->getWidgets('featuredFooter') as $widget) {
            $settings = (array) unserialize($widget['settings']);
            if ($settings['asyn']) {
                $url = Url::createUrl("{$settings['route']}", $settings['params']);
                $scripts[$widget['name']] = array(
                    'id' => $widget['name'],
                    'method' => 'ready',
                    'script' =>
                    "$(document.createElement('div'))
                        .attr({
                            id:'" . $widget['name'] . "'
                        })
                        .html(makeWaiting())
                        .load('" . $url . "')
                        .appendTo('" . $settings['target'] . "');"
                );
            } else {
                if (isset($settings['route'])) {
                    if (($this->browser->isMobile() && $settings['showonmobile']) || (!$this->browser->isMobile() && $settings['showondesktop'])) {
                        if ($settings['autoload']) {
                            $this->data['featuredFooterWidgets'][] = $widget['name'];
                        }
                        
                        $this->children[$widget['name']] = $settings['route'];
                        $this->widget[$widget['name']] = $widget;
                    }
                }
            }
        }
    }

}
