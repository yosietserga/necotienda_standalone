<?php 
class ControllerCommonHeader extends Controller {
	/**
	 * ControllerCommonHeader::index()
	 * 
	 * @return
	 */
	protected function index() {
		$this->load->language('common/header');
		$this->data['title']          = $this->document->title . " | " . $this->config->get("config_title");
		$this->data['base']           = HTTP_HOME;
		$this->data['charset']        = $this->language->get('charset');
		$this->data['lang']           = $this->language->get('code');	
		$this->data['direction']      = $this->language->get('direction');
		$this->data['links']          = $this->document->links;	
		$this->data['styles']         = $this->document->styles;
		$this->data['scripts']        = $this->document->scripts;
		$this->data['breadcrumbs']    = $this->document->breadcrumbs;
		
		$this->data['heading_title']  = $this->language->get('heading_title');
		
		$this->data['text_backup']        = $this->language->get('text_backup');
		$this->data['text_catalog']       = $this->language->get('text_catalog');
		$this->data['text_category']      = $this->language->get('text_category');
		$this->data['text_country']       = $this->language->get('text_country');
		$this->data['text_coupon']        = $this->language->get('text_coupon');
		$this->data['text_currency']      = $this->language->get('text_currency');			
		$this->data['text_customer']      = $this->language->get('text_customer');
		$this->data['text_customer_group'] = $this->language->get('text_customer_group');
		$this->data['text_sale']          = $this->language->get('text_sale');
		$this->data['text_download']      = $this->language->get('text_download');
		$this->data['text_error_log']     = $this->language->get('text_error_log');
		$this->data['text_extension']     = $this->language->get('text_extension');
		$this->data['text_feed']          = $this->language->get('text_feed');
		$this->data['text_front']         = $this->language->get('text_front');
		$this->data['text_geo_zone']      = $this->language->get('text_geo_zone');
		$this->data['text_dashboard']     = $this->language->get('text_dashboard');
		$this->data['text_help']          = $this->language->get('text_help');
		$this->data['text_information']   = $this->language->get('text_information');
		$this->data['text_language']      = $this->language->get('text_language');
      	$this->data['text_localisation']  = $this->language->get('text_localisation');
		$this->data['text_logout']        = $this->language->get('text_logout');
		$this->data['text_contact']       = $this->language->get('text_contact');
		$this->data['text_manufacturer']  = $this->language->get('text_manufacturer');
		$this->data['text_module']        = $this->language->get('text_module');
		$this->data['text_order']         = $this->language->get('text_order');
		$this->data['text_order_status']  = $this->language->get('text_order_status');
		$this->data['text_payment']       = $this->language->get('text_payment');
		$this->data['text_product']       = $this->language->get('text_product'); 
		$this->data['text_reports']       = $this->language->get('text_reports');
		$this->data['text_report_purchased'] = $this->language->get('text_report_purchased');     		
		$this->data['text_report_sale']   = $this->language->get('text_report_sale');
      	$this->data['text_report_viewed'] = $this->language->get('text_report_viewed');
		$this->data['text_review']        = $this->language->get('text_review');
		$this->data['text_support']       = $this->language->get('text_support'); 
		$this->data['text_shipping']      = $this->language->get('text_shipping');		
     	$this->data['text_setting']       = $this->language->get('text_setting');
		$this->data['text_stock_status']  = $this->language->get('text_stock_status');
		$this->data['text_system']        = $this->language->get('text_system');
		$this->data['text_tax_class']     = $this->language->get('text_tax_class');
		$this->data['text_total']         = $this->language->get('text_total');
		$this->data['text_user']          = $this->language->get('text_user');
		$this->data['text_user_group']    = $this->language->get('text_user_group');
		$this->data['text_users']         = $this->language->get('text_users');
      	$this->data['text_documentation'] = $this->language->get('text_documentation');
      	$this->data['text_weight_class']  = $this->language->get('text_weight_class');
		$this->data['text_length_class']  = $this->language->get('text_length_class');
		$this->data['text_opencart']      = $this->language->get('text_opencart');
      	$this->data['text_zone']          = $this->language->get('text_zone');
		$this->data['text_confirm']       = $this->language->get('text_confirm');
        
		$this->data['text_home']          = $this->language->get('text_home');
		$this->data['text_page']          = $this->language->get('text_page');
		$this->data['text_post']          = $this->language->get('text_post');
		$this->data['text_post_category'] = $this->language->get('text_post_category');
		$this->data['text_menu'] = $this->language->get('text_menu');
		$this->data['text_banner'] = $this->language->get('text_banner');
		$this->data['text_showslider'] = $this->language->get('text_showslider');
        
		$this->data['tab_home']       = $this->language->get('tab_home');
		$this->data['tab_admon']      = $this->language->get('tab_admon');
		$this->data['tab_content']    = $this->language->get('tab_content');
		$this->data['tab_tools']      = $this->language->get('tab_tools');
		$this->data['tab_report']      = $this->language->get('tab_report');
		$this->data['tab_marketing']  = $this->language->get('tab_marketing');
		$this->data['tab_style']      = $this->language->get('tab_style');
		$this->data['tab_system']     = $this->language->get('tab_system');
		$this->data['tab_help']       = $this->language->get('tab_help');

		$this->load->auto("url");
        
		if (!$this->user->validSession()) {
			$this->data['logged'] = '';
			$this->data['home'] = Url::createAdminUrl('common/login');
		} else {
			$this->data['logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
            
			$this->data['create_product']            = Url::createAdminUrl('store/product/insert'); 
			$this->data['create_page']               = Url::createAdminUrl('content/page/insert'); 
			$this->data['create_post']               = Url::createAdminUrl('content/post/insert'); 
			$this->data['create_manufacturer']       = Url::createAdminUrl('store/manufacturer/insert'); 
			$this->data['create_product_category']   = Url::createAdminUrl('store/category/insert'); 
			$this->data['create_post_category']      = Url::createAdminUrl('content/post_category/insert'); 
			$this->data['create_product']            = Url::createAdminUrl('store/product/insert'); 
			$this->data['create_product']            = Url::createAdminUrl('store/product/insert'); 
            
            /*
            $this->load->auto("setting/store");
            $this['stores'] = $this->modelStore->getStores();
            */
            
            $this->load->auto("sale/customer");
            $this->data['new_customers'] = $this->modelCustomer->getTotalCustomersAwaitingApproval();
                        
            $this->load->auto("sale/order");
            $this->data['new_orders'] = $this->modelOrder->getTotalOrdersByOrderStatusId($this->config->get("config_stock_status_id"));
                        
            $this->load->library('update');
            $update = new Update($this->registry);
            $update_info = $update->getInfo();
            if (version_compare(VERSION,$update_info['version'],'<')) {
                $this->data['msg'] = "Hay una nueva versi&oacute;n disponible, Para instalarla haz click <a href=\"". Url::createAdminUrl("tool/update") ."\" title=\"Actualizar\">aqu&iacute;</a>";
            }
        
			$this->data['store']         = HTTP_CATALOG;
			$this->data['home']          = Url::createAdminUrl('common/home'); 
			$this->data['logout']        = Url::createAdminUrl('common/logout');
			$this->data['category']      = Url::createAdminUrl('store/category',array('menu'=>'inicio'));
			$this->data['download']      = Url::createAdminUrl('store/download',array('menu'=>'inicio'));
			$this->data['error_log']     = Url::createAdminUrl('tool/error_log',array('menu'=>'inicio'));
            $this->data['facebook']      = Url::createAdminUrl('module/fblike',array('menu'=>'inicio'));
			$this->data['review']        = Url::createAdminUrl('store/review',array('menu'=>'inicio'));
            $this->data['webmail']       = Url::createAdminUrl('module/webmail',array('menu'=>'inicio'));
            $this->data['cumpleanos']    = Url::createAdminUrl('sale/cumpleanos',array('menu'=>'inicio'));
			$this->data['product']       = Url::createAdminUrl('store/product',array('menu'=>'inicio'));
            $this->data['twitter']       = Url::createAdminUrl('module/twitter',array('menu'=>'inicio'));	
			$this->data['information']   = Url::createAdminUrl('store/information',array('menu'=>'inicio'));
			$this->data['manufacturer']  = Url::createAdminUrl('store/manufacturer',array('menu'=>'inicio'));
            
			$this->data['pages']         = Url::createAdminUrl('content/page',array('menu'=>'contenido')); 
			$this->data['post_category'] = Url::createAdminUrl('content/post_category',array('menu'=>'contenido'));
			$this->data['post']          = Url::createAdminUrl('content/post',array('menu'=>'contenido'));
			$this->data['menu']          = Url::createAdminUrl('content/menu',array('menu'=>'contenido'));
			$this->data['banner']          = Url::createAdminUrl('content/slider',array('menu'=>'contenido'));
			$this->data['showslider']          = Url::createAdminUrl('content/showslider',array('menu'=>'contenido'));
            
			$this->data['coupon']        = Url::createAdminUrl('sale/coupon',array('menu'=>'admon'));
			$this->data['customer']      = Url::createAdminUrl('sale/customer',array('menu'=>'admon'));
			$this->data['customer_group']= Url::createAdminUrl('sale/customergroup',array('menu'=>'admon'));
			$this->data['order']         = Url::createAdminUrl('sale/order',array('menu'=>'admon'));
			$this->data['report_sale']   = Url::createAdminUrl('report/sale',array('menu'=>'admon'));
            
			$this->data['backup']        = Url::createAdminUrl('tool/backup',array('menu'=>'herramientas'));
			$this->data['restore']       = Url::createAdminUrl('tool/restore',array('menu'=>'herramientas'));
			$this->data['feed']          = Url::createAdminUrl('extension/feed',array('menu'=>'herramientas'));
			$this->data['total']         = Url::createAdminUrl('extension/total',array('menu'=>'herramientas'));
			$this->data['module']        = Url::createAdminUrl('extension/module',array('menu'=>'herramientas'));
			$this->data['payment']       = Url::createAdminUrl('extension/payment',array('menu'=>'herramientas'));
			$this->data['shipping']      = Url::createAdminUrl('extension/shipping',array('menu'=>'herramientas'));
            
            $this->data['webstats']      = Url::createAdminUrl('module/webstats',array('menu'=>'reportes'));
			$this->data['report_purchased'] = Url::createAdminUrl('report/purchased',array('menu'=>'reportes'));
			$this->data['report_viewed'] = Url::createAdminUrl('report/viewed',array('menu'=>'reportes'));
			$this->data['report_visited']= Url::createAdminUrl('report/visited',array('menu'=>'reportes'));
			$this->data['cupurchased']   = Url::createAdminUrl('report/cupurchased',array('menu'=>'reportes'));
			$this->data['cviewed']       = Url::createAdminUrl('report/cviewed',array('menu'=>'reportes'));
			$this->data['cpurchased']    = Url::createAdminUrl('report/cpurchased',array('menu'=>'reportes'));
			$this->data['mviewed']       = Url::createAdminUrl('report/mviewed',array('menu'=>'reportes'));
			$this->data['mpurchased']    = Url::createAdminUrl('report/mpurchased',array('menu'=>'reportes'));
            
            $this->data['email_lists']   = Url::createAdminUrl('marketing/list',array('menu'=>'mercadeo'));	
            $this->data['email_member']  = Url::createAdminUrl('marketing/contact',array('menu'=>'mercadeo'));
            $this->data['email_newsletter']= Url::createAdminUrl('marketing/newsletter',array('menu'=>'mercadeo'));
            $this->data['email_campaign']= Url::createAdminUrl('marketing/campaign',array('menu'=>'mercadeo'));
            
			$this->data['stock_status']  = Url::createAdminUrl('localisation/stock_status',array('menu'=>'sistema'));			
			$this->data['order_status']  = Url::createAdminUrl('localisation/order_status',array('menu'=>'sistema'));
			$this->data['user']          = Url::createAdminUrl('user/user',array('menu'=>'sistema'));
			$this->data['user_group']    = Url::createAdminUrl('user/user_permission',array('menu'=>'sistema'));
			$this->data['setting']       = Url::createAdminUrl('setting/setting',array('menu'=>'sistema'));
			
			$this->data['style_layouts']   =     Url::createAdminUrl('style/layouts',array('menu'=>'apariencia'));
			$this->data['style_backgrounds'] = Url::createAdminUrl('style/backgrounds',array('menu'=>'apariencia'));
			$this->data['style_fonts']   = Url::createAdminUrl('style/fonts',array('menu'=>'apariencia'));
			$this->data['style_links']   = Url::createAdminUrl('style/links',array('menu'=>'apariencia'));
			$this->data['style_borders'] = Url::createAdminUrl('style/borders',array('menu'=>'apariencia'));
			$this->data['style_buttons'] = Url::createAdminUrl('style/buttons',array('menu'=>'apariencia'));
			$this->data['editor'] = Url::createAdminUrl('style/editor',array('menu'=>'apariencia'));
            
			$this->data['contact']       = Url::createAdminUrl('sale/contact',array('menu'=>'ayuda'));
            
            
			$this->data['Url'] = new Url;
            	
			//foreach($_SERVER as $nombre_campo => $valor){$asignacion = "$" . $nombre_campo . "= . $valor . ";echo "<br>" . $asignacion;}
            if ($this->config->get('config_maintenance') == 1) {
                $this->data['mantenimiento'] = true;
            } else {
                $this->data['mantenimiento'] = false;
            }
            
            $this->load->auto('sale/customer');
            $this->load->auto('sale/order');
            $this->load->auto('store/review');
            
            $this->data['new_customers'] = $this->modelCustomer->getTotalCustomersAwaitingApproval();
            $this->data['new_reviews'] = $this->modelReview->getTotalReviewsAwaitingApproval();
            $this->data['new_orders'] = $this->modelOrder->getTotalOrdersWithoutInvoice();
		}
        
        /*
        // style files
        $csspath = defined("CDN_CSS") ? CDN_CSS : HTTP_CSS;
        
        $styles[] = array('media'=>'all','href'=>$csspath.'main.css');
        
        $this->data['styles'] = $this->styles = array_merge($this->styles,$styles);

        // importamos el archivo css generado desde la administración 
        // para personalizar la apariencia de la tienda, este archivo sobreescribe los parámetros iniciales de estilo
        if (is_file($csspath."custom.css")) {
            $styles = array(
                array('media'=>'all','href'=>$csspath.'custom.css')
            );
            $this->data['styles'] = $this->styles = array_merge($this->styles,$styles);
        }
        */
        
		$this->id       = 'header';
		$this->template = 'common/header.tpl';
		
        $this->data['request'] = $this->request;
        $this->data['session'] = $this->session;
        
		$this->render();
	}
}