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
class ControllerStyleLinks extends Controller { 
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
		$this->document->title = $this->language->get('heading_title');
		
        if (isset($_POST['Style'])) {
            $selectors = $this->getSelectors();
            foreach($_POST['Style'] as $selector => $properties) {
            $data = array();
               if (!in_array($selector,$selectors)) continue;
                foreach ($properties as $property => $value) {
                    if (($property == 'background-repeat') && empty($properties['background-image'])) continue;
                    if (($property == 'background-position') && empty($properties['background-image'])) continue;
                    if (($property == 'background-attachment') && empty($properties['background-image']) && ($selector != "body")) continue;
                    if (empty($value)) continue;
                    $data[$property] = $value;
                }
                $this->modelStyle->edit($selector,$data);
            }
            $this->estilos();
        }
        
        
        $this->data['button_save']              = $this->language->get("button_save");
        $this->data['button_cancel']              = $this->language->get("button_cancel");
        $this->data['button_reset']              = $this->language->get("button_reset");
        
        $this->data['tab_general']              = $this->language->get("tab_general");
        $this->data['tab_header']               = $this->language->get("tab_header");
        $this->data['tab_nav']                  = $this->language->get("tab_nav");
        $this->data['tab_maincontent']          = $this->language->get("tab_maincontent");
        $this->data['tab_column_left']          = $this->language->get("tab_column_left");
        $this->data['tab_column_right']         = $this->language->get("tab_column_right");
        $this->data['tab_content']              = $this->language->get("tab_content");
        $this->data['tab_footer']               = $this->language->get("tab_footer");
        $this->data['tab_category_module']      = $this->language->get("tab_category_module");
        $this->data['tab_manufacturer_module']  = $this->language->get("tab_manufacturer_module");
        $this->data['tab_information_module']   = $this->language->get("tab_information_module");
        $this->data['tab_cart_module']          = $this->language->get("tab_cart_module");
        $this->data['tab_special_module']       = $this->language->get("tab_special_module");
        $this->data['tab_products']             = $this->language->get("tab_products");
        
        $this->data['entry_color']      = $this->language->get("entry_color");
        $this->data['entry_size']     = $this->language->get("entry_size");
        $this->data['entry_weight']   = $this->language->get("entry_weight");
        $this->data['entry_family']   = $this->language->get("entry_family");
        $this->data['entry_align']     = $this->language->get("entry_align");
        $this->data['entry_decoration']   = $this->language->get("entry_decoration");
        $this->data['entry_style']   = $this->language->get("entry_style");
        
        $this->data['titles']   = $this->language->get("titles");
        $this->data['subtitles']   = $this->language->get("subtitles");
        $this->data['parrafos']   = $this->language->get("parrafos");
        $this->data['enfasis']   = $this->language->get("enfasis");
        $this->data['busqueda']   = $this->language->get("busqueda");
        
        //globals
        $this->setStyleVar('color','a, a:visited','a');
        $this->setStyleVar('font-family','a, a:visited','a');
        $this->setStyleVar('font-weight','a, a:visited','a');
        $this->setStyleVar('font-size','a, a:visited','a');
        $this->setStyleVar('font-style','a, a:visited','a');
        $this->setStyleVar('text-align','a, a:visited','a');
        $this->setStyleVar('text-decoration','a, a:visited','a');
        $this->setStyleVar('text-shadow','a, a:visited','a');
        
        $this->setStyleVar('color','a:hover','ahover');
        $this->setStyleVar('font-family','a:hover','ahover');
        $this->setStyleVar('font-weight','a:hover','ahover');
        $this->setStyleVar('font-size','a:hover','ahover');
        $this->setStyleVar('font-style','a:hover','ahover');
        $this->setStyleVar('text-align','a:hover','ahover');
        $this->setStyleVar('text-decoration','a:hover','ahover');
        $this->setStyleVar('text-shadow','a:hover','ahover');
        
        $this->setStyleVar('color','a:active','aactive');
        $this->setStyleVar('font-family','a:active','aactive');
        $this->setStyleVar('font-weight','a:active','aactive');
        $this->setStyleVar('font-size','a:active','aactive');
        $this->setStyleVar('text-align','a:active','aactive');
        $this->setStyleVar('text-decoration','a:active','aactive');
        $this->setStyleVar('text-shadow','a:active','aactive');
        
