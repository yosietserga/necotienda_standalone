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
class ControllerStyleButtons extends Controller { 
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
        
        $this->data['busqueda']              = $this->language->get("busqueda");
        $this->data['tab_header']               = $this->language->get("tab_header");
        $this->data['tab_products']             = $this->language->get("tab_products");
        
        $this->data['entry_image']      = $this->language->get("entry_image");
        $this->data['entry_repeat']     = $this->language->get("entry_repeat");
        $this->data['entry_gradient']   = $this->language->get("entry_gradient");
        $this->data['entry_position']     = $this->language->get("entry_position");
        $this->data['entry_attachment']   = $this->language->get("entry_attachment");
        $this->data['entry_transparent']   = $this->language->get("entry_transparent");
        $this->data['entry_color']      = $this->language->get("entry_color");
        $this->data['entry_size']     = $this->language->get("entry_size");
        $this->data['entry_weight']   = $this->language->get("entry_weight");
        $this->data['entry_family']   = $this->language->get("entry_family");
        $this->data['entry_align']     = $this->language->get("entry_align");
        $this->data['entry_underline']   = $this->language->get("entry_underline");
        $this->data['entry_style']   = $this->language->get("entry_style");
        
        
        // set image backgrounds
        $this->setImageVar('searchButton_image','a.searchButton');
        $this->setImageVar('searchButtonHover_image','a.searchButton:hover');
        $this->setImageVar('searchButtonActive_image','a.searchButton:active');
        $this->setImageVar('buttonAddSmall_image','.button_add_small');
        $this->setImageVar('buttonAddSmallHover_image','.button_add_small:hover');
        $this->setImageVar('buttonAddSmallActive_image','.button_add_small:active');
        $this->setImageVar('buttonSeeSmall_image','.button_see_small');
        $this->setImageVar('buttonSeeSmallHover_image','.button_see_small:hover');
        $this->setImageVar('buttonSeeSmallActive_image','.button_see_small:active');
        
        // searchButton
        $this->setStyleVar('background-repeat','a.searchButton','searchButton');
        $this->setStyleVar('background-position','a.searchButton','searchButton');
        $this->setStyleVar('background','a.searchButton','searchButton');
        $this->setStyleVar('color','a.searchButton','searchButtona');
        $this->setStyleVar('font-family','a.searchButton','searchButtona');
        $this->setStyleVar('font-weight','a.searchButton','searchButtona');
        $this->setStyleVar('font-size','a.searchButton','searchButtona');
        $this->setStyleVar('text-align','a.searchButton','searchButtona');
        $this->setStyleVar('text-decoration','a.searchButton','searchButtona');
        $this->setStyleVar('text-shadow','a.searchButton','searchButtona');
        
        // searchButton:hover
        $this->setStyleVar('background-repeat','a.searchButton:hover','searchButtonHover');
        $this->setStyleVar('background-position','a.searchButton:hover','searchButtonHover');
        $this->setStyleVar('background','a.searchButton:hover','searchButtonHover');
        $this->setStyleVar('color','a.searchButton:hover','searchButtonahover');
        $this->setStyleVar('font-family','a.searchButton:hover','searchButtonahover');
        $this->setStyleVar('font-weight','a.searchButton:hover','searchButtonahover');
        $this->setStyleVar('font-size','a.searchButton:hover','searchButtonahover');
        $this->setStyleVar('text-align','a.searchButton:hover','searchButtonahover');
        $this->setStyleVar('text-decoration','a.searchButton:hover','searchButtonahover');
        $this->setStyleVar('text-shadow','a.searchButton:hover','searchButtonahover');
        
        // searchButton:active
        $this->setStyleVar('background-repeat','a.searchButton:active','searchButtonActive');
        $this->setStyleVar('background-position','a.searchButton:active','searchButtonActive');
        $this->setStyleVar('background','a.searchButton:active','searchButtonActive');
        $this->setStyleVar('color','a.searchButton:active','searchButtonaactive');
        $this->setStyleVar('font-family','a.searchButton:active','searchButtonaactive');
        $this->setStyleVar('font-weight','a.searchButton:active','searchButtonaactive');
        $this->setStyleVar('font-size','a.searchButton:active','searchButtonaactive');
        $this->setStyleVar('text-align','a.searchButton:active','searchButtonaactive');
        $this->setStyleVar('text-decoration','a.searchButton:active','searchButtonaactive');
        $this->setStyleVar('text-shadow','a.searchButton:active','searchButtonaactive');
        
        // button_add_small
        $this->setStyleVar('background-repeat','.button_add_small','buttonAddSmall');
        $this->setStyleVar('background-position','.button_add_small','buttonAddSmall');
        $this->setStyleVar('background','.button_add_small','buttonAddSmall');
        $this->setStyleVar('color','.button_add_small','buttonAddSmalla');
        $this->setStyleVar('font-family','.button_add_small','buttonAddSmalla');
        $this->setStyleVar('font-weight','.button_add_small','buttonAddSmalla');
        $this->setStyleVar('font-size','.button_add_small','buttonAddSmalla');
        $this->setStyleVar('text-align','.button_add_small','buttonAddSmalla');
        $this->setStyleVar('text-decoration','.button_add_small','buttonAddSmalla');
        $this->setStyleVar('text-shadow','.button_add_small','buttonAddSmalla');
        
