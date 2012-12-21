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
class ControllerStyleFonts extends Controller { 
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
        $this->setStyleVar('color','h1');
        $this->setStyleVar('font-family','h1');
        $this->setStyleVar('font-weight','h1');
        $this->setStyleVar('font-size','h1');
        $this->setStyleVar('font-style','h1');
        $this->setStyleVar('text-align','h1');
        $this->setStyleVar('text-decoration','h1');
        $this->setStyleVar('text-shadow','h1');
        
        $this->setStyleVar('color','h2');
        $this->setStyleVar('font-family','h2');
        $this->setStyleVar('font-weight','h2');
        $this->setStyleVar('font-size','h2');
        $this->setStyleVar('font-style','h2');
        $this->setStyleVar('text-align','h2');
        $this->setStyleVar('text-decoration','h2');
        $this->setStyleVar('text-shadow','h2');
        
        $this->setStyleVar('color','p');
        $this->setStyleVar('font-family','p');
        $this->setStyleVar('font-weight','p');
        $this->setStyleVar('font-size','p');
        $this->setStyleVar('text-align','p');
        $this->setStyleVar('text-decoration','p');
        $this->setStyleVar('text-shadow','p');
        
        $this->setStyleVar('color','b');
        $this->setStyleVar('font-family','b');
        $this->setStyleVar('font-weight','b');
        $this->setStyleVar('font-size','b');
        $this->setStyleVar('text-align','b');
        $this->setStyleVar('text-decoration','b');
        $this->setStyleVar('text-shadow','b');
        
        // header
        $this->setStyleVar('color','.searchInput','search');
        $this->setStyleVar('font-family','.searchInput','search');
        $this->setStyleVar('font-weight','.searchInput','search');
        $this->setStyleVar('font-size','.searchInput','search');
        $this->setStyleVar('text-align','.searchInput','search');
        $this->setStyleVar('text-decoration','.searchInput','search');
        $this->setStyleVar('text-shadow','.searchInput','search');
        
        // footer
        $this->setStyleVar('color','#footer p','footerP');
        $this->setStyleVar('font-family','#footer p','footerP');
        $this->setStyleVar('font-weight','#footer p','footerP');
        $this->setStyleVar('font-size','#footer p','footerP');
        $this->setStyleVar('text-align','#footer p','footerP');
        $this->setStyleVar('text-decoration','#footer p','footerP');
        $this->setStyleVar('text-shadow','#footer p','footerP');
        
        // category module
        $this->setStyleVar('color','.categoryModule .header','categoryModuleHeader');
        $this->setStyleVar('font-family','.categoryModule .header','categoryModuleHeader');
        $this->setStyleVar('font-weight','.categoryModule .header','categoryModuleHeader');
        $this->setStyleVar('font-size','.categoryModule .header','categoryModuleHeader');
        $this->setStyleVar('text-align','.categoryModule .header','categoryModuleHeader');
        $this->setStyleVar('text-decoration','.categoryModule .header','categoryModuleHeader');
        $this->setStyleVar('text-shadow','.categoryModule .header','categoryModuleHeader');
        
        // manufacturer module
        $this->setStyleVar('color','.manufacturerModule .header','manufacturerModuleHeader');
        $this->setStyleVar('font-family','.manufacturerModule .header','manufacturerModuleHeader');
        $this->setStyleVar('font-weight','.manufacturerModule .header','manufacturerModuleHeader');
        $this->setStyleVar('font-size','.manufacturerModule .header','manufacturerModuleHeader');
        $this->setStyleVar('text-align','.manufacturerModule .header','manufacturerModuleHeader');
        $this->setStyleVar('text-decoration','.manufacturerModule .header','manufacturerModuleHeader');
        $this->setStyleVar('text-shadow','.manufacturerModule .header','manufacturerModuleHeader');
        
        // information module
        $this->setStyleVar('color','.informationModule .header','informationModuleHeader');
        $this->setStyleVar('font-family','.informationModule .header','informationModuleHeader');
        $this->setStyleVar('font-weight','.informationModule .header','informationModuleHeader');
        $this->setStyleVar('font-size','.informationModule .header','informationModuleHeader');
        $this->setStyleVar('text-align','.informationModule .header','informationModuleHeader');
        $this->setStyleVar('text-decoration','.informationModule .header','informationModuleHeader');
        $this->setStyleVar('text-shadow','.informationModule .header','informationModuleHeader');
        
        // cart module
        $this->setStyleVar('color','.cartModule .header','cartModuleHeader');
        $this->setStyleVar('font-family','.cartModule .header','cartModuleHeader');
        $this->setStyleVar('font-weight','.cartModule .header','cartModuleHeader');
        $this->setStyleVar('font-size','.cartModule .header','cartModuleHeader');
        $this->setStyleVar('text-align','.cartModule .header','cartModuleHeader');
        $this->setStyleVar('text-decoration','.cartModule .header','cartModuleHeader');
        $this->setStyleVar('text-shadow','.cartModule .header','cartModuleHeader');
        
        // grid view product name
        $this->setStyleVar('color','.grid_view .name','gridViewName');
        $this->setStyleVar('font-family','.grid_view .name','gridViewName');
        $this->setStyleVar('font-weight','.grid_view .name','gridViewName');
        $this->setStyleVar('font-size','.grid_view .name','gridViewName');
        $this->setStyleVar('text-align','.grid_view .name','gridViewName');
        $this->setStyleVar('text-decoration','.grid_view .name','gridViewName');
        $this->setStyleVar('text-shadow','.grid_view .name','gridViewName');
        