        // header
        $this->setStyleVar('color','#links a, #links a:visited','linksa');
        $this->setStyleVar('font-family','#links a, #links a:visited','linksa');
        $this->setStyleVar('font-weight','#links a, #links a:visited','linksa');
        $this->setStyleVar('font-size','#links a, #links a:visited','linksa');
        $this->setStyleVar('font-style','#links a, #links a:visited','linksa');
        $this->setStyleVar('text-align','#links a, #links a:visited','linksa');
        $this->setStyleVar('text-decoration','#links a, #links a:visited','linksa');
        $this->setStyleVar('text-shadow','#links a, #links a:visited','linksa');
        
        $this->setStyleVar('color','#links a:hover','linksahover');
        $this->setStyleVar('font-family','#links a:hover','linksahover');
        $this->setStyleVar('font-weight','#links a:hover','linksahover');
        $this->setStyleVar('font-size','#links a:hover','linksahover');
        $this->setStyleVar('font-style','#links a:hover','linksahover');
        $this->setStyleVar('text-align','#links a:hover','linksahover');
        $this->setStyleVar('text-decoration','#links a:hover','linksahover');
        $this->setStyleVar('text-shadow','#links a:hover','linksahover');
        
        $this->setStyleVar('color','#links a:active','linksaactive');
        $this->setStyleVar('font-family','#links a:active','linksaactive');
        $this->setStyleVar('font-weight','#links a:active','linksaactive');
        $this->setStyleVar('font-size','#links a:active','linksaactive');
        $this->setStyleVar('text-align','#links a:active','linksaactive');
        $this->setStyleVar('text-decoration','#links a:active','linksaactive');
        $this->setStyleVar('text-shadow','#links a:active','linksaactive');
        
        // footer
        $this->setStyleVar('color','#footer a, #footer a:visited','footera');
        $this->setStyleVar('font-family','#footer a, #footer a:visited','footera');
        $this->setStyleVar('font-weight','#footer a, #footer a:visited','footera');
        $this->setStyleVar('font-size','#footer a, #footer a:visited','footera');
        $this->setStyleVar('font-style','#footer a, #footer a:visited','footera');
        $this->setStyleVar('text-align','#footer a, #footer a:visited','footera');
        $this->setStyleVar('text-decoration','#footer a, #footer a:visited','footera');
        $this->setStyleVar('text-shadow','#footer a, #footer a:visited','footera');
        
        $this->setStyleVar('color','#footer a:hover','footerahover');
        $this->setStyleVar('font-family','#footer a:hover','footerahover');
        $this->setStyleVar('font-weight','#footer a:hover','footerahover');
        $this->setStyleVar('font-size','#footer a:hover','footerahover');
        $this->setStyleVar('font-style','#footer a:hover','footerahover');
        $this->setStyleVar('text-align','#footer a:hover','footerahover');
        $this->setStyleVar('text-decoration','#footer a:hover','footerahover');
        $this->setStyleVar('text-shadow','#footer a:hover','footerahover');
        
        $this->setStyleVar('color','#footer a:active','footeraactive');
        $this->setStyleVar('font-family','#footer a:active','footeraactive');
        $this->setStyleVar('font-weight','#footer a:active','footeraactive');
        $this->setStyleVar('font-size','#footer a:active','footeraactive');
        $this->setStyleVar('text-align','#footer a:active','footeraactive');
        $this->setStyleVar('text-decoration','#footer a:active','footeraactive');
        $this->setStyleVar('text-shadow','#footer a:active','footeraactive');
        
        // category module
        $this->setStyleVar('color','.categoryModule a, .categoryModule a:visited','categoryModulea');
        $this->setStyleVar('font-family','.categoryModule a, .categoryModule a:visited','categoryModulea');
        $this->setStyleVar('font-weight','.categoryModule a, .categoryModule a:visited','categoryModulea');
        $this->setStyleVar('font-size','.categoryModule a, .categoryModule a:visited','categoryModulea');
        $this->setStyleVar('font-style','.categoryModule a, .categoryModule a:visited','categoryModulea');
        $this->setStyleVar('text-align','.categoryModule a, .categoryModule a:visited','categoryModulea');
        $this->setStyleVar('text-decoration','.categoryModule a, .categoryModule a:visited','categoryModulea');
        $this->setStyleVar('text-shadow','.categoryModule a, .categoryModule a:visited','categoryModulea');
        
