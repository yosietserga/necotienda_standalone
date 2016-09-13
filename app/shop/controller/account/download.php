<?php

class ControllerAccountDownload extends Controller {

    public function index() {
        $Url = new Url($this->registry);
        if (!$this->customer->isLogged()) {
            $this->session->set('redirect', Url::createUrl("account/download"));

            $this->redirect(Url::createUrl("account/login"));
        }

        $this->language->load('account/download');

        $this->document->title = $this->language->get('heading_title');

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href' => Url::createUrl("common/home"),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createUrl("account/account"),
            'text' => $this->language->get('text_account'),
            'separator' => $this->language->get('text_separator')
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createUrl("account/download"),
            'text' => $this->language->get('text_downloads'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_order'] = $this->language->get('text_order');
        $this->data['text_date_added'] = $this->language->get('text_date_added');
        $this->data['text_name'] = $this->language->get('text_name');
        $this->data['text_remaining'] = $this->language->get('text_remaining');
        $this->data['text_size'] = $this->language->get('text_size');
        $this->data['text_download'] = $this->language->get('text_download');

        $this->load->model('account/download');

        $download_total = $this->modelDownload->getTotalDownloads();

        if ($download_total) {
            if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
            } else {
                $page = 1;
            }

            $this->data['downloads'] = array();

            $results = $this->modelDownload->getDownloads(($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));
            foreach ($results as $result) {
                if (file_exists(DIR_DOWNLOAD . $result['filename'])) {
                    $size = filesize(DIR_DOWNLOAD . $result['filename']);
                    $i = 0;
                    $suffix = array(
                        'B',
                        'KB',
                        'MB',
                        'GB',
                        'TB',
                        'PB',
                        'EB',
                        'ZB',
                        'YB'
                    );
                    while (($size / 1024) > 1) {
                        $size = $size / 1024;
                        $i++;
                    }
                    $this->data['downloads'][] = array(
                        'order_id' => $result['order_id'],
                        'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                        'name' => $result['name'],
                        'remaining' => $result['remaining'],
                        'size' => round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
                        'href' => Url::createUrl("account/download/download", array("order_download_id" => $result['order_download_id']))
                    );
                }
            }

            $this->load->auto('pagination');
            $pagination = new Pagination();
            $pagination->total = $download_total;
            $pagination->page = $page;
            $pagination->limit = $this->config->get('config_catalog_limit');
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = Url::createUrl("account/download") . '&page={page}';

            $this->data['pagination'] = $pagination->render();
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/download.tpl')) {
            $this->template = $this->config->get('config_template') . '/account/.tpl';
        } else {
            $this->template = 'cuyagua/account/download.tpl';
        }

        $this->loadWidgets();

        if ($scripts)
            $this->scripts = array_merge($this->scripts, $scripts);

        $this->children[] = 'account/column_left';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/header';
        $this->children[] = 'common/footer';

        $template = ($this->config->get('default_view_account_download')) ? $this->config->get('default_view_account_download') : 'account/download.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
            $this->template = $this->config->get('config_template') . '/' . $template;
        } else {
            $this->template = 'cuyagua/' . $template;
        }

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    public function download() {
        if (!$this->customer->isLogged()) {
            $this->session->set('redirect', Url::createUrl("account/download"));

            $this->redirect(Url::createUrl("account/login"));
        }

        $this->load->model('account/download');

        if (isset($this->request->get['order_download_id'])) {
            $order_download_id = $this->request->get['order_download_id'];
        } else {
            $order_download_id = 0;
        }

        $download_info = $this->modelDownload->getDownload($order_download_id);

        if ($download_info) {
            $file = DIR_DOWNLOAD . $download_info['filename'];
            $mask = basename($download_info['mask']);
            $mime = 'application/octet-stream';
            $encoding = 'binary';

            if (!headers_sent()) {
                if (file_exists($file)) {
                    header('Pragma: public');
                    header('Expires: 0');
                    header('Content-Description: File Transfer');
                    header('Content-Type: ' . $mime);
                    header('Content-Transfer-Encoding: ' . $encoding);
                    header('Content-Disposition: attachment; filename=' . ($mask ? $mask : basename($file)));
                    header('Content-Length: ' . filesize($file));

                    $file = readfile($file, 'rb');

                    print($file);
                } else {
                    exit('Error: Could not find file ' . $file . '!');
                }
            } else {
                exit('Error: Headers already sent out!');
            }

            $this->modelDownload->updateRemaining($this->request->get['order_download_id']);
        } else {
            $this->redirect(Url::createUrl("account/download"));
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
