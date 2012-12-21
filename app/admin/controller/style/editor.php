<?php    
/**
 * ControllerSaleCustomer
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerStyleEditor extends Controller { 
	private $error = array();
  
  	/**
  	 * ControllerStyleBackgrounds::index()
  	 * 
     * @see Load
     * @see Document
     * @see Language
     * @see getList
  	 * @return void 
  	 */
  	public function index() {
        $this->load->library('url');
        $this->data['Url'] = new Url;
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
		      
            if ($this->request->get['f']) {
                if (file_exists(DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/common/home.tpl')) {
                    $folder = DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/';
            	} else {
            		$folder = DIR_CATALOG . 'view/theme/default/';
            	}
                if ($this->request->get['t']=='tpl' && file_exists($folder . str_replace("_","/",$this->request->get['f']))) {
                    $fopen = fopen($folder . str_replace("_","/",$this->request->get['f']),'w+');
                    fputs($fopen,html_entity_decode($this->request->post['code']));
                    fclose($fopen);
                } elseif ($this->request->get['t']=='css') {
                    $fopen = fopen(DIR_CSS . str_replace("_","/",$this->request->get['f']),'w+');
                    fputs($fopen,html_entity_decode($this->request->post['code']));
                    fclose($fopen);
                }
            }
			$this->session->data['success'] = $this->language->get('text_success');
		}
        
  		if (file_exists(DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/common/home.tpl')) {
            $folder = DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/';
    	} else {
    		$folder = DIR_CATALOG . 'view/theme/default/';
    	}
        $directories = glob($folder . "*", GLOB_ONLYDIR);
		$this->data['templates'] = array();
		foreach ($directories as $key => $directory) {
			$this->data['views'][$key]['folder'] = basename($directory);
            $files = glob($directory . "/*.tpl", GLOB_NOSORT);
            foreach ($files as $k => $file) {
    			$this->data['views'][$key]['files'][$k] = str_replace("\\","/",$file) ;
    		}
		}
        
        unset($directories,$folder,$files);
  		if (file_exists(DIR_CSS . 'main.css')) {
            $folder = DIR_CSS;
            $files = glob($folder . "*.css");
    		$this->data['styles'] = array();
    		foreach ($files as $key => $file) {
    			$this->data['styles'][] = basename($file);
                
                
    		}
            
            unset($directories,$files);
            $directories = glob($folder . "*", GLOB_ONLYDIR);
            if ($directories) {
                foreach ($directories as $ky => $directory) {
                    $files = glob($directory . "/*.css", GLOB_NOSORT);
                    if ($files) {
                        foreach ($files as $k => $file) {
                            $this->data['styles'][] = basename($directory) ."/". basename($file);
                        }
            		}
                }
            }
		}
        
        $this->data['action'] = HTTP_HOME . "index.php?r=style/links&token=".$this->request->get['token']."&menu=sistema";
        $this->data['reset'] = HTTP_HOME . "index.php?r=style/links/reset&token=".$this->request->get['token']."&menu=sistema";
        $this->data['cancel'] = HTTP_HOME . "index.php?r=common/home&token=".$this->request->get['token']."&menu=sistema";
        $this->data['msg'] = "<b>Haz click sobre un archivo de la izquierda para comenzar a editar</b>";
        
        if ($this->request->get['f']) {
            if (file_exists(DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/common/home.tpl')) {
                $folder = DIR_CATALOG . 'view/theme/' . $this->config->get('config_template') . '/';
        	} else {
        		$folder = DIR_CATALOG . 'view/theme/default/';
        	}
            if ($this->request->get['t']=='tpl' && file_exists($folder . str_replace("_","/",$this->request->get['f']))) {
                $this->data['code'] = file_get_contents($folder . str_replace("_","/",$this->request->get['f']));
                $this->data['filename'] = str_replace("_","/",$this->request->get['f']);
            } elseif ($this->request->get['t']=='css') {
                $this->data['code'] = utf8_decode(file_get_contents(DIR_CSS . str_replace("_","/",$this->request->get['f'])));
                $this->data['filename'] = str_replace("_","/",$this->request->get['f']);
            } else {
                $this->data['msg'] = "<b>El archivo no existe.</b>";
                $this->data['error'] = true;
            }
        } else {
            $this->data['error'] = true;
        }
        
        // javascript files
        $javascripts[] = "js/vendor/ace/src-noconflict/ace.js";
        $javascripts[] = "js/vendor/ace/src-noconflict/mode-html.js";
        $javascripts[] = "js/vendor/ace/src-noconflict/mode-css.js";
        $javascripts[] = "js/vendor/ace/src-noconflict/mode-javascript.js";
        $javascripts[] = "js/vendor/ace/src-noconflict/mode-php.js";
        
        $this->data['javascripts'] = $this->javascripts = array_merge($javascripts,$this->javascripts);
        
        $scripts[] = array('id'=>'editorScripts','method'=>'ready','script'=>
            "");
        
        $scripts[] = array('id'=>'editorFunctions','method'=>'function','script'=>
            "function loadFile(filepath) {
                $.getJSON('". Url::createAdminUrl('style/editor/file') ."&f=' + encodeURIComponent(filepath),function(response){
                    $('#code').text(response.code);
                    $('#editor').text(response.syntax);
                    $('h2').text(response.filename);
                    var editor = ace.edit('editor');
                    editor.getSession().setValue(response.code);
                });
            }");
        
        $this->data['scripts'] = $this->scripts = array_merge($scripts,$this->scripts);
        
		$this->template = 'style/editor.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    public function file() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        $data = array();
        if ($this->request->get['f'] && file_exists($this->request->get['f'])) {
            $data['code'] = file_get_contents($this->request->get['f']);
            $data['syntax'] = htmlentities($data['code']);
            $data['syntax'] = str_replace("&gt;",">",$data['code']);
            $data['syntax'] = str_replace("&quote;","\"",$data['code']);
            $data['filename'] = basename($this->request->get['f']);
        }
        $this->load->auto('json');
		$this->response->setOutput(Json::encode($data), $this->config->get('config_compression'));  
    }
}
