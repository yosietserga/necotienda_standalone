<?php  class ControllerCommonFooter extends Controller {
	protected function index() {
		$this->language->load('common/footer');
        $this->load->library('user');
        
        $this->data['config_js_security'] = $this->config->get('config_js_security');
        
		$this->data['text_powered_by'] = sprintf($this->language->get('text_powered_by'), $this->config->get('config_name'), date('Y', time()));
		
		$this->id = 'footer';
        
        // SCRIPTS
        $scripts[] = array('id'=>'search','method'=>'function','script'=>
        "function moduleSearch() {
       	    url = 'index.php?r=store/search';
            var filter_keyword = jQuery('#filter_keyword').attr('value');
            if (filter_keyword) {
                url += '&keyword=' + encodeURIComponent(filter_keyword);
            }
            var filter_category_id = jQuery('#filter_category_id').attr('value');
            if (filter_category_id) {
                url += '&category_id=' + filter_category_id;
            }
            window.location = url;
        }");
        
        $this->scripts = array_merge($this->scripts,$scripts);
        
        $r_output = $w_output = $s_output = $f_output = "";
        $script_keys = array();
        foreach ($this->scripts as $k => $script) { 
            if (in_array($script['id'],$script_keys)) continue;
            $script_keys[$k] = $script['id'];
            switch($script['method']) {
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
        
        $this->data['scripts'] = ($r_output) ? "<script>$(function(){".$r_output."});</script>" : "";
        $this->data['scripts'] .= ($w_output) ? "<script>$.window({".$w_output."});</script>" : "";
        $this->data['scripts'] .= ($f_output) ? "<script>".$f_output."</script>" : "";
        
        // javascript files
        $jspath = defined("CDN_JS") ? CDN_JS : HTTP_JS;
        
        $javascripts[] = $jspath."plugins.js";
        $javascripts[] = $jspath."main.js";
        
        if ($this->user->getId()) {
            $javascripts[] = $jspath."vendor/jquery-ui.min.js";
            $javascripts[] = $jspath."vendor/farbtastic/farbtastic.js";
            $javascripts[] = $jspath."necojs/neco.colorpicker.js";
            $javascripts[] = $jspath."admin.js";
        }
        
        $this->data['javascripts'] = $this->javascripts = array_merge($this->javascripts, $javascripts);
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/common/footer.tpl';
		} else {
			$this->template = 'default/common/footer.tpl';
		}
		
		if ($this->config->get('google_analytics_status')) {
			$this->data['google_analytics'] = html_entity_decode($this->config->get('google_analytics_code'), ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['google_analytics'] = '';
		}
		
		$this->render();
	}
}
