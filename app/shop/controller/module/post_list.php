<?php

class ControllerModulePostList extends Controller {

    protected function index($widget = null) {
        if (isset($widget)) {
            $this->data['settings'] = $settings = (array) unserialize($widget['settings']);
            $this->data['widget_hook'] = $this->data['widgetName'] = $widget['name'];
        }

        $data['limit'] = ((int) $this->data['settings']['limit']) ? (int) $this->data['settings']['limit'] : 24;
        $data['category_id'] = (!empty($settings['categories'])) ? $settings['categories'] : null;
        $data['post_type'] = (!empty($settings['post_type'])) ? $settings['post_type'] : 'post';
        $data['show_featured_image'] = (!empty($settings['show_featured_image'])) ? $settings['show_featured_image'] : null;

        $data['image_popup_width'] = (!empty($settings['image_popup_width'])) ? $settings['image_popup_width'] : $this->config->get('config_image_popup_width');
        $data['image_popup_height'] = (!empty($settings['image_popup_height'])) ? $settings['image_popup_height'] : $this->config->get('config_image_popup_height');

        $data['image_thumb_width'] = (!empty($settings['image_thumb_width'])) ? $settings['image_thumb_width'] : $this->config->get('config_image_thumb_width');
        $data['image_thumb_height'] = (!empty($settings['image_thumb_height'])) ? $settings['image_thumb_height'] : $this->config->get('config_image_thumb_height');

        $this->data['posts'] = array();

        $func = $this->data['settings']['module'];
        if (!$func || !in_array($func, array('random', 'latest', 'featured', 'recommended', 'related', 'popular'))) $func = 'random';
        $this->prefetch($data, $func);

        $view = $this->data['settings']['view'];
        if (!$view || !in_array($view, array('list', 'grid', 'carousel', 'slider'))) $view = 'list';

        if ($this->data['settings']['show_pagination']) {

        }

        if ($this->data['settings']['endless_scroll']) {

        }

        $this->loadAssets($func, $view);

        if ($scripts)
            $this->scripts = array_merge($this->scripts, $scripts);

        $this->id = 'post_list';

        if ($widget['position'] == 'main' || $widget['position'] == 'featuredContent') {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/post_list_home_'. $view .'.tpl')) {
                //$this->template = $this->config->get('config_template') . '/module/'. $func .'_home.tpl';
                $this->template = $this->config->get('config_template') . '/module/post_list_home_'. $view .'.tpl';
            } else {
                $this->template = 'cuyagua/module/post_list_home_'. $view .'.tpl';
            }
        } else {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/module/post_list_'. $view .'.tpl')) {
                //$this->template = $this->config->get('config_template') . '/module/'. $func .'.tpl';
                $this->template = $this->config->get('config_template') . '/module/post_list_'. $view .'.tpl';
            } else {
                $this->template = 'cuyagua/module/post_list_'. $view .'.tpl';
            }
        }
        $this->render();
    }

    public function home() {
        $this->prefetch($this->config->get('config_catalog_limit'), $this->request->getQuery('func'));
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/content/posts.tpl')) {
            $this->template = $this->config->get('config_template') . '/content/posts.tpl';
        } else {
            $this->template = 'cuyagua/content/posts.tpl';
        }
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    protected function prefetch($data, $func = 'random') {
        $Url = new Url($this->registry);
        $this->language->load('module/'. $func);
        $this->load->model('content/post');

        if (isset($this->data['settings']['title'])) {
            $this->data['heading_title'] = $this->data['settings']['title'];
        } else {
            $this->data['heading_title'] = $this->language->get('heading_title');
        }

        switch ($func) {
            case 'random':
            default:
                $results = $this->modelPost->getRandomPost($data);
                break;
            case 'latest':
                $results = $this->modelPost->getLatestPost($data);
                break;
            case 'featured':
                $results = $this->modelPost->getFeaturedPost($data);
                break;
            case 'recommended':
                $results = $this->modelPost->getRecommendedPost($data);
                break;
            case 'related':
                $results = $this->modelPost->getPostRelated($this->request->getQuery('post_id'), $data);
                break;
            case 'popular':
                $results = $this->modelPost->getPopularPost($data);
                break;
        }

        $this->load->auto('content/review');

        $this->data['posts'] = array();
        foreach ($results as $k => $result) {
            if (isset($data['show_featured_image'])) {
                $image = $imageP = !empty($result['image']) ? $result['image'] : 'no_image.jpg';
            }

            if ($this->config->get('config_review')) {
                //$rating = $this->modelReview->getAverageRating($result['post_id']);
            } else {
                $rating = false;
            }

            $this->data['posts'][$k] = array(
                'post_id' => $result['post_id'],
                'name' => $result['title'],
                'overview' => $result['meta_description'],
                'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
                'rating' => $rating,
                'stars' => sprintf($this->language->get('text_stars'), $rating),
                'href' => $Url::createUrl('content/post', array('post_id' => $result['post_id'])),
                'created' => $result['created']
            );
            if (isset($data['show_featured_image'])) {
                $this->load->auto('image');
                $j = count($this->data['posts'][$k]['images']) + 1;
                $this->data['posts'][$k]['images'][$j] = array(
                    'popup' => NTImage::resizeAndSave($imageP, $data['image_popup_width'], $data['image_popup_height']),
                    'thumb' => NTImage::resizeAndSave($imageP, $data['image_thumb_width'], $data['image_thumb_height']),
                );
                $this->data['posts'][$k]['image'] = NTImage::resizeAndSave($image, 38, 38);
                $this->data['posts'][$k]['lazyImage'] = NTImage::resizeAndSave('no_image.jpg', $this->config->get('config_image_post_width'), $this->config->get('config_image_post_height'));
                $this->data['posts'][$k]['thumb'] = NTImage::resizeAndSave($image, $this->config->get('config_image_post_width'), $this->config->get('config_image_post_height'));
                $this->data['posts'][$k]['images'] = array_reverse($this->data['posts'][$k]['images']);
            }
        }
    }

    public function carousel() {
        $func = $this->request->getQuery('func');
        if (!$func || !in_array($func, array('random', 'latest', 'featured', 'recommended', 'related', 'popular'))) $func = 'random';

        if ($this->request->hasQuery('limit') && is_numeric($this->request->getQuery('limit'))) {
            $data['limit'] = $this->request->getQuery('limit');
        } else {
            $data['limit'] = 24;
        }

        $json = array();
        $Url = new Url($this->registry);
        $this->load->auto("content/post");
        $this->load->auto('image');
        $this->load->auto('json');

        switch ($func) {
            case 'random':
            default:
                $json['results'] = $this->modelPost->getRandomPost($data);
                break;
            case 'latest':
                $json['results'] = $this->modelPost->getLatestPost($data);
                break;
            case 'featured':
                $json['results'] = $this->modelPost->getFeaturedPost($data);
                break;
            case 'recommended':
                $json['results'] = $this->modelPost->getRecommendedPost($data);
                break;
            case 'related':
                $json['results'] = $this->modelPost->getProductRelated($this->request->getQuery('post_id'), $data);
                break;
            case 'popular':
                $json['results'] = $this->modelPost->getPopularPost($data);
                break;
        }

        $width = isset($_GET['width']) ? $_GET['width'] : 80;
        $height = isset($_GET['height']) ? $_GET['height'] : 80;
        foreach ($json['results'] as $k => $v) {
            if (!file_exists(DIR_IMAGE . $v['image']))
                $json['results'][$k]['image'] = HTTP_IMAGE . "no_image.jpg";
            $json['results'][$k]['thumb'] = NTImage::resizeAndSave($v['image'], $width, $height);

            $json['results'][$k]['config_store_mode'] = $this->config->get('config_store_mode');
            $json['results'][$k]['see_url'] = $Url::createUrl('content/post', array('post_id' => $v['post_id']));

            $json['results'][$k]['images'] = array();
            $j = count($json['results'][$k]['images']) + 1;
            $json['results'][$k]['images'][$j] = array(
                'popup' => NTImage::resizeAndSave($v['image'], $width, $height),
                'preview' => NTImage::resizeAndSave($v['image'], $width, $height),
                'thumb' => NTImage::resizeAndSave($v['image'], $width, $height)
            );
            $json['results'][$k]['images'] = array_reverse($json['results'][$k]['images']);
        }

        if (!count($json['results']))
            $json['error'] = 1;

        $this->response->setOutput(Json::encode($json), $this->config->get('config_compression'));
    }

    protected function loadAssets($func, $view) {
        $csspath = defined("CDN") ? CDN_CSS : HTTP_THEME_CSS;
        $jspath = defined("CDN") ? CDN_JS : HTTP_THEME_JS;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
            $csspath = str_replace("%theme%", $this->config->get('config_template'), $csspath);
            $cssFolder = str_replace("%theme%", $this->config->get('config_template'), DIR_THEME_CSS);

            $jspath = str_replace("%theme%", $this->config->get('config_template'), $jspath);
            $jsFolder = str_replace("%theme%", $this->config->get('config_template'), DIR_THEME_JS);
        } else {
            $csspath = str_replace("%theme%", "default", $csspath);
            $cssFolder = str_replace("%theme%", "default", DIR_THEME_CSS);

            $jspath = str_replace("%theme%", "default", $jspath);
            $jsFolder = str_replace("%theme%", "default", DIR_THEME_JS);
        }

        if (file_exists($cssFolder .str_replace('controller', '', strtolower(__CLASS__) . '.css'))) {
            if ($this->config->get('config_render_css_in_file')) {
                $this->data['css'] .= file_get_contents($cssFolder . str_replace('controller', '', strtolower(__CLASS__) . '.css'));
            } else {
                $styles[str_replace('controller', '', strtolower(__CLASS__) . '.css')] = array('media' => 'all', 'href' => $csspath . str_replace('controller', '', strtolower(__CLASS__) . '.css'));
            }
        }

        if (file_exists($cssFolder .'module'. $func .  $view .'.css')) {
            if ($this->config->get('config_render_css_in_file')) {
                $this->data['css'] .= file_get_contents($cssFolder . 'module'. $func . $view .'.css');
            } else {
                $styles['module'. $func . $view .'.css'] = array('media' => 'all', 'href' => $csspath . 'module'. $func . $view .'.css');
            }
        }

        if (file_exists($jsFolder . 'module'. $func . $view . '.js')) {
            if ($this->config->get('config_render_js_in_file')) {
                $javascripts[] = $jsFolder . 'module'. $func . $view . '.js';
            } else {
                $javascripts[] = $jspath . 'module'. $func . $view . '.js';
            }
        }

        if (file_exists($jsFolder . str_replace('controller', '', strtolower(__CLASS__) . '.js'))) {
            if ($this->config->get('config_render_js_in_file')) {
                $javascripts[] = $jsFolder . str_replace('controller', '', strtolower(__CLASS__) . '.js');
            } else {
                $javascripts[] = $jspath . str_replace('controller', '', strtolower(__CLASS__) . '.js');
            }
        }

        if (count($styles)) {
            $this->data['styles'] = $this->styles = array_merge($this->styles, $styles);
        }

        if (count($javascripts)) {
            $this->javascripts = array_merge($this->javascripts, $javascripts);
        }
    }
}