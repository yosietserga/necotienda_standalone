<?php

class ControllerCommonFooter extends Controller {

    protected function index() {
        $this->load->language('common/footer');
        
        $this->data['text_footer'] = sprintf($this->language->get('text_footer'), VERSION);

        $this->id = 'footer';
        $this->template = 'common/footer.tpl';

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
        
        $this->loadJs();
        foreach ($this->javascripts as $key => $js) {
            $f_output .= file_get_contents($js);
            unset($this->javascripts[$key]);
        }
        $f_output = str_replace('{%token%}', $this->request->getQuery('token'), $f_output);
        $f_output = str_replace('{%http_home%}', HTTP_HOME, $f_output);

        $this->data['scripts'] = ($r_output) ? "<script>$(function() { " . $r_output . " });</script>" : "";
        $this->data['scripts'] .= ($w_output) ? "<script>window.onload = function() { " . $w_output . "  };</script>" : "";
        $this->data['scripts'] .= ($f_output) ? "<script>" . $f_output . "</script>" : "";

        $this->data['javascripts'] = $this->javascripts = array_merge($javascripts, $this->javascripts);

        $this->render();
    }
    
    protected function loadJs() {
        $javascripts[] = "js/vendor/jquery-ui.min.js";
        $javascripts[] = "js/necojs/neco.form.js";
        $javascripts[] = "js/vendor/jquery.sidr.min.js";
        $javascripts[] = "js/vendor/jquery.chosen/chosen.jquery.min.js";
        $javascripts[] = "js/plugins.js";
        $javascripts[] = "js/main.js";

        if (file_exists(DIR_ADMIN_JS . str_replace('controller', '', strtolower($this->ClassName) . '.js'))) {
            $javascripts[] = HTTP_ADMIN_JS . str_replace('controller', '', strtolower($this->ClassName) . '.js');
        }

        $this->javascripts = array_merge($javascripts, $this->javascripts);        
    }
}