        $this->setStyleVar('color','.categoryModule a:hover');
        $this->setStyleVar('font-family','.categoryModule a:hover','categoryModuleahover');
        $this->setStyleVar('font-weight','.categoryModule a:hover','categoryModuleahover');
        $this->setStyleVar('font-size','.categoryModule a:hover','categoryModuleahover');
        $this->setStyleVar('font-style','.categoryModule a:hover','categoryModuleahover');
        $this->setStyleVar('text-align','.categoryModule a:hover','categoryModuleahover');
        $this->setStyleVar('text-decoration','.categoryModule a:hover','categoryModuleahover');
        $this->setStyleVar('text-shadow','.categoryModule a:hover','categoryModuleahover');
        
        $this->setStyleVar('color','.categoryModule a:active','categoryModuleaactive');
        $this->setStyleVar('font-family','.categoryModule a:active','categoryModuleaactive');
        $this->setStyleVar('font-weight','.categoryModule a:active','categoryModuleaactive');
        $this->setStyleVar('font-size','.categoryModule a:active','categoryModuleaactive');
        $this->setStyleVar('text-align','.categoryModule a:active','categoryModuleaactive');
        $this->setStyleVar('text-decoration','.categoryModule a:active','categoryModuleaactive');
        $this->setStyleVar('text-shadow','.categoryModule a:active','categoryModuleaactive');
        
        // information module
        $this->setStyleVar('color','.informationModule a, .informationModule a:visited','informationModulea');
        $this->setStyleVar('font-family','.informationModule a, .informationModule a:visited','informationModulea');
        $this->setStyleVar('font-weight','.informationModule a, .informationModule a:visited','informationModulea');
        $this->setStyleVar('font-size','.informationModule a, .informationModule a:visited','informationModulea');
        $this->setStyleVar('font-style','.informationModule a, .informationModule a:visited','informationModulea');
        $this->setStyleVar('text-align','.informationModule a, .informationModule a:visited','informationModulea');
        $this->setStyleVar('text-decoration','.informationModule a, .informationModule a:visited','informationModulea');
        $this->setStyleVar('text-shadow','.informationModule a, .informationModule a:visited','informationModulea');
        
        $this->setStyleVar('color','.informationModule a:hover');
        $this->setStyleVar('font-family','.informationModule a:hover','informationModuleahover');
        $this->setStyleVar('font-weight','.informationModule a:hover','informationModuleahover');
        $this->setStyleVar('font-size','.informationModule a:hover','informationModuleahover');
        $this->setStyleVar('font-style','.informationModule a:hover','informationModuleahover');
        $this->setStyleVar('text-align','.informationModule a:hover','informationModuleahover');
        $this->setStyleVar('text-decoration','.informationModule a:hover','informationModuleahover');
        $this->setStyleVar('text-shadow','.informationModule a:hover','informationModuleahover');
        
        $this->setStyleVar('color','.informationModule a:active','informationModuleaactive');
        $this->setStyleVar('font-family','.informationModule a:active','informationModuleaactive');
        $this->setStyleVar('font-weight','.informationModule a:active','informationModuleaactive');
        $this->setStyleVar('font-size','.informationModule a:active','informationModuleaactive');
        $this->setStyleVar('text-align','.informationModule a:active','informationModuleaactive');
        $this->setStyleVar('text-decoration','.informationModule a:active','informationModuleaactive');
        $this->setStyleVar('text-shadow','.informationModule a:active','informationModuleaactive');
        
        // cart module
        $this->setStyleVar('color','.cartModule a, .cartModule a:visited','cartModulea');
        $this->setStyleVar('font-family','.cartModule a, .cartModule a:visited','cartModulea');
        $this->setStyleVar('font-weight','.cartModule a, .cartModule a:visited','cartModulea');
        $this->setStyleVar('font-size','.cartModule a, .cartModule a:visited','cartModulea');
        $this->setStyleVar('font-style','.cartModule a, .cartModule a:visited','cartModulea');
        $this->setStyleVar('text-align','.cartModule a, .cartModule a:visited','cartModulea');
        $this->setStyleVar('text-decoration','.cartModule a, .cartModule a:visited','cartModulea');
        $this->setStyleVar('text-shadow','.cartModule a, .cartModule a:visited','cartModulea');
        
