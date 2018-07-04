<?php

class ControllerCommonFooter extends Controller {

    protected function index($params = null) {
        $this->language->load('common/footer');
        $this->load->library('user');
        $this->data['config_js_security'] = $this->config->get('config_js_security');

        $config_text_powered_by = $this->config->get('config_text_powered_by');
        if (!empty($config_text_powered_by)) {
            $this->data['text_powered_by'] = html_entity_decode(sprintf($config_text_powered_by, $this->config->get('config_name'), date('Y')));
        } else {
            $this->data['text_powered_by'] = sprintf($this->language->get('text_powered_by'), $this->config->get('config_name'));
        }

        $this->id = 'footer';

        // SCRIPTS
        if ($this->config->get('config_seo_url')) {
            $urlBase = HTTP_HOME . 'buscar/';
        } else {
            $urlBase = HTTP_HOME . 'index.php?r=store/search&q=';
        }
        $scripts[] = array('id' => 'search', 'method' => 'function', 'script' =>
            "function moduleSearch(keyword) {
            var url = '" . $urlBase . "';
            var form = $(keyword).closest('form');
            var category = $('#'+ $(keyword).attr('id').replace('Keyword','Category')).val();
            var store = $('#'+ $(keyword).attr('id').replace('Keyword','Store')).val();
            var zone = $('#'+ $(keyword).attr('id').replace('Keyword','Zone')).val();
            
            url += $(keyword).val()
                .replace(/_/g,'-')
                .replace('+','-')
                .replace(/\s+/g,'-');
            
            if (typeof category != 'undefined') {
                url += '_Cat_'+ category
                    .replace(/_/g,'-')
                    .replace('+','-')
                    .replace(/\s+/g,'-');
            }
            
            if (typeof zone != 'undefined') {
                url += '_Estado_'+ zone
                    .replace(/_/g,'-')
                    .replace('+','-')
                    .replace(/\s+/g,'-');
            }
            
            if (typeof store != 'undefined') {
                url += '_Tienda_'+ store
                    .replace(/_/g,'-')
                    .replace('+','-')
                    .replace(/\s+/g,'-');
            }
            
            window.location = url;
        }

        function moduleSearchFilters(data) {
            var url = data.baseUrl;
            var form = data.form;
            $(form).find('input').each(function(i,item){
                url += '_Filtro_';
                url += $(item).attr('name')
                        .replace(/_/g,'-')
                        .replace(/\//g,'-')
                        .replace('+','-')
                        .replace(/\s+/g,'-');
                url += '+';
                url += $(item).val()
                    .replace(/_/g,'-')
                    .replace(/\//g,'-')
                    .replace('+','-')
                    .replace(/\s+/g,'-');
                console.log(url);
            });
            window.location = url;
        }");
        
        $this->scripts = array_merge($this->scripts, $scripts);
        $r_output = $w_output = $s_output = $f_output = "";
        $script_keys = array();
        foreach ($this->scripts as $k => $script) {
            if (in_array($script['id'], $script_keys))
                continue;
            $script_keys[$k] = $script['id'];
            switch ($script['method']) {
                case 'ready':
                default:
                    $r_output .= $script['script'];
                    break;
                case 'window':
                    $w_output .= $script['script'];
                    break;
                case 'function':
                    $f_output .= $script['script'];
                    break;
            }
        }
        
        $this->loadWidgets('footer');
        
        $this->loadJs();
        
        if ($this->config->get('config_render_js_in_file')) {
            $done = array();
            foreach ($this->javascripts as $key => $js) {
                if (in_array($js, $done) || !file_exists($js)) continue;
                $done[] = $js;
                $f_output .= file_get_contents($js);
            }
            $this->javascripts = null;
            $javascripts = null;
        }
        
        $this->data['scripts'] .= ($f_output) ? "<script> \n " . $f_output . " </script>" : "";
        $this->data['scripts'] .= $s_output;
        $this->data['scripts'] .= ($r_output) ? "<script> \n $(function(){" . $r_output . "}); </script>" : "";
        $this->data['scripts'] .= ($w_output) ? "<script> \n (function($){ $(window).load(function(){ " . $w_output . " }); })(jQuery);</script>" : "";

        if ($javascripts)
            $this->javascripts = array_merge($this->javascripts, $javascripts);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/footer.tpl')) {
            $this->template = $this->config->get('config_template') . '/common/footer.tpl';
        } else {
            $this->template = 'cuyagua/common/footer.tpl';
        }
        
        $this->data['google_analytics_code'] = $this->config->get('google_analytics_code');
        $this->data['live_client_id'] = $this->config->get('social_live_client_id');
        $this->data['facebook_app_id'] = $this->config->get('social_facebook_app_id');
        $this->data['google_client_id'] = $this->config->get('social_google_client_id');
        $this->data['twitter_oauth_token_secret'] = $this->config->get('social_twitter_oauth_token_secret');

        $this->render();
    }
    
    protected function loadJs() {
        $jspath = defined("CDN") ? CDN_JS : HTTP_THEME_JS;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
            $jspath = str_replace("%theme%", $this->config->get('config_template'), $jspath);
            $jsFolder = str_replace("%theme%", $this->config->get('config_template'), DIR_THEME_JS);
        } else {
            $jspath = str_replace("%theme%", "cuyagua", $jspath);
            $jsFolder = str_replace("%theme%", "cuyagua", DIR_THEME_JS);
        }

        if (file_exists($jsFolder . str_replace('/', '', strtolower($this->Route) . '.js'))) {
            if ($this->config->get('config_render_js_in_file')) {
                $javascripts[] = $jsFolder . str_replace('/', '', strtolower($this->Route) . '.js');
            } else {
                $javascripts[] = $jspath . str_replace('/', '', strtolower($this->Route) . '.js');
            }
        }

        $jspath = defined("CDN_JS") ? CDN_JS : HTTP_JS;
        
        // javascript files
        if ($this->user->getId()) {
            $javascripts[] = HTTP_ADMIN . "js/frontend/admin.js";

            if ($this->request->hasQuery('theme_editor') && $this->request->hasQuery('theme_id') && (int) $this->request->getQuery('theme_id') > 0) {
                $javascripts[] = $jspath . "vendor/jquery-ui.min.js";
                $javascripts[] = $jspath . "necojs/neco.css.js";
                $javascripts[] = $jspath . "necojs/neco.colorpicker.js";
                $javascripts[] = HTTP_ADMIN . "js/frontend/theme_editor.js";
            }
        }

        if (count($javascripts)) {
            $this->javascripts = array_merge($this->javascripts, $javascripts);
        }
    }
}
