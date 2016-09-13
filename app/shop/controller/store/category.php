<?php

class ControllerStoreCategory extends Controller {

    public function index() {
        $Url = new Url($this->registry);
        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => $Url::createUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        if (isset($this->request->get['path'])) {
            $path = '';
            $parts = explode('_', $this->request->get['path']);
            foreach ($parts as $path_id) {
                $category_info = $this->modelCategory->getCategory($path_id);
                if ($category_info) {
                    if (!$path) {
                        $path = $path_id;
                    } else {
                        $path .= '_' . $path_id;
                    }
                    $this->document->breadcrumbs[] = array(
                        'href' => $Url::createUrl('store/category', array('path' => $path)),
                        'text' => $category_info['name'],
                        'separator' => $this->language->get('text_separator')
                    );
                }
            }
            $this->data['category_id'] = array_pop($parts);
        } else {
            $this->data['category_id'] = 0;
        }

        $category_info = $this->modelCategory->getCategory($this->data['category_id']);

        if ($category_info) {
            //tracker
            $this->tracker->track($category_info['category_id'], 'category');

            if ($this->session->has('ref_email') && !$this->session->has('ref_cid')) {
                $this->data['show_register_form_invitation'] = true;
            }

            $this->session->set('redirect', $Url::createUrl('store/category', array('path' => $this->data['category_id'])));

            $this->modelCategory->updateStats($this->request->getQuery('path'), $this->customer->getId());

            $cached = $this->cache->get('category.' .
                    $this->request->get['path'] .
                    $this->data['category_id'] .
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
                $this->document->title = $this->data['heading_title'] = $category_info['name'];
                $this->document->description = $category_info['meta_description'];
                $this->document->keywords = $category_info['meta_keywords'];
                $this->data['breadcrumbs'] = $this->document->breadcrumbs;

                $this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
                $category_total = $this->modelCategory->getTotalCategoriesByCategoryId($this->data['category_id']);
                $this->data['categories'] = array();

                if ($category_total) {
                    $results = $this->modelCategory->getCategories($this->data['category_id']);
                    foreach ($results as $result) {
                        if ($result['image']) {
                            $image = $result['image'];
                        } else {
                            $image = 'no_image.jpg';
                        }

                        $this->data['categories'][] = array(
                            'name' => $result['name'],
                            'href' => $Url::createUrl('store/category', array("path" => $this->request->get['path'] . '_' . $result['category_id'])) . $url,
                            'thumb' => NTImage::resizeAndSave($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'))
                        );
                    }
                }

                $product_total = $this->modelProduct->getTotalProductsByCategoryId($this->data['category_id']);

                $this->loadWidgets();

                $scripts[] = array(
                    'id' => 'category_page',
                    'method' => 'ready',
                    'script' => "$('#products').load('" . $Url::createUrl('store/category/home', array('category_id' => $this->data['category_id'])) . "');"
                );

                if ($scripts)
                    $this->scripts = array_merge($this->scripts, $scripts);

                if (!$this->user->isLogged()) {
                    $this->cacheId = 'category.' .
                            $this->request->get['path'] .
                            $this->data['category_id'] .
                            $this->config->get('config_language_id') . "." .
                            $this->request->getQuery('hl') . "." .
                            $this->request->getQuery('cc') . "." .
                            $this->customer->getId() . "." .
                            $this->config->get('config_currency') . "." .
                            (int) $this->config->get('config_store_id');
                }

                $template = $this->modelCategory->getProperty($this->data['category_id'], 'style', 'view');
                $default_template = ($this->config->get('default_view_product_category')) ? $this->config->get('default_view_product_category') : 'store/category.tpl';
                $template = empty($template) ? $default_template : $template;
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
                    $this->template = $this->config->get('config_template') . '/' . $template;
                } else {
                    $this->template = 'cuyagua/' . $template;
                }

                $this->children[] = 'common/column_left';
                $this->children[] = 'common/column_right';
                $this->children[] = 'common/nav';
                $this->children[] = 'common/header';
                $this->children[] = 'common/footer';

                $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
            }
        } else {
            $this->error404();
        }
    }

    protected function error404() {
        if (isset($this->request->get['path'])) {
            $this->document->breadcrumbs[] = array(
                'href' => Url::createUrl('store/category', array("path" => $this->request->get['path'])) . $url,
                'text' => $this->language->get('text_error'),
                'separator' => $this->language->get('text_separator')
            );
        }

        $this->data['breadcrumbs'] = $this->document->breadcrumbs;
        $this->document->title = $this->data['heading_title'] = $this->language->get('text_error');

        $this->loadWidgets();

        $template = ($this->config->get('default_view_product_category_error')) ? $this->config->get('default_view_product_category_error') : 'error/not_found.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
            $this->template = $this->config->get('config_template') . '/' . $template;
        } else {
            $this->template = 'cuyagua/' . $template;
        }

        $this->children[] = 'common/column_left';
        $this->children[] = 'common/column_right';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/header';
        $this->children[] = 'common/footer';

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    public function all() {
        $this->language->load('store/category');
        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => Url::createUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );
        $this->data['breadcrumbs'] = $this->document->breadcrumbs;

        $this->document->title = $this->data['heading_title'] = $this->language->get('heading_title');
        $this->document->description = $this->language->get('meta_description');
        $this->document->keywords = $this->language->get('meta_keywords');

        $this->data['categories'] = array();
        $results = $this->modelCategory->getCategories(0);
        foreach ($results as $result) {
            if ($result['image']) {
                $image = $result['image'];
            } else {
                $image = 'no_image.jpg';
            }

            $this->data['categories'][] = array(
                'name' => $result['name'],
                'href' => Url::createUrl('store/category', array("path" => $result['category_id'])),
                'thumb' => NTImage::resizeAndSave($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'))
            );
        }

        $this->loadWidgets();

        $template = ($this->config->get('default_view_product_category_all')) ? $this->config->get('default_view_product_category_all') : 'store/categories.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
            $this->template = $this->config->get('config_template') . '/' . $template;
        } else {
            $this->template = 'cuyagua/' . $template;
        }

        $this->children[] = 'common/nav';
        $this->children[] = 'common/column_left';
        $this->children[] = 'common/column_right';
        $this->children[] = 'common/footer';
        $this->children[] = 'common/header';

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    public function home() {
        $this->setvar('sort');
        $this->setvar('order');
        $this->setvar('page');
        $this->setvar('v');

        $page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
        $sort = isset($this->request->get['sort']) ? $this->request->get['page'] : 'p.sort_order';
        $view = isset($this->request->get['v']) ? $this->request->get['v'] : 'grid';
        $order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';

        $url = '';
        $url .=!empty($this->data['sort']) ? '&sort=' . $this->data['sort'] : "";
        $url .=!empty($this->data['order']) ? '&order=' . $this->data['order'] : "";
        $url .=!empty($this->data['page']) ? '&page=' . $this->data['page'] : "";
        $url .=!empty($this->data['v']) ? '&v=' . $this->data['v'] : "";

        $this->data['sorts'] = array();

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_default'),
            'value' => 'p.sort_order-ASC',
            'href' => Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=p.sort_order&order=ASC&page=' . $page . '&v=' . $view),
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=p.sort_order&order=ASC&page=' . $page . '&v=' . $view) . '")');

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_name_asc'),
            'value' => 'pd.name-ASC',
            'href' => Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=pd.name&order=ASC&page=' . $page . '&v=' . $view),
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=pd.name&order=ASC&page=' . $page . '&v=' . $view) . '")');

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_name_desc'),
            'value' => 'pd.name-DESC',
            'href' => Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=pd.name&order=DESC&page=' . $page . '&v=' . $view),
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=pd.name&order=DESC&page=' . $page . '&v=' . $view) . '")');

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_price_asc'),
            'value' => 'p.price-ASC',
            'href' => Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=p.price&order=ASC&page=' . $page . '&v=' . $view),
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=p.price&order=ASC&page=' . $page . '&v=' . $view) . '")');

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_price_desc'),
            'value' => 'p.price-DESC',
            'href' => Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=p.price&order=DESC&page=' . $page . '&v=' . $view),
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=p.price&order=DESC&page=' . $page . '&v=' . $view) . '")');

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_rating_desc'),
            'value' => 'rating-DESC',
            'href' => Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=rating&order=DESC&page=' . $page . '&v=' . $view),
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=rating&order=ASC&page=' . $page . '&v=' . $view) . '")');

        $this->data['sorts'][] = array(
            'text' => $this->language->get('text_rating_asc'),
            'value' => 'rating-ASC',
            'href' => Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=rating&order=ASC&page=' . $page . '&v=' . $view),
            'ajax' => true,
            'ajaxFunction' => 'sort(this,"' . Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . '&sort=rating&order=ASC&page=' . $page . '&v=' . $view) . '")');

        $this->load->auto('store/product');
        $product_total = $this->modelProduct->getTotalProductsByCategoryId($this->request->get["category_id"]);

        if ($product_total) {
            $this->prefetch($sort, $order, $page);
        } else {
            $this->document->title = $category_info['name'];
            $this->document->description = $category_info['meta_description'];
            $this->data['heading_title'] = $category_info['name'];
            $this->data['text_error'] = $this->language->get('text_empty');
            $this->data['button_continue'] = $this->language->get('button_continue');
            $this->data['continue'] = Url::createUrl('common/home');
            $this->data['products'] = array();
        }

        $this->load->auto('pagination');
        $pagination = new Pagination(true);
        $pagination->total = $product_total;
        $pagination->page = $page;
        $pagination->ajax = true;
        $pagination->limit = $this->config->get('config_catalog_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . $url . '&page={page}');

        $this->data['pagination'] = $pagination->render();
        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->data['gridView'] = Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . $url . '&v=grid');
        $this->data['listView'] = Url::createUrl('store/category/home', 'category_id=' . $this->request->get['category_id'] . $url . '&v=list');

        $template = ($this->config->get('default_view_product_category_home')) ? $this->config->get('default_view_product_category_home') : 'store/products.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
            $this->template = $this->config->get('config_template') . '/' . $template;
        } else {
            $this->template = 'cuyagua/' . $template;
        }

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    protected function prefetch($sort, $order, $page) {
        $this->data['heading_title'] = "Productos";
        $results = $this->modelProduct->getProductsByCategoryId($this->request->get["category_id"], $sort, $order, ($page - 1) * $this->config->get('config_catalog_limit'), $this->config->get('config_catalog_limit'));
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
