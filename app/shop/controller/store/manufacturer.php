<?php

class ControllerStoreManufacturer extends Controller {

    public function index() {
        $this->language->load('store/manufacturer');
        $this->load->model('store/manufacturer');
        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => Url::createUrl("store/home"),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        if (isset($this->request->get['manufacturer_id'])) {
            $this->data['manufacturer_id'] = $this->request->get['manufacturer_id'];
        } else {
            $this->data['manufacturer_id'] = 0;
        }

        $manufacturer_info = $this->modelManufacturer->getManufacturer($this->data['manufacturer_id']);

        if ($manufacturer_info) {
            //tracker
            $this->tracker->track($manufacturer_info['manufacturer_id'], 'manufacturer');

            if ($this->session->has('ref_email') && !$this->session->has('ref_cid')) {
                $this->data['show_register_form_invitation'] = true;
            }

            $this->session->set('redirect', Url::createUrl("store/manufacturer", array('manufacturer_id' => $this->data['manufacturer_id'])));

            $this->modelManufacturer->updateStats($this->request->getQuery('manufacturer_id'), $this->customer->getId());

            $cached = $this->cache->get('manufacturer.' .
                    $this->data['manufacturer_id'] .
                    $this->config->get('config_language_id') . "." .
                    $this->request->getQuery('hl') . "." .
                    $this->request->getQuery('cc') . "." .
                    $this->customer->getId() . "." .
                    $this->config->get('config_currency') . "." .
                    $this->config->get('config_store_id')
            );
            $this->load->library('user');
            if ($cached && !$this->user->isLogged()) {
                $this->response->setOutput($cached, $this->config->get('config_compression'));
            } else {
                $this->document->breadcrumbs[] = array(
                    'href' => Url::createUrl("store/manufacturer", array("manufacturer_id" => $this->request->get['manufacturer_id'])),
                    'text' => $manufacturer_info['name'],
                    'separator' => $this->language->get('text_separator')
                );
                $this->data['breadcrumbs'] = $this->document->breadcrumbs;

                $this->document->title = $this->data['heading_title'] = $manufacturer_info['name'];

                $this->loadWidgets();

                if ($scripts)
                    $this->scripts = array_merge($this->scripts, $scripts);

                if (!$this->user->isLogged()) {
                    $this->cacheId = 'manufacturer.' .
                            $this->data['manufacturer_id'] .
                            $this->config->get('config_language_id') . "." .
                            $this->request->getQuery('hl') . "." .
                            $this->request->getQuery('cc') . "." .
                            $this->customer->getId() . "." .
                            $this->config->get('config_currency') . "." .
                            $this->config->get('config_store_id');
                }

                $this->children[] = 'common/column_left';
                $this->children[] = 'common/column_right';
                $this->children[] = 'common/nav';
                $this->children[] = 'common/header';
                $this->children[] = 'common/footer';

                $template = $this->modelManufacturer->getProperty($this->data['manufacturer_id'], 'style', 'view');
                $default_template = ($this->config->get('default_view_manufacturer')) ? $this->config->get('default_view_manufacturer') : 'store/manufacturer.tpl';
                $template = empty($template) ? $default_template : $template;
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
                    $this->template = $this->config->get('config_template') . '/' . $template;
                } else {
                    $this->template = 'cuyagua/' . $template;
                }

                $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
            }
        } else {
            $this->error404();
        }
    }

    protected function error404() {
        $url = '';

        if ($this->request->hasQuery('sort')) {
            $url .= '&sort=' . $this->request->getQuery('sort');
        }
        if ($this->request->hasQuery('order')) {
            $url .= '&order=' . $this->request->getQuery('order');
        }
        if ($this->request->hasQuery('v')) {
            $url .= '&v=' . $this->request->getQuery('v');
        }
        if ($this->request->hasQuery('page')) {
            $url .= '&page=' . $this->request->getQuery('page');
        }

        $this->document->breadcrumbs[] = array(
            'href' => Url::createUrl("store/manufacturer", array("manufacturer_id" => $manufacturer_id . $url)),
            'text' => $this->language->get('text_error'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['breadcrumbs'] = $this->document->breadcrumbs;

        $this->document->title = $this->data['heading_title'] = $this->language->get('text_error');

        $this->loadWidgets();

        if ($scripts)
            $this->scripts = array_merge($this->scripts, $scripts);

        $this->children[] = 'common/column_left';
        $this->children[] = 'common/column_right';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/header';
        $this->children[] = 'common/footer';

        $template = ($this->config->get('default_view_manufacturer_error')) ? $this->config->get('default_view_manufacturer_error') : 'error/not_found.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
            $this->template = $this->config->get('config_template') . '/' . $template;
        } else {
            $this->template = 'cuyagua/' . $template;
        }

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    public function home() {
        $this->load->language("store/manufacturer");

        $page = ($this->request->hasQuery('page')) ? $this->request->getQuery('page') : 1;
        $sort = ($this->request->hasQuery('sort')) ? $this->request->getQuery('sort') : 'p.sort_order';
        $view = ($this->request->hasQuery('v')) ? $this->request->getQuery('v') : 'grid';
        $order = ($this->request->hasQuery('order')) ? $this->request->getQuery('order') : 'ASC';

        $url = '';

        if ($this->request->hasQuery('sort')) {
            $url .= '&sort=' . $this->request->getQuery('sort');
        }
        if ($this->request->hasQuery('order')) {
            $url .= '&order=' . $this->request->getQuery('order');
        }
        if ($this->request->hasQuery('v')) {
            $url .= '&v=' . $this->request->getQuery('v');
        }
        if ($this->request->hasQuery('page')) {
            $url .= '&page=' . $this->request->getQuery('page');
        }

        $this->data['sorts'] = array();

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_default'),
            'value' => 'p.sort_order-ASC',
            'href' => Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.sort_order&order=ASC&page=' . $page . '&v=' . $view,
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.sort_order&order=ASC&page=' . $page . '&v=' . $view . '")'
        );

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_name_asc'),
            'value' => 'pd.name-ASC',
            'href' => Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=ASC&page=' . $page . '&v=' . $view,
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=ASC&page=' . $page . '&v=' . $view . '")'
        );

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_name_desc'),
            'value' => 'pd.name-DESC',
            'href' => Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=DESC&page=' . $page . '&v=' . $view,
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=pd.name&order=DESC&page=' . $page . '&v=' . $view . '")'
        );

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_price_asc'),
            'value' => 'p.price-ASC',
            'href' => Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC&page=' . $page . '&v=' . $view,
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC&page=' . $page . '&v=' . $view . '")'
        );

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_price_desc'),
            'value' => 'p.price-DESC',
            'href' => Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC&page=' . $page . '&v=' . $view,
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC&page=' . $page . '&v=' . $view . '")'
        );

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_rating_desc'),
            'value' => 'rating-DESC',
            'href' => Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=DESC&page=' . $page . '&v=' . $view,
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=DESC&page=' . $page . '&v=' . $view . '")'
        );

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_rating_asc'),
            'value' => 'rating-ASC',
            'href' => Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=ASC&page=' . $page . '&v=' . $view,
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=rating&order=ASC&page=' . $page . '&v=' . $view . '")'
        );

        $this->load->model('store/product');

        $product_total = $this->modelProduct->getTotalProductsByManufacturerId($this->request->get["manufacturer_id"]);

        if ($product_total) {
            $this->prefetch($sort, $order, $page);
        }

        $pagination = new Pagination(true);
        $pagination->total = $product_total;
        $pagination->page = $page;
        $pagination->ajax = true;
        $pagination->limit = $this->config->get('config_catalog_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&page={page}';

        $this->data['pagination'] = $pagination->render();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->data['gridView'] = Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&v=grid';
        $this->data['listView'] = Url::createUrl("store/manufacturer/home") . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&v=list';

        $template = ($this->config->get('default_view_manufacturer_home')) ? $this->config->get('default_view_manufacturer_home') : 'store/products.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
            $this->template = $this->config->get('config_template') . '/' . $template;
        } else {
            $this->template = 'cuyagua/' . $template;
        }

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    protected function prefetch($sort, $order, $page) {
        $this->language->load('store/product');
        $this->data['heading_title'] = "";
        $this->load->model('store/product');
        $results = $this->modelProduct->getProductsByManufacturerId($this->request->get["manufacturer_id"], $sort, $order, ($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));
        require_once(DIR_CONTROLLER . "store/product_array.php");
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