        // button_add_small:hover
        $this->setStyleVar('background-repeat','.button_add_small:hover','buttonAddSmallHover');
        $this->setStyleVar('background-position','.button_add_small:hover','buttonAddSmallHover');
        $this->setStyleVar('background','.button_add_small:hover','buttonAddSmallHover');
        $this->setStyleVar('color','.button_add_small:hover','buttonAddSmallahover');
        $this->setStyleVar('font-family','.button_add_small:hover','buttonAddSmallahover');
        $this->setStyleVar('font-weight','.button_add_small:hover','buttonAddSmallahover');
        $this->setStyleVar('font-size','.button_add_small:hover','buttonAddSmallahover');
        $this->setStyleVar('text-align','.button_add_small:hover','buttonAddSmallahover');
        $this->setStyleVar('text-decoration','.button_add_small:hover','buttonAddSmallahover');
        $this->setStyleVar('text-shadow','.button_add_small:hover','buttonAddSmallahover');
        
        // button_add_small:active:active
        $this->setStyleVar('background-repeat','.button_add_small:active','buttonAddSmallActive');
        $this->setStyleVar('background-position','.button_add_small:active','buttonAddSmallActive');
        $this->setStyleVar('background','.button_add_small:active','buttonAddSmallActive');
        $this->setStyleVar('color','.button_add_small:active','buttonAddSmallaactive');
        $this->setStyleVar('font-family','.button_add_small:active','buttonAddSmallaactive');
        $this->setStyleVar('font-weight','.button_add_small:active','buttonAddSmallaactive');
        $this->setStyleVar('font-size','.button_add_small:active','buttonAddSmallaactive');
        $this->setStyleVar('text-align','.button_add_small:active','buttonAddSmallaactive');
        $this->setStyleVar('text-decoration','.button_add_small:active','buttonAddSmallaactive');
        $this->setStyleVar('text-shadow','.button_add_small:active','buttonAddSmallaactive');
        
        // button_see_small
        $this->setStyleVar('background-repeat','.button_see_small','buttonSeeSmall');
        $this->setStyleVar('background-position','.button_see_small','buttonSeeSmall');
        $this->setStyleVar('background','.button_see_small','buttonSeeSmall');
        $this->setStyleVar('color','.button_see_small','buttonSeeSmalla');
        $this->setStyleVar('font-family','.button_see_small','buttonSeeSmalla');
        $this->setStyleVar('font-weight','.button_see_small','buttonSeeSmalla');
        $this->setStyleVar('font-size','.button_see_small','buttonSeeSmalla');
        $this->setStyleVar('text-align','.button_see_small','buttonSeeSmalla');
        $this->setStyleVar('text-decoration','.button_see_small','buttonSeeSmalla');
        $this->setStyleVar('text-shadow','.button_see_small','buttonSeeSmalla');
        
        // button_see_small:hover
        $this->setStyleVar('background-repeat','.button_see_small:hover','buttonSeeSmallHover');
        $this->setStyleVar('background-position','.button_see_small:hover','buttonSeeSmallHover');
        $this->setStyleVar('background','.button_see_small:hover','buttonSeeSmallHover');
        $this->setStyleVar('color','.button_see_small:hover','buttonSeeSmallahover');
        $this->setStyleVar('font-family','.button_see_small:hover','buttonSeeSmallahover');
        $this->setStyleVar('font-weight','.button_see_small:hover','buttonSeeSmallahover');
        $this->setStyleVar('font-size','.button_see_small:hover','buttonSeeSmallahover');
        $this->setStyleVar('text-align','.button_see_small:hover','buttonSeeSmallahover');
        $this->setStyleVar('text-decoration','.button_see_small:hover','buttonSeeSmallahover');
        $this->setStyleVar('text-shadow','.button_see_small:hover','buttonSeeSmallahover');
        
        // button_see_small:active:active
        $this->setStyleVar('background-repeat','.button_see_small:active','buttonSeeSmallActive');
        $this->setStyleVar('background-position','.button_see_small:active','buttonSeeSmallActive');
        $this->setStyleVar('background','.button_see_small:active','buttonSeeSmallActive');
        $this->setStyleVar('color','.button_see_small:active','buttonSeeSmallaactive');
        $this->setStyleVar('font-family','.button_see_small:active','buttonSeeSmallaactive');
        $this->setStyleVar('font-weight','.button_see_small:active','buttonSeeSmallaactive');
        $this->setStyleVar('font-size','.button_see_small:active','buttonSeeSmallaactive');
        $this->setStyleVar('text-align','.button_see_small:active','buttonSeeSmallaactive');
        $this->setStyleVar('text-decoration','.button_see_small:active','buttonSeeSmallaactive');
        $this->setStyleVar('text-shadow','.button_see_small:active','buttonSeeSmallaactive');
        
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
        
        $this->data['action'] = HTTP_HOME . "index.php?r=style/buttons&token=".$this->request->get['token']."&menu=sistema";
        $this->data['reset'] = HTTP_HOME . "index.php?r=style/buttons/reset&token=".$this->request->get['token']."&menu=sistema";
        $this->data['cancel'] = HTTP_HOME . "index.php?r=common/home&token=".$this->request->get['token']."&menu=sistema";
        
		$this->template = 'style/buttons.tpl';
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
        $this->redirect("index.php?r=style/buttons&token=".$this->request->get['token']."&menu=sistema");
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