        $this->setStyleVar('color','.cartModule a:hover');
        $this->setStyleVar('font-family','.cartModule a:hover','cartModuleahover');
        $this->setStyleVar('font-weight','.cartModule a:hover','cartModuleahover');
        $this->setStyleVar('font-size','.cartModule a:hover','cartModuleahover');
        $this->setStyleVar('font-style','.cartModule a:hover','cartModuleahover');
        $this->setStyleVar('text-align','.cartModule a:hover','cartModuleahover');
        $this->setStyleVar('text-decoration','.cartModule a:hover','cartModuleahover');
        $this->setStyleVar('text-shadow','.cartModule a:hover','cartModuleahover');
        
        $this->setStyleVar('color','.cartModule a:active','cartModuleaactive');
        $this->setStyleVar('font-family','.cartModule a:active','cartModuleaactive');
        $this->setStyleVar('font-weight','.cartModule a:active','cartModuleaactive');
        $this->setStyleVar('font-size','.cartModule a:active','cartModuleaactive');
        $this->setStyleVar('text-align','.cartModule a:active','cartModuleaactive');
        $this->setStyleVar('text-decoration','.cartModule a:active','cartModuleaactive');
        $this->setStyleVar('text-shadow','.cartModule a:active','cartModuleaactive');
        
        $this->data['families'] = array(
                                'Verdana, Geneva, sans-serif'=>'Verdana',
                                'Georgia, \'Times New Roman\', Times, serif'=>'Georgia',
                                '\'Courier New\', Courier, monospace'=>'Courier New',
                                'Arial, Helvetica, sans-serif'=>'Arial',
                                'Tahoma, Geneva, sans-serif'=>'Tahoma',
                                '\'Trebuchet MS\', Arial, Helvetica, sans-serif'=>'Trebuchet MS',
                                '\'Palatino Linotype\', \'Book Antiqua\', Palatino, serif'=>'Palatino Linotype',
                                '\'Times New Roman\', Times, serif'=>'Times New Roman',
                                '\'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif'=>'Lucida Sans Unicode',
                                '\'MS Serif\', \'New York\', serif'=>'MS Serif',
                                '\'Lucida Console\', Monaco, monospace'=>'Lucida Console',
                                '\'MS Serif\', \'New York\', serif'=>'MS Serif',
                                '\'Comic Sans MS\', cursive'=>'Comic Sans MS'
                            );
        
        $this->data['sizes'] = array(
                                '8px'=>'8',
                                '9px'=>'9',
                                '10px'=>'10',
                                '11px'=>'11',
                                '12px'=>'12',
                                '14px'=>'14',
                                '18px'=>'18',
                                '22px'=>'22',
                                '24px'=>'24',
                                '28px'=>'28',
                                '32px'=>'32',
                                '36px'=>'36',
                                '40px'=>'40',
                                '44px'=>'44',
                                '48px'=>'48',
                                '54px'=>'54',
                                '60px'=>'60',
                                '72px'=>'72',
                            );
        
        $this->data['bold'] = array(
                                'normal'=>'No',
                                'bold'=>'Si'
                            );
                            
        $this->data['italic'] = array(
                                'normal'=>'No',
                                'italic'=>'Si'
                            );
                            
        $this->data['underline'] = array(
                                'none'=>'No',
                                'underline'=>'Si'
                            );
        
        $this->data['token'] = $this->request->get['token'];
        
        $this->data['action'] = HTTP_HOME . "index.php?r=style/links&token=".$this->request->get['token']."&menu=sistema";
        $this->data['reset'] = HTTP_HOME . "index.php?r=style/links/reset&token=".$this->request->get['token']."&menu=sistema";
        $this->data['cancel'] = HTTP_HOME . "index.php?r=common/home&token=".$this->request->get['token']."&menu=sistema";
        
		$this->template = 'style/links.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    public function reset() {
        $this->load->auto("style/style");
            $selectors = $this->getSelectors();
        foreach ($selectors as $selector) {
            $this->modelStyle->delete($selector);
        }
        
