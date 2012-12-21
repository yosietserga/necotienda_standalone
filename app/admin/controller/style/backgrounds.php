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
class ControllerStyleBackgrounds extends Controller { 
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
        
        $this->data['entry_image']      = $this->language->get("entry_image");
        $this->data['entry_repeat']     = $this->language->get("entry_repeat");
        $this->data['entry_gradient']   = $this->language->get("entry_gradient");
        $this->data['entry_position']     = $this->language->get("entry_position");
        $this->data['entry_attachment']   = $this->language->get("entry_attachment");
        $this->data['entry_transparent']   = $this->language->get("entry_transparent");
        
        $this->setImageVar('body_image','body');
        $this->setImageVar('header_image','#header');
        $this->setImageVar('nav_image','#nav');
        $this->setImageVar('column_left_image','#column_left');
        $this->setImageVar('column_right_image','#column_right');
        $this->setImageVar('content_image','#content');
        $this->setImageVar('maincontent_image','#maincontent');
        $this->setImageVar('categoryModuleHeader_image','.categoryModule .header');
        $this->setImageVar('categoryModuleContent_image','.categoryModule .content');
        $this->setImageVar('manufacturerModuleHeader_image','.manufacturerModule .header');
        $this->setImageVar('manufacturerModuleContent_image','.manufacturerModule .content');
        $this->setImageVar('cartModuleHeader_image','.cartModule .header');
        $this->setImageVar('cartModuleContent_image','.cartModule .content');
        $this->setImageVar('informationModuleHeader_image','.informationModule .header');
        $this->setImageVar('informationModuleContent_image','.informationModule .content');
        $this->setImageVar('productPreview_image','.product_preview');
        $this->setImageVar('listViewEven_image','.list_view .even');
        $this->setImageVar('listViewOdd_image','.list_view .odd');
        $this->setImageVar('footer_image','#footer');
        
        $this->setStyleVar('background-repeat','body');
        $this->setStyleVar('background-position','body');
        $this->setStyleVar('background-attachment','body');
        $this->setStyleVar('background','body');
        
        $this->setStyleVar('background-repeat','#header','header');
        $this->setStyleVar('background-position','#header','header');
        $this->setStyleVar('background','#header','header');
        
        $this->setStyleVar('background-repeat','#nav','nav');
        $this->setStyleVar('background-position','#nav','nav');
        $this->setStyleVar('background','#nav','nav');
        
        $this->setStyleVar('background-repeat','#maincontent','maincontent');
        $this->setStyleVar('background-position','#maincontent','maincontent');
        $this->setStyleVar('background','#maincontent','maincontent');
        
        $this->setStyleVar('background-repeat','#column_left','column_left');
        $this->setStyleVar('background','#column_left','column_left');
        
        $this->setStyleVar('background-repeat','#column_right','column_right');
        $this->setStyleVar('background','#column_right','column_right');
        
        $this->setStyleVar('background-repeat','#content','content');
        $this->setStyleVar('background-position','#content','content');
        $this->setStyleVar('background','#content','content');
        
        $this->setStyleVar('background-repeat','#footer','footer');
        $this->setStyleVar('background-position','#footer','footer');
        $this->setStyleVar('background','#footer','footer');
        
        $this->setStyleVar('background-repeat','.cartModule .header','cartModuleHeader');
        $this->setStyleVar('background','.cartModule .header','cartModuleHeader');
        $this->setStyleVar('background-repeat','.cartModule .content','cartModuleContent');
        $this->setStyleVar('background','.cartModule .content','cartModuleContent');
        
        $this->setStyleVar('background-repeat','.categoryModule .header','categoryModuleHeader');
        $this->setStyleVar('background','.categoryModule .header','categoryModuleHeader');
        $this->setStyleVar('background-repeat','.categoryModule .content','categoryModuleContent');
        $this->setStyleVar('background','.categoryModule .content','categoryModuleContent');
        
        $this->setStyleVar('background-repeat','.manufacturerModule .header','manufacturerModuleHeader');
        $this->setStyleVar('background','.manufacturerModule .header','manufacturerModuleHeader');
        $this->setStyleVar('background-repeat','.manufacturerModule .content','manufacturerModuleContent');
        $this->setStyleVar('background','.manufacturerModule .content','manufacturerModuleContent');
        
        $this->setStyleVar('background-repeat','.informationModule .header','informationModuleHeader');
        $this->setStyleVar('background','.informationModule .header','informationModuleHeader');
        $this->setStyleVar('background-repeat','.informationModule .content','informationModuleContent');
        $this->setStyleVar('background','.informationModule .content','informationModuleContent');
        
        $this->setStyleVar('background-repeat','.product_view','productView');
        $this->setStyleVar('background','.product_view','productView');
        
        $this->setStyleVar('background-repeat','.list_view .even','listViewEven');
        $this->setStyleVar('background','.list_view .even','listViewEven');
        
        $this->setStyleVar('background-repeat','.list_view .odd','listViewOdd');
        $this->setStyleVar('background','.list_view .odd','listViewOdd');
        
        $this->data['repeats'] = array(
                                'no-repeat'=>'No Repetir',
                                'repeat-x'=>'Repetir en el eje X',
                                'repeat-y'=>'Repetir en el eje Y',
                                'repeat'=>'Repetir a todos lados'
                            );
        
        $this->data['positions'] = array(
                                'center top'=>'Centrado',
                                'left top'=>'Izquierda',
                                'right top'=>'Derecha'
                            );
        
        $this->data['attachments'] = array(
                                'scroll'=>'No',
                                'fixed'=>'Si'
                            );
        
        $this->data['token'] = $this->request->get['token'];
        
        $this->data['action'] = HTTP_HOME . "index.php?r=style/backgrounds&token=".$this->request->get['token']."&menu=sistema";
        $this->data['reset'] = HTTP_HOME . "index.php?r=style/backgrounds/reset&token=".$this->request->get['token']."&menu=sistema";
        $this->data['cancel'] = HTTP_HOME . "index.php?r=common/home&token=".$this->request->get['token']."&menu=sistema";
        
		$this->template = 'style/backgrounds.tpl';
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
        $this->redirect("index.php?r=style/backgrounds&token=".$this->request->get['token']."&menu=sistema");
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