        // grid view product model
        $this->setStyleVar('color','.grid_view .model','gridViewModel');
        $this->setStyleVar('font-family','.grid_view .model','gridViewModel');
        $this->setStyleVar('font-weight','.grid_view .model','gridViewModel');
        $this->setStyleVar('font-size','.grid_view .model','gridViewModel');
        $this->setStyleVar('text-align','.grid_view .model','gridViewModel');
        $this->setStyleVar('text-decoration','.grid_view .model','gridViewModel');
        $this->setStyleVar('text-shadow','.grid_view .model','gridViewModel');
        
        // grid view product price
        $this->setStyleVar('color','.grid_view .price','gridViewPrice');
        $this->setStyleVar('font-family','.grid_view .price','gridViewPrice');
        $this->setStyleVar('font-weight','.grid_view .price','gridViewPrice');
        $this->setStyleVar('font-size','.grid_view .price','gridViewPrice');
        $this->setStyleVar('text-align','.grid_view .price','gridViewPrice');
        $this->setStyleVar('text-decoration','.grid_view .price','gridViewPrice');
        $this->setStyleVar('text-shadow','.grid_view .price','gridViewPrice');
        
        // grid view product new price
        $this->setStyleVar('color','.grid_view .new_price','gridViewNewPrice');
        $this->setStyleVar('font-family','.grid_view .new_price','gridViewNewPrice');
        $this->setStyleVar('font-weight','.grid_view .new_price','gridViewNewPrice');
        $this->setStyleVar('font-size','.grid_view .new_price','gridViewNewPrice');
        $this->setStyleVar('text-align','.grid_view .new_price','gridViewNewPrice');
        $this->setStyleVar('text-decoration','.grid_view .new_price','gridViewNewPrice');
        $this->setStyleVar('text-shadow','.grid_view .new_price','gridViewNewPrice');
        
        // grid view product old price
        $this->setStyleVar('color','.grid_view .old_price','gridViewOldPrice');
        $this->setStyleVar('font-family','.grid_view .old_price','gridViewOldPrice');
        $this->setStyleVar('font-weight','.grid_view .old_price','gridViewOldPrice');
        $this->setStyleVar('font-size','.grid_view .old_price','gridViewOldPrice');
        $this->setStyleVar('text-align','.grid_view .old_price','gridViewOldPrice');
        $this->setStyleVar('text-decoration','.grid_view .old_price','gridViewOldPrice');
        $this->setStyleVar('text-shadow','.grid_view .old_price','gridViewOldPrice');
        
        // over view product name
        $this->setStyleVar('color','#overview .name','overViewName');
        $this->setStyleVar('font-family','#overview .name','overViewName');
        $this->setStyleVar('font-weight','#overview .name','overViewName');
        $this->setStyleVar('font-size','#overview .name','overViewName');
        $this->setStyleVar('text-align','#overview .name','overViewName');
        $this->setStyleVar('text-decoration','#overview .name','overViewName');
        $this->setStyleVar('text-shadow','#overview .name','overViewName');
        
        // over view product model
        $this->setStyleVar('color','#overview .model','overViewModel');
        $this->setStyleVar('font-family','#overview .model','overViewModel');
        $this->setStyleVar('font-weight','#overview .model','overViewModel');
        $this->setStyleVar('font-size','#overview .model','overViewModel');
        $this->setStyleVar('text-align','#overview .model','overViewModel');
        $this->setStyleVar('text-decoration','#overview .model','overViewModel');
        $this->setStyleVar('text-shadow','#overview .model','overViewModel');
        
        // over view product price
        $this->setStyleVar('color','#overview .price','overViewPrice');
        $this->setStyleVar('font-family','#overview .price','overViewPrice');
        $this->setStyleVar('font-weight','#overview .price','overViewPrice');
        $this->setStyleVar('font-size','#overview .price','overViewPrice');
        $this->setStyleVar('text-align','#overview .price','overViewPrice');
        $this->setStyleVar('text-decoration','#overview .price','overViewPrice');
        $this->setStyleVar('text-shadow','#overview .price','overViewPrice');
        
        // over view product new price
        $this->setStyleVar('color','#overview .new_price','overViewNewPrice');
        $this->setStyleVar('font-family','#overview .new_price','overViewNewPrice');
        $this->setStyleVar('font-weight','#overview .new_price','overViewNewPrice');
        $this->setStyleVar('font-size','#overview .new_price','overViewNewPrice');
        $this->setStyleVar('text-align','#overview .new_price','overViewNewPrice');
        $this->setStyleVar('text-decoration','#overview .new_price','overViewNewPrice');
        $this->setStyleVar('text-shadow','#overview .new_price','overViewNewPrice');
        
        // over view product old price
        $this->setStyleVar('color','#overview .old_price','overViewOldPrice');
        $this->setStyleVar('font-family','#overview .old_price','overViewOldPrice');
        $this->setStyleVar('font-weight','#overview .old_price','overViewOldPrice');
        $this->setStyleVar('font-size','#overview .old_price','overViewOldPrice');
        $this->setStyleVar('text-align','#overview .old_price','overViewOldPrice');
        $this->setStyleVar('text-decoration','#overview .old_price','overViewOldPrice');
        $this->setStyleVar('text-shadow','#overview .old_price','overViewOldPrice');
        
        
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
        
        $this->data['action'] = HTTP_HOME . "index.php?r=style/fonts&token=".$this->request->get['token']."&menu=sistema";
        $this->data['reset'] = HTTP_HOME . "index.php?r=style/fonts/reset&token=".$this->request->get['token']."&menu=sistema";
        $this->data['cancel'] = HTTP_HOME . "index.php?r=common/home&token=".$this->request->get['token']."&menu=sistema";
        
		$this->template = 'style/fonts.tpl';
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