            $csspath = defined("CDN") ? CDN.CSS : DIR_CATALOG.CSS;
            $csspath = str_replace("\\\\","\\",$csspath);
            $csspath = str_replace("//","/",$csspath);
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
    		  $csspath = str_replace("%theme%",$this->config->get('config_template'),$csspath);
    		} else {
    		  $csspath = str_replace("%theme%","default",$csspath);
    		}
        unlink($csspath."custom.css");
        $this->redirect("index.php?r=style/fonts&token=".$this->request->get['token']."&menu=sistema");
    }
    
    /** Setting::style
     * genera un archivo CSS con los parámetros especificados
     * @return string CSS FILE
     * */
     public function estilos() {
		$this->load->auto('style/style');
            $selectors = $this->getSelectors();
            $cssOutput = "";
            
            foreach ($selectors as $selector) {
                $properties = $this->modelStyle->getStyles($selector);
                if (empty($properties)) continue;
                $cssOutput .= $selector . " { ";
                if (is_array($properties) && count($properties)) {
                    foreach ($properties as $property => $value) {
                        if (empty($value)) continue;
                        if (($property == 'background-repeat') && empty($properties['background-image'])) continue;
                        if (($property == 'background-position') && empty($properties['background-image'])) continue;
                        if (($property == 'background-attachment') && empty($properties['background-image']) && ($selector != "body")) continue;
                        if (strpos($property,"image")) $value = "url(" . HTTP_IMAGE . $value .")";
                        if ($property=="background") {
                            $cssOutput .= $value;
                        } else {
                            $cssOutput .= str_replace("_","-",$property) . ":" . $value . " !important;";
                        }
                        //TODO: revisar porque se guardan registros duplicados de otros selectores
                        /*
                        if (($property == "background-transparent") && ($selector == "#maincontent")) {
                            $cssOutput .= "background:transparent !important;";
                        }
                        */
                    }
                }
                $cssOutput .= "}";
            }
            $csspath = defined("CDN") ? CDN.CSS : DIR_CATALOG.CSS;
            $csspath = str_replace("\\\\","\\",$csspath);
            $csspath = str_replace("//","/",$csspath);
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
    		  $csspath = str_replace("%theme%",$this->config->get('config_template'),$csspath);
    		} else {
    		  $csspath = str_replace("%theme%","default",$csspath);
    		}
            
            file_put_contents($csspath."custom.css",$cssOutput);
            
     }
	
    public function getSelectors() {
        return array (
                        "h1",
                        "h2",
                        "p",
                        "b",
                        "a, a:visited",
                        "a:hover",
                        "a:active",
                        "input",
                        "select",
                        "body",
                        "#header",
                        "#links a, #links a:visited",
                        "#links a:hover",
                        "#links a:active",
                        ".searchInput",
                        "a.searchButton",
                        "a.searchButton:hover",
                        "a.searchButton:active",
                        "#nav",
                        "#column_left",
                        "#column_right",
                        "#content",
                        "#maincontent",
                        "#footer",
                        "#footer p",
                        "#footer a, #footer a:visited",
                        "#footer a:hover",
                        "#footer a:active",
                        ".categoryModule a, .categoryModule a:visited",
                        ".categoryModule a:hover",
                        ".categoryModule a:active",
                        ".categoryModule .header",
                        ".categoryModule .content",
                        ".informationModule .header",
                        ".informationModule a, .informationModule a:visited",
                        ".informationModule a:hover",
                        ".informationModule a:active",
                        ".informationModule .content",
                        ".manufacturerModule .header",
                        ".manufacturerModule .content",
                        ".cartModule a, .cartModule a:visited",
                        ".cartModule .header",
                        ".cartModule .content",
                        ".product_preview",
                        ".list_view .even",
                        ".list_view .odd",
                        ".list_view .name",
                        ".list_view .model",
                        ".list_view .overview",
                        ".list_view .price",
                        ".list_view .new_price",
                        ".list_view .old_price",
                        ".grid_view .name",
                        ".grid_view .model",
                        ".grid_view .price",
                        ".grid_view .new_price",
                        ".grid_view .old_price",
                        "#overview .name",
                        "#overview .model",
                        "#overview .price",
                        "#overview .new_price",
                        "#overview .old_price",
                        ".button_add_small",
                        ".button_add_small:hover",
                        ".button_add_small:active",
                        ".button_see_small",
                        ".button_see_small:hover",
                        ".button_see_small:active",
                    );
    }
}
