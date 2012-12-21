<?php
class ControllerSettingSetting extends Controller {
	private $error = array();
 
	public function index() {
	   $this->load->library('url');
		$this->document->title = $this->language->get('heading_title');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		  
			if (isset($this->request->post['config_token_ignore'])) {
				$this->request->post['config_token_ignore'] = serialize($this->request->post['config_token_ignore']);
			}
		  
			$this->modelSetting->editSetting('config', $this->request->post);

		  
			if ($this->config->get('config_currency_auto')) {
				$this->modelCurrency->updateCurrencies();
			}	
		  
			
			$this->session->set('success',$this->language->get('text_success'));
		  
			$this->redirect(Url::createAdminUrl('setting/setting'));
		  
		}
        
        if (isset($this->request->post['config_maintenance'])) { 
            $this->modelSetting->editMaintenance($this->request->post['config_maintenance']);
        }

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_mail'] = $this->language->get('text_mail');
		$this->data['text_smtp'] = $this->language->get('text_smtp');
		$this->data['text_sendmail'] = $this->language->get('text_sendmail');
			$this->data['text_pop'] = $this->language->get('text_pop');
			$this->data['text_imap'] = $this->language->get('text_imap');
			$this->data['text_true'] = $this->language->get('text_true');
			$this->data['text_false'] = $this->language->get('text_false');
			$this->data['text_nosure'] = $this->language->get('text_nosure');
			$this->data['text_wait'] = $this->language->get('text_wait');
			$this->data['text_none'] = $this->language->get('text_none');
			$this->data['text_default'] = $this->language->get('text_default');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_rif'] = $this->language->get('entry_rif');
		$this->data['entry_url'] = $this->language->get('entry_url');	
		$this->data['entry_owner'] = $this->language->get('entry_owner');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');		
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_template'] = $this->language->get('entry_template');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_zone'] = $this->language->get('entry_zone');		
		$this->data['entry_language'] = $this->language->get('entry_language');
		$this->data['entry_admin_language'] = $this->language->get('entry_admin_language');
		$this->data['entry_currency'] = $this->language->get('entry_currency');
		$this->data['entry_currency_auto'] = $this->language->get('entry_currency_auto');
		$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$this->data['entry_length_class'] = $this->language->get('entry_length_class');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_customer_price'] = $this->language->get('entry_customer_price');
		$this->data['entry_customer_approval'] = $this->language->get('entry_customer_approval');
		$this->data['entry_guest_checkout'] = $this->language->get('entry_guest_checkout');
		$this->data['entry_account'] = $this->language->get('entry_account');
		$this->data['entry_checkout'] = $this->language->get('entry_checkout');
		$this->data['entry_stock_display'] = $this->language->get('entry_stock_display');
		$this->data['entry_stock_checkout'] = $this->language->get('entry_stock_checkout');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$this->data['entry_logo'] = $this->language->get('entry_logo');
		$this->data['entry_icon'] = $this->language->get('entry_icon');
		$this->data['entry_image_thumb'] = $this->language->get('entry_image_thumb');
		$this->data['entry_image_popup'] = $this->language->get('entry_image_popup');
		$this->data['entry_image_category'] = $this->language->get('entry_image_category');
		$this->data['entry_image_product'] = $this->language->get('entry_image_product');
		$this->data['entry_image_additional'] = $this->language->get('entry_image_additional');
		$this->data['entry_image_related'] = $this->language->get('entry_image_related');
		$this->data['entry_image_cart'] = $this->language->get('entry_image_cart');		
		$this->data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
		$this->data['entry_mail_parameter'] = $this->language->get('entry_mail_parameter');
		$this->data['entry_smtp_host'] = $this->language->get('entry_smtp_host');
		$this->data['entry_pop3_host'] = $this->language->get('entry_pop3_host');
		$this->data['entry_pop3_protocol'] = $this->language->get('entry_pop3_protocol');
		$this->data['entry_pop3_port'] = $this->language->get('entry_smtp_port');
		$this->data['entry_pop3_ssl'] = $this->language->get('entry_pop3_ssl');
		$this->data['entry_smtp_username'] = $this->language->get('entry_smtp_username');
		$this->data['entry_smtp_password'] = $this->language->get('entry_smtp_password');
		$this->data['entry_smtp_port'] = $this->language->get('entry_smtp_port');
		$this->data['entry_smtp_timeout'] = $this->language->get('entry_smtp_timeout');
		$this->data['entry_smtp_auth'] = $this->language->get('entry_smtp_auth');
		$this->data['entry_smtp_from_email'] = $this->language->get('entry_smtp_from_email');
		$this->data['entry_smtp_from_name'] = $this->language->get('entry_smtp_from_name');
		$this->data['entry_smtp_charset'] = $this->language->get('entry_smtp_charset');
		$this->data['entry_smtp_method'] = $this->language->get('entry_smtp_method');
		$this->data['entry_smtp_ssl'] = $this->language->get('entry_smtp_ssl');
		$this->data['entry_alert_mail'] = $this->language->get('entry_alert_mail');
		$this->data['entry_ssl'] = $this->language->get('entry_ssl');
		$this->data['entry_encryption'] = $this->language->get('entry_encryption');
		$this->data['entry_seo_url'] = $this->language->get('entry_seo_url');
		$this->data['entry_compression'] = $this->language->get('entry_compression');
		$this->data['entry_error_display'] = $this->language->get('entry_error_display');
		$this->data['entry_error_log'] = $this->language->get('entry_error_log');
		$this->data['entry_error_filename'] = $this->language->get('entry_error_filename');
		$this->data['entry_shipping_session'] = $this->language->get('entry_shipping_session');
		$this->data['entry_admin_limit'] = $this->language->get('entry_admin_limit');
		$this->data['entry_catalog_limit'] = $this->language->get('entry_catalog_limit');
		$this->data['entry_review'] = $this->language->get('entry_review');
		$this->data['entry_alert_emails'] = $this->language->get('entry_alert_emails');
		$this->data['entry_maintenance'] = $this->language->get('entry_maintenance');
		$this->data['entry_thousands_separator'] = $this->language->get('entry_thousands_separator');
		$this->data['entry_decimal_separator'] = $this->language->get('entry_decimal_separator');
		$this->data['entry_token_ignore'] = $this->language->get('entry_token_ignore');
		$this->data['entry_email_max_size'] = $this->language->get('entry_email_max_size');
			$this->data['entry_replyto_email'] = $this->language->get('entry_replyto_email');
			$this->data['entry_bounce_email'] = $this->language->get('entry_bounce_email');        
			$this->data['entry_bounce_server'] = $this->language->get('entry_bounce_server');	
			$this->data['entry_bounce_username'] = $this->language->get('entry_bounce_username');
			$this->data['entry_bounce_password'] = $this->language->get('entry_bounce_password');	
			$this->data['entry_extra_mail_settings'] = $this->language->get('entry_extra_mail_settings');	
			$this->data['entry_imap_account'] = $this->language->get('entry_imap_account');		
			$this->data['entry_process_bounce'] = $this->language->get('entry_process_bounce');	
			$this->data['entry_agree_delete'] = $this->language->get('entry_agree_delete');	
			$this->data['entry_extramail_novalidate'] = $this->language->get('entry_extramail_novalidate');	
			$this->data['entry_extramail_notls'] = $this->language->get('entry_extramail_notls');		
			$this->data['entry_extramail_nossl'] = $this->language->get('entry_extramail_nossl');	
			$this->data['entry_extramail_others'] = $this->language->get('entry_extramail_others');
			$this->data['entry_dir_export'] = $this->language->get('entry_dir_export');
			$this->data['entry_js_security'] = $this->language->get('entry_js_security');
			$this->data['entry_server_security'] = $this->language->get('entry_server_security');
			$this->data['entry_password_security'] = $this->language->get('entry_password_security');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_store'] = $this->language->get('tab_store');
		$this->data['tab_style'] = $this->language->get('tab_style');
		$this->data['tab_local'] = $this->language->get('tab_local');
		$this->data['tab_option'] = $this->language->get('tab_option');
		$this->data['tab_image'] = $this->language->get('tab_image');
		$this->data['tab_mail'] = $this->language->get('tab_mail');
		$this->data['tab_server'] = $this->language->get('tab_server');

		$this->data['token'] = $this->session->get('ukey');

        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_name'] = isset($this->error['name']) ? $this->error['name'] : '';
        $this->data['error_rif'] = isset($this->error['rif']) ? $this->error['rif'] : '';
        $this->data['error_url'] = isset($this->error['url']) ? $this->error['url'] : '';
        $this->data['error_owner'] = isset($this->error['owner']) ? $this->error['owner'] : '';
        $this->data['error_address'] = isset($this->error['address']) ? $this->error['address'] : '';
        $this->data['error_email'] = isset($this->error['email']) ? $this->error['email'] : '';
        $this->data['error_telephone'] = isset($this->error['telephone']) ? $this->error['telephone'] : '';
        $this->data['error_title'] = isset($this->error['title']) ? $this->error['title'] : '';
        $this->data['error_image_thumb'] = isset($this->error['image_thumb']) ? $this->error['image_thumb'] : '';
        $this->data['error_image_popup'] = isset($this->error['image_popup']) ? $this->error['image_popup'] : '';
        $this->data['error_image_category'] = isset($this->error['image_category']) ? $this->error['image_category'] : '';
        $this->data['error_image_product'] = isset($this->error['image_product']) ? $this->error['image_product'] : '';
        $this->data['error_image_additional'] = isset($this->error['image_additional']) ? $this->error['image_additional'] : '';
        $this->data['error_image_related'] = isset($this->error['image_related']) ? $this->error['image_related'] : '';
        $this->data['error_image_cart'] = isset($this->error['image_cart']) ? $this->error['image_cart'] : '';
        $this->data['error_error_filename'] = isset($this->error['error_filename']) ? $this->error['error_filename'] : '';
        $this->data['error_catalog_limit'] = isset($this->error['catalog_limit']) ? $this->error['catalog_limit'] : '';
        $this->data['error_admin_limit'] = isset($this->error['admin_limit']) ? $this->error['admin_limit'] : '';
        $this->data['error_thousands_separator'] = isset($this->error['thousands_separator']) ? $this->error['thousands_separator'] : '';
        $this->data['error_decimal_separator'] = isset($this->error['decimal_separator']) ? $this->error['decimal_separator'] : '';
        $this->data['error_smtp_host'] = isset($this->error['smtp_host']) ? $this->error['smtp_host'] : '';
        $this->data['error_pop3_host'] = isset($this->error['pop3_host']) ? $this->error['pop3_host'] : '';
        $this->data['error_pop3_port'] = isset($this->error['pop3_port']) ? $this->error['pop3_port'] : '';
        $this->data['error_smtp_port'] = isset($this->error['smtp_port']) ? $this->error['smtp_port'] : '';
        $this->data['error_smtp_from_email'] = isset($this->error['smtp_from_email']) ? $this->error['smtp_from_email'] : '';
        $this->data['error_smtp_timeout'] = isset($this->error['smtp_timeout']) ? $this->error['smtp_timeout'] : '';
        $this->data['error_bounce_email'] = isset($this->error['bounce_email']) ? $this->error['bounce_email'] : '';
        $this->data['error_replyto_email'] = isset($this->error['replyto_email']) ? $this->error['replyto_email'] : '';
		
        
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('setting/setting'),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		if ($this->session->has('success')) {
			$this->data['success'] = $this->session->get('success');
		
			$this->session->clear('success');
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['cancel'] = Url::createAdminUrl('setting/setting');

		$this->data['action'] = Url::createAdminUrl('setting/setting');
		

		if (isset($this->request->post['config_name'])) {
			$this->data['config_name'] = $this->request->post['config_name'];
		} else {
			$this->data['config_name'] = $this->config->get('config_name');
		}
		
		if (isset($this->request->post['config_rif'])) {
			$this->data['config_rif'] = strtoupper($this->request->post['config_rif']);
		} else {
			$this->data['config_rif'] = strtoupper($this->config->get('config_rif'));
		}
		
		if (isset($this->request->post['config_url'])) {
			$this->data['config_url'] = $this->request->post['config_url'];
		} else {
			$this->data['config_url'] = $this->config->get('config_url');
		}
		
		if (isset($this->request->post['config_owner'])) {
			$this->data['config_owner'] = $this->request->post['config_owner'];
		} else {
			$this->data['config_owner'] = $this->config->get('config_owner');
		}

		if (isset($this->request->post['config_address'])) {
			$this->data['config_address'] = $this->request->post['config_address'];
		} else {
			$this->data['config_address'] = $this->config->get('config_address');
		}
		
		if (isset($this->request->post['config_email'])) {
			$this->data['config_email'] = $this->request->post['config_email'];
		} else {
			$this->data['config_email'] = $this->config->get('config_email');
		}
		
		if (isset($this->request->post['config_telephone'])) {
			$this->data['config_telephone'] = $this->request->post['config_telephone'];
		} else {
			$this->data['config_telephone'] = $this->config->get('config_telephone');
		}

		if (isset($this->request->post['config_fax'])) {
			$this->data['config_fax'] = $this->request->post['config_fax'];
		} else {
			$this->data['config_fax'] = $this->config->get('config_fax');
		}

		if (isset($this->request->post['config_title'])) {
			$this->data['config_title'] = $this->request->post['config_title'];
		} else {
			$this->data['config_title'] = $this->config->get('config_title');
		}
		
		if (isset($this->request->post['config_meta_description'])) {
			$this->data['config_meta_description'] = $this->request->post['config_meta_description'];
		} else {
			$this->data['config_meta_description'] = $this->config->get('config_meta_description');
		}
		

        $directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);
		$this->data['templates'] = array();
		foreach ($directories as $directory) {
			$this->data['templates'][] = basename($directory);
		}	
        
        if (isset($this->request->post['config_template'])) {
			$this->data['config_template'] = $this->request->post['config_template'];
		} else {
			$this->data['config_template'] = $this->config->get('config_template');			
		}	
        
		if (isset($this->request->post['config_decimal_separator'])) {
			$this->data['config_decimal_separator'] = $this->request->post['config_decimal_separator'];
		} else {
			$this->data['config_decimal_separator'] = $this->config->get('config_decimal_separator');			
		}	
        
		if (isset($this->request->post['config_thousands_separator'])) {
			$this->data['config_thousands_separator'] = $this->request->post['config_thousands_separator'];
		} else {
			$this->data['config_thousands_separator'] = $this->config->get('config_thousands_separator');			
		}

		$languages = $this->data['languages'] = $this->modelLanguage->getLanguages();
		

		foreach ($languages as $language) {
			if (isset($this->request->post['config_description_' . $language['language_id']])) {
				$this->data['config_description_' . $language['language_id']] = $this->request->post['config_description_' . $language['language_id']];
			} else {
				$this->data['config_description_' . $language['language_id']] = $this->config->get('config_description_' . $language['language_id']);
			}
		}

		
		if (isset($this->request->post['config_country_id'])) {
			$this->data['config_country_id'] = $this->request->post['config_country_id'];
		} else {
			$this->data['config_country_id'] = $this->config->get('config_country_id');
		}
		
		$this->data['countries'] = $this->modelCountry->getCountries();

		if (isset($this->request->post['config_zone_id'])) {
			$this->data['config_zone_id'] = $this->request->post['config_zone_id'];
		} else {
			$this->data['config_zone_id'] = $this->config->get('config_zone_id');
		}		
		
		if (isset($this->request->post['config_language'])) {
			$this->data['config_language'] = $this->request->post['config_language'];
		} else {
			$this->data['config_language'] = $this->config->get('config_language');
		}
		

		if (isset($this->request->post['config_admin_language'])) {
			$this->data['config_admin_language'] = $this->request->post['config_admin_language'];
		} else {
			$this->data['config_admin_language'] = $this->config->get('config_admin_language');
		}
		

		if (isset($this->request->post['config_currency'])) {
			$this->data['config_currency'] = $this->request->post['config_currency'];
		} else {
			$this->data['config_currency'] = $this->config->get('config_currency');
		}


		if (isset($this->request->post['config_currency_auto'])) {
			$this->data['config_currency_auto'] = $this->request->post['config_currency_auto'];
		} else {
			$this->data['config_currency_auto'] = $this->config->get('config_currency_auto');
		}

		
		$this->data['currencies'] = $this->modelCurrency->getCurrencies();
			
		if (isset($this->request->post['config_tax'])) {
			$this->data['config_tax'] = $this->request->post['config_tax'];
		} else {
			$this->data['config_tax'] = $this->config->get('config_tax');			
		}
		

		$this->data['customer_groups'] = $this->modelCustomergroup->getCustomerGroups();
		
		if (isset($this->request->post['config_customer_group_id'])) {
			$this->data['config_customer_group_id'] = $this->request->post['config_customer_group_id'];
		} else {
			$this->data['config_customer_group_id'] = $this->config->get('config_customer_group_id');			
		}
		

		if (isset($this->request->post['config_customer_price'])) {
			$this->data['config_customer_price'] = $this->request->post['config_customer_price'];
		} else {
			$this->data['config_customer_price'] = $this->config->get('config_customer_price');			
		}
		

		if (isset($this->request->post['config_customer_approval'])) {
			$this->data['config_customer_approval'] = $this->request->post['config_customer_approval'];
		} else {
			$this->data['config_customer_approval'] = $this->config->get('config_customer_approval');			
		}

		
		if (isset($this->request->post['config_guest_checkout'])) {
			$this->data['config_guest_checkout'] = $this->request->post['config_guest_checkout'];
		} else {
			$this->data['config_guest_checkout'] = $this->config->get('config_guest_checkout');		
		}
		

		if (isset($this->request->post['config_account_id'])) {
			$this->data['config_account_id'] = $this->request->post['config_account_id'];
		} else {
			$this->data['config_account_id'] = $this->config->get('config_account_id');			
		}
		
		if (isset($this->request->post['config_checkout_id'])) {
			$this->data['config_checkout_id'] = $this->request->post['config_checkout_id'];
		} else {
			$this->data['config_checkout_id'] = $this->config->get('config_checkout_id');		
		}


		$this->data['informations'] = $this->modelPage->getPages();

		if (isset($this->request->post['config_stock_display'])) {
			$this->data['config_stock_display'] = $this->request->post['config_stock_display'];
		} else {
			$this->data['config_stock_display'] = $this->config->get('config_stock_display');			
		}


		if (isset($this->request->post['config_stock_checkout'])) {
			$this->data['config_stock_checkout'] = $this->request->post['config_stock_checkout'];
		} else {
			$this->data['config_stock_checkout'] = $this->config->get('config_stock_checkout');		
		}


		if (isset($this->request->post['config_order_status_id'])) {
			$this->data['config_order_status_id'] = $this->request->post['config_order_status_id'];
		} else {
			$this->data['config_order_status_id'] = $this->config->get('config_order_status_id');		
		}
		

		$this->data['order_statuses'] = $this->modelOrderstatus->getOrderStatuses();

		if (isset($this->request->post['config_stock_status_id'])) {
			$this->data['config_stock_status_id'] = $this->request->post['config_stock_status_id'];
		} else {
			$this->data['config_stock_status_id'] = $this->config->get('config_stock_status_id');			
		}
		

		$this->data['stock_statuses'] = $this->modelStockstatus->getStockStatuses();
		
		if (isset($this->request->post['config_shipping_session'])) {
			$this->data['config_shipping_session'] = $this->request->post['config_shipping_session'];
		} else {
			$this->data['config_shipping_session'] = $this->config->get('config_shipping_session');
		}

		
		if (isset($this->request->post['config_admin_limit'])) {
			$this->data['config_admin_limit'] = $this->request->post['config_admin_limit'];
		} else {
			$this->data['config_admin_limit'] = $this->config->get('config_admin_limit');
		}
		

		if (isset($this->request->post['config_catalog_limit'])) {
			$this->data['config_catalog_limit'] = $this->request->post['config_catalog_limit'];
		} else {
			$this->data['config_catalog_limit'] = $this->config->get('config_catalog_limit');
		}
		

		if (isset($this->request->post['config_cart_weight'])) {
			$this->data['config_cart_weight'] = $this->request->post['config_cart_weight'];
		} else {
			$this->data['config_cart_weight'] = $this->config->get('config_cart_weight');
		}

		
		if (isset($this->request->post['config_review'])) {
			$this->data['config_review'] = $this->request->post['config_review'];
		} else {
			$this->data['config_review'] = $this->config->get('config_review');
		}
		

		if (isset($this->request->post['config_logo'])) {
			$this->data['config_logo'] = $this->request->post['config_logo'];
		} else {
			$this->data['config_logo'] = $this->config->get('config_logo');			
		}


		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['preview_logo'] = HTTP_IMAGE . $this->config->get('config_logo');		
		} else {
			$this->data['preview_logo'] = NTImage::resizeAndSave('no_image.jpg', 100, 100);
		}
        
		if (isset($this->request->post['config_icon'])) {
			$this->data['config_icon'] = $this->request->post['config_icon'];
		} else {
			$this->data['config_icon'] = $this->config->get('config_icon');			
		}
		

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['preview_icon'] = HTTP_IMAGE . $this->config->get('config_icon');		
		} else {
			$this->data['preview_icon'] = NTImage::resizeAndSave('no_image.jpg', 100, 100);
		}
		

		if (isset($this->request->post['config_image_thumb_width'])) {
			$this->data['config_image_thumb_width'] = $this->request->post['config_image_thumb_width'];
		} else {
			$this->data['config_image_thumb_width'] = $this->config->get('config_image_thumb_width');
		}
		
		if (isset($this->request->post['config_image_thumb_height'])) {
			$this->data['config_image_thumb_height'] = $this->request->post['config_image_thumb_height'];
		} else {
			$this->data['config_image_thumb_height'] = $this->config->get('config_image_thumb_height');
		}
		
		if (isset($this->request->post['config_image_popup_width'])) {
			$this->data['config_image_popup_width'] = $this->request->post['config_image_popup_width'];
		} else {
			$this->data['config_image_popup_width'] = $this->config->get('config_image_popup_width');
		}
		
		if (isset($this->request->post['config_image_popup_height'])) {
			$this->data['config_image_popup_height'] = $this->request->post['config_image_popup_height'];
		} else {
			$this->data['config_image_popup_height'] = $this->config->get('config_image_popup_height');
		}

		if (isset($this->request->post['config_image_category_width'])) {
			$this->data['config_image_category_width'] = $this->request->post['config_image_category_width'];
		} else {
			$this->data['config_image_category_width'] = $this->config->get('config_image_category_width');
		}
		
		if (isset($this->request->post['config_image_category_height'])) {
			$this->data['config_image_category_height'] = $this->request->post['config_image_category_height'];
		} else {
			$this->data['config_image_category_height'] = $this->config->get('config_image_category_height');
		}
		
		if (isset($this->request->post['config_image_product_width'])) {
			$this->data['config_image_product_width'] = $this->request->post['config_image_product_width'];
		} else {
			$this->data['config_image_product_width'] = $this->config->get('config_image_product_width');
		}
		
		if (isset($this->request->post['config_image_product_height'])) {
			$this->data['config_image_product_height'] = $this->request->post['config_image_product_height'];
		} else {
			$this->data['config_image_product_height'] = $this->config->get('config_image_product_height');
		}

		if (isset($this->request->post['config_image_additional_width'])) {
			$this->data['config_image_additional_width'] = $this->request->post['config_image_additional_width'];
		} else {
			$this->data['config_image_additional_width'] = $this->config->get('config_image_additional_width');
		}
		
		if (isset($this->request->post['config_image_additional_height'])) {
			$this->data['config_image_additional_height'] = $this->request->post['config_image_additional_height'];
		} else {
			$this->data['config_image_additional_height'] = $this->config->get('config_image_additional_height');
		}
		
		if (isset($this->request->post['config_image_related_width'])) {
			$this->data['config_image_related_width'] = $this->request->post['config_image_related_width'];
		} else {
			$this->data['config_image_related_width'] = $this->config->get('config_image_related_width');
		}
		
		if (isset($this->request->post['config_image_related_height'])) {
			$this->data['config_image_related_height'] = $this->request->post['config_image_related_height'];
		} else {
			$this->data['config_image_related_height'] = $this->config->get('config_image_related_height');
		}
		
		if (isset($this->request->post['config_image_cart_width'])) {
			$this->data['config_image_cart_width'] = $this->request->post['config_image_cart_width'];
		} else {
			$this->data['config_image_cart_width'] = $this->config->get('config_image_cart_width');
		}
		
		if (isset($this->request->post['config_image_cart_height'])) {
			$this->data['config_image_cart_height'] = $this->request->post['config_image_cart_height'];
		} else {
			$this->data['config_image_cart_height'] = $this->config->get('config_image_cart_height');
		}		
		
		if (isset($this->request->post['config_mail_protocol'])) {
			$this->data['config_mail_protocol'] = $this->request->post['config_mail_protocol'];
		} else {
			$this->data['config_mail_protocol'] = $this->config->get('config_mail_protocol');
		}
		
		if (isset($this->request->post['config_smtp_host'])) {
			$this->data['config_smtp_host'] = $this->request->post['config_smtp_host'];
		} else {
			$this->data['config_smtp_host'] = $this->config->get('config_smtp_host');
		}
		
		if (isset($this->request->post['config_pop3_host'])) {
			$this->data['config_pop3_host'] = $this->request->post['config_pop3_host'];
		} else {
			$this->data['config_pop3_host'] = $this->config->get('config_pop3_host');
		}		

		if (isset($this->request->post['config_smtp_from_email'])) {
			$this->data['config_smtp_from_email'] = $this->request->post['config_smtp_from_email'];
		} else {
			$this->data['config_smtp_from_email'] = $this->config->get('config_smtp_from_email');
		}		

		if (isset($this->request->post['config_smtp_from_name'])) {
			$this->data['config_smtp_from_name'] = $this->request->post['config_smtp_from_name'];
		} else {
			$this->data['config_smtp_from_name'] = $this->config->get('config_smtp_from_name');
		}		

		if (isset($this->request->post['config_smtp_username'])) {
			$this->data['config_smtp_username'] = $this->request->post['config_smtp_username'];
		} else {
			$this->data['config_smtp_username'] = $this->config->get('config_smtp_username');
		}	
		
		if (isset($this->request->post['config_smtp_password'])) {
			$this->data['config_smtp_password'] = $this->request->post['config_smtp_password'];
		} else {
			$this->data['config_smtp_password'] = $this->config->get('config_smtp_password');
		}	
		
		if (isset($this->request->post['config_smtp_method'])) {
			$this->data['config_smtp_method'] = $this->request->post['config_smtp_method'];
		} elseif ($this->config->get('config_smtp_method')) {
			$this->data['config_smtp_method'] = $this->config->get('config_smtp_method');
		} else {
			$this->data['config_smtp_method'] = 'mail';
		}
		
		if (isset($this->request->post['config_smtp_port'])) {
			$this->data['config_smtp_port'] = $this->request->post['config_smtp_port'];
		} elseif ($this->config->get('config_smtp_port')) {
			$this->data['config_smtp_port'] = $this->config->get('config_smtp_port');
		} else {
			$this->data['config_smtp_port'] = 25;
		}	
		
		if (isset($this->request->post['config_pop3_protocol'])) {
			$this->data['config_pop3_protocol'] = $this->request->post['config_pop3_protocol'];
		} elseif ($this->config->get('config_pop3_protocol')) {
			$this->data['config_pop3_protocol'] = $this->config->get('config_pop3_protocol');
		} else {
			$this->data['config_pop3_protocol'] = 'pop3';
		}	
		
		if (isset($this->request->post['config_pop3_port'])) {
			$this->data['config_pop3_port'] = $this->request->post['config_pop3_port'];
		} elseif ($this->config->get('config_pop3_port')) {
			$this->data['config_pop3_port'] = $this->config->get('config_pop3_port');
		} else {
			$this->data['config_pop3_port'] = 110;
		}	
		
		if (isset($this->request->post['config_smtp_timeout'])) {
			$this->data['config_smtp_timeout'] = $this->request->post['config_smtp_timeout'];
		} elseif ($this->config->get('config_smtp_timeout')) {
			$this->data['config_smtp_timeout'] = $this->config->get('config_smtp_timeout');
		} else {
			$this->data['config_smtp_timeout'] = 5;	
		}	
		
		if (isset($this->request->post['config_smtp_maxsize'])) {
			$this->data['config_smtp_maxsize'] = $this->request->post['config_smtp_maxsize'];
		} elseif ($this->config->get('config_smtp_maxsize')) {
			$this->data['config_smtp_maxsize'] = $this->config->get('config_smtp_maxsize');
		} else {
			$this->data['config_smtp_maxsize'] = 0;	
		}
		
		if (isset($this->request->post['config_smtp_charset'])) {
			$this->data['config_smtp_charset'] = $this->request->post['config_smtp_charset'];
		} elseif ($this->config->get('config_smtp_charset')) {
			$this->data['config_smtp_charset'] = $this->config->get('config_smtp_charset');
		} else {
			$this->data['config_smtp_charset'] = 'iso-8859-1';	
		}	
		
		if (isset($this->request->post['config_alert_mail'])) {
			$this->data['config_alert_mail'] = $this->request->post['config_alert_mail'];
		} else {
			$this->data['config_alert_mail'] = $this->config->get('config_alert_mail');
		}
		
		if (isset($this->request->post['config_smtp_auth'])) {
			$this->data['config_smtp_auth'] = $this->request->post['config_smtp_auth'];
		} else {
			$this->data['config_smtp_auth'] = $this->config->get('config_smtp_auth');
		}
		
		if (isset($this->request->post['config_alert_emails'])) {
			$this->data['config_alert_emails'] = $this->request->post['config_alert_emails'];
		} else {
			$this->data['config_alert_emails'] = $this->config->get('config_alert_emails');
		}
		
		if (isset($this->request->post['config_mail_parameter'])) {
			$this->data['config_mail_parameter'] = $this->request->post['config_mail_parameter'];
		} else {
			$this->data['config_mail_parameter'] = $this->config->get('config_mail_parameter');
		}
		
		if (isset($this->request->post['config_ssl'])) {
			$this->data['config_ssl'] = $this->request->post['config_ssl'];
		} else {
			$this->data['config_ssl'] = $this->config->get('config_ssl');
		}
		
		if (isset($this->request->post['config_pop3_ssl'])) {
			$this->data['config_pop3_ssl'] = $this->request->post['config_pop3_ssl'];
		} else {
			$this->data['config_pop3_ssl'] = $this->config->get('config_pop3_ssl');
		}
		
		if (isset($this->request->post['config_smtp_ssl'])) {
			$this->data['config_smtp_ssl'] = $this->request->post['config_smtp_ssl'];
		} else {
			$this->data['config_smtp_ssl'] = $this->config->get('config_smtp_ssl');
		}
            
            if (isset($this->request->post['config_bounce_email'])) {
				$this->data['config_bounce_email'] = $this->request->post['config_bounce_email'];
			} elseif ($this->config->get('config_bounce_email')) {
				$this->data['config_bounce_email'] = $this->config->get('config_bounce_email');
			} else {
				$this->data['config_bounce_email'] = $this->config->get('config_pop3_email');
			}
            
            if (isset($this->request->post['config_replyto_email'])) {
				$this->data['config_replyto_email'] = $this->request->post['config_replyto_email'];
			} elseif ($this->config->get('config_replyto_email')) {
				$this->data['config_replyto_email'] = $this->config->get('config_replyto_email');
			} else {
				$this->data['config_replyto_email'] = '';
			}
            
            
			
            if (isset($this->request->post['config_bounce_server'])) {
				$this->data['config_bounce_server'] = $this->request->post['config_bounce_server'];
			} elseif ($this->config->get('config_bounce_server')) {
				$this->data['config_bounce_server'] = $this->config->get('config_bounce_server');
			} else {
				$this->data['config_bounce_server'] = '';
			}
            
            if (isset($this->request->post['config_bounce_username'])) {
				$this->data['config_bounce_username'] = $this->request->post['config_bounce_username'];
			} elseif ($this->config->get('config_bounce_username')) {
				$this->data['config_bounce_username'] = $this->config->get('config_bounce_username');
			} else {
				$this->data['config_bounce_username'] = '';
			}
            
            if (isset($this->request->post['config_bounce_password'])) {
				$this->data['config_bounce_password'] = $this->request->post['config_bounce_password'];
			} elseif ($this->config->get('config_bounce_password')) {
				$this->data['config_bounce_password'] = $this->config->get('config_bounce_password');
			} else {
				$this->data['config_bounce_password'] = '';
			}
            
            if (isset($this->request->post['config_bounce_extra_settings'])) {
				$this->data['config_bounce_extra_settings'] = $this->request->post['config_bounce_extra_settings'];
			} elseif ($this->config->get('config_bounce_extra_settings')) {
				$this->data['config_bounce_extra_settings'] = $this->config->get('config_bounce_extra_settings');
			} else {
				$this->data['config_bounce_extra_settings'] = '';
			}
            
            if (isset($this->request->post['config_bounce_protocol'])) {
				$this->data['config_bounce_protocol'] = $this->request->post['config_bounce_protocol'];
			} elseif ($this->config->get('config_bounce_protocol')) {
				$this->data['config_bounce_protocol'] = $this->config->get('config_bounce_protocol');
			} else {
				$this->data['config_bounce_protocol'] = 'pop3';
			}
            
            if (isset($this->request->post['config_bounce_process'])) {
				$this->data['config_bounce_process'] = $this->request->post['config_bounce_process'];
			} elseif ($this->config->get('config_bounce_process')) {
				$this->data['config_bounce_process'] = $this->config->get('config_bounce_process');
			} else {
				$this->data['config_bounce_process'] = 0;
			}
            
            if (isset($this->request->post['config_bounce_agree_delete'])) {
				$this->data['config_bounce_agree_delete'] = $this->request->post['config_bounce_agree_delete'];
			} elseif ($this->config->get('config_bounce_agree_delete')) {
				$this->data['config_bounce_agree_delete'] = $this->config->get('config_bounce_agree_delete');
			} else {
				$this->data['config_bounce_agree_delete'] = 0;
			}

		if (isset($this->request->post['config_maintenance'])) {
			$this->data['config_maintenance'] = $this->request->post['config_maintenance'];
		} else {
			$this->data['config_maintenance'] = $this->config->get('config_maintenance');
		}
		
		if (isset($this->request->post['config_encryption'])) {
			$this->data['config_encryption'] = $this->request->post['config_encryption'];
		} else {
			$this->data['config_encryption'] = $this->config->get('config_encryption');
		}
        
        if (isset($this->request->post['config_js_security'])) {
			$this->data['config_js_security'] = $this->request->post['config_js_security'];
		} else {
			$this->data['config_js_security'] = $this->config->get('config_js_security');
		}
		
        if (isset($this->request->post['config_server_security'])) {
			$this->data['config_server_security'] = $this->request->post['config_server_security'];
		} else {
			$this->data['config_server_security'] = $this->config->get('config_server_security');
		}
		
        if (isset($this->request->post['config_password_security'])) {
			$this->data['config_password_security'] = $this->request->post['config_password_security'];
		} else {
			$this->data['config_password_security'] = $this->config->get('config_password_security');
		}
		
		if (isset($this->request->post['config_seo_url'])) {
			$this->data['config_seo_url'] = $this->request->post['config_seo_url'];
		} else {
			$this->data['config_seo_url'] = $this->config->get('config_seo_url');
		}
		
		if (isset($this->request->post['config_compression'])) {
			$this->data['config_compression'] = $this->request->post['config_compression']; 
		} else {
			$this->data['config_compression'] = $this->config->get('config_compression');
		}

		if (isset($this->request->post['config_error_display'])) {
			$this->data['config_error_display'] = $this->request->post['config_error_display']; 
		} else {
			$this->data['config_error_display'] = $this->config->get('config_error_display');
		}

		if (isset($this->request->post['config_error_log'])) {
			$this->data['config_error_log'] = $this->request->post['config_error_log']; 
		} else {
			$this->data['config_error_log'] = $this->config->get('config_error_log');
		}

		if (isset($this->request->post['config_error_filename'])) {
			$this->data['config_error_filename'] = $this->request->post['config_error_filename']; 
		} else {
			$this->data['config_error_filename'] = $this->config->get('config_error_filename');
		}
        
		if (isset($this->request->post['config_dir_export'])) {
			$this->data['config_dir_export'] = $this->request->post['config_dir_export'];
		} else {
			$this->data['config_dir_export'] = $this->config->get('config_dir_export');
		}
		
		$ignore = array(
			'common/login',
			'common/logout',
			'error/not_found',
			'error/permission'
		);
		

		$this->data['tokens'] = array();
		
		$files = glob(DIR_APPLICATION . 'controller/*/*.php');
		
		foreach ($files as $file) {
			$data = explode('/', dirname($file));
			
			$token = end($data) . '/' . basename($file, '.php');
			
			if (!in_array($token, $ignore)) {
				$this->data['tokens'][] = $token;
			}
		}
		

		if (isset($this->request->post['config_token_ignore'])) {
			$this->data['config_token_ignore'] = $this->request->post['config_token_ignore']; 
		} elseif ($this->config->get('config_token_ignore')) {
			$this->data['config_token_ignore'] = unserialize($this->config->get('config_token_ignore'));
		} else {
			$this->data['config_token_ignore'] = array();
		}
				
        $this->data['Url'] = new Url;
        $scripts[] = array('id'=>'form','method'=>'ready','script'=>
            "$('#form').ntForm({
                submitButton:false,
                cancelButton:false,
                lockButton:false
            });
            $('textarea').ntTextArea();
            
            $('.product_tab').hide();
            $('#general').show();
            $('.product_tabs .htab').on('click',function(e){
                $('.product_tab').hide();
                $($(this).attr('data-target')).show();
            });
            
            var form_clean = $('#form').serialize(); 
            window.onbeforeunload = function (e) {
                var form_dirty = $('#form').serialize();
                if(form_clean != form_dirty) {
                    return 'There is unsaved form data.';
                }
            };");
            
        foreach ($this->data['languages'] as $language) {
            $scripts[] = array('id'=>'Language'. $language["language_id"],'method'=>'ready','script'=>
                "CKEDITOR.replace('description". $language["language_id"] ."', {
                	filebrowserBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserImageBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserFlashBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserUploadUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserImageUploadUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserFlashUploadUrl: '". Url::createAdminUrl("common/filemanager") ."'
                });");
        }
        
        $scripts[] = array('id'=>'Functions','method'=>'function','script'=>
            "function saveAndExit() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndExit'>\").submit(); 
            }
            
            function image_delete(field, preview) {
                $('#' + field).val('');
                $('#' + preview).attr('src','". HTTP_IMAGE ."cache/no_image-100x100.jpg');
            }
            
            function image_upload(field, preview) {
                var height = $(window).height() * 0.8;
                var width = $(window).width() * 0.8;
                
            	$('#dialog').remove();
            	$('.box').prepend('<div id=\"dialog\" style=\"padding: 3px 0px 0px 0px;\"><iframe src=\"". Url::createAdminUrl("common/filemanager") ."&field=' + encodeURIComponent(field) + '\" style=\"padding:0; margin: 0; display: block; width: 100%; height: 100%;\" frameborder=\"no\" scrolling=\"auto\"></iframe></div>');
                
                $('#dialog').dialog({
            		title: '".$this->data['text_image_manager']."',
            		close: function (event, ui) {
            			if ($('#' + field).attr('value')) {
            				$.ajax({
            					url: '". Url::createAdminUrl("common/filemanager/image") ."',
            					type: 'POST',
            					data: 'image=' + encodeURIComponent($('#' + field).val()),
            					dataType: 'text',
            					success: function(data) {
            						$('#' + preview).replaceWith('<img src=\"' + data + '\" id=\"' + preview + '\" class=\"image\" onclick=\"image_upload(\'' + field + '\', \'' + preview + '\');\">');
            					}
            				});
            			}
            		},	
            		bgiframe: false,
            		width: width,
            		height: height,
            		resizable: false,
            		modal: false
            	});}");
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
        // javascript files
        $jspath = defined("CDN_JS") ? CDN_JS : HTTP_JS;
        
        $javascripts[] = "js/vendor/ckeditor/ckeditor.js";
        
        $this->javascripts = array_merge($javascripts,$this->javascripts);
        
		$this->template = 'setting/setting.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
    
    public function maintenance() {
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->auto('setting/setting');
            if ($this->request->post['config_maintenance'] == 'si') {
            $this->modelSetting->editMaintenance(1);
            } else {
            $this->modelSetting->editMaintenance(0);                
            }
        }
    }

	private function validate() {
		  
		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		  
		if (!$this->request->post['config_name']) {
			$this->error['name'] = $this->language->get('error_name');
		}

		  
		if (!$this->validate_form->esRif($this->request->post['config_rif'])) {
			$this->error['rif'] = $this->language->get('error_rif');
		}	
		
		  
		if (!$this->request->post['config_url']) {
			$this->error['url'] = $this->language->get('error_url');
		}	
		
		  
		if (!$this->request->post['config_owner']) {
			$this->error['owner'] = $this->language->get('error_owner');
		}

		  
		if (!$this->request->post['config_address']) {
			$this->error['address'] = $this->language->get('error_address');
		}

		  
		if (!$this->request->post['config_title']) {
			$this->error['title'] = $this->language->get('error_title');
		}	
		
		  
		$pattern = '/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i';

		  
    	if ((strlen(utf8_decode($this->request->post['config_email']))> 96) || (!preg_match($pattern, $this->request->post['config_email']))) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

		  
		if (!$this->request->post['config_image_thumb_width'] || !$this->request->post['config_image_thumb_height']) {
			$this->error['image_thumb'] = $this->language->get('error_image_thumb');
		}	
		
		if (!$this->request->post['config_image_popup_width'] || !$this->request->post['config_image_popup_height']) {
			$this->error['image_popup'] = $this->language->get('error_image_popup');
		}	
		
		if (!$this->request->post['config_image_category_width'] || !$this->request->post['config_image_category_height']) {
			$this->error['image_category'] = $this->language->get('error_image_category');
		}
		
		if (!$this->request->post['config_image_product_width'] || !$this->request->post['config_image_product_height']) {
			$this->error['image_product'] = $this->language->get('error_image_product');
		}
		
		if (!$this->request->post['config_image_additional_width'] || !$this->request->post['config_image_additional_height']) {
			$this->error['image_additional'] = $this->language->get('error_image_additional');
		}
		
		if (!$this->request->post['config_image_related_width'] || !$this->request->post['config_image_related_height']) {
			$this->error['image_related'] = $this->language->get('error_image_related');
		}
		
		if (!$this->request->post['config_image_cart_width'] || !$this->request->post['config_image_cart_height']) {
			$this->error['image_cart'] = $this->language->get('error_image_cart');
		}
		
		if (!$this->request->post['config_error_filename']) {
			$this->error['error_filename'] = $this->language->get('error_error_filename');
		}
		
		if (!$this->request->post['config_admin_limit']) {
			$this->error['admin_limit'] = $this->language->get('error_limit');
		}
		
		if (!$this->request->post['config_catalog_limit']) {
			$this->error['catalog_limit'] = $this->language->get('error_limit');
		}
		
		if (isset($this->request->post['config_smtp_port']) && !$this->validate_form->esSoloNumeros($this->request->post['config_smtp_port'],$this->language->get('entry_smtp_port'))) {
			$this->error['smtp_port'] = $this->language->get('error_smtp_port');
		}
		
		if (isset($this->request->post['config_pop3_port']) && !$this->validate_form->esSoloNumeros($this->request->post['config_pop3_port'],$this->language->get('entry_pop3_port'))) {
			$this->error['pop3_port'] = $this->language->get('error_pop3_port');
		}
		
		if (isset($this->request->post['config_smtp_timeout']) && !$this->validate_form->esSoloNumeros($this->request->post['config_smtp_timeout'],$this->language->get('entry_smtp_timeout'))) {
			$this->error['smtp_timeout'] = $this->language->get('error_smtp_timeout');
		}
		
		if (isset($this->request->post['config_smtp_from_email']) && !$this->validate_form->validEmail($this->request->post['config_smtp_from_email'],$this->language->get('entry_smtp_from_email'))) {
			$this->error['smtp_from_email'] = $this->language->get('error_smtp_from_email');
		}
        
		if (isset($this->request->post['config_replyto_email']) && !$this->validate_form->validEmail($this->request->post['config_replyto_email'],$this->language->get('entry_replyto_email'))) {
		      $this->error['replyto_email'] = $this->language->get('error_replyto_email');
		}
        
		if (isset($this->request->post['config_bounce_email']) && !$this->validate_form->validEmail($this->request->post['config_bounce_email'],$this->language->get('entry_bounce_email'))) {
		      $this->error['bounce_email'] = $this->language->get('error_bounce_email');
		}
        
        $this->data['mostrarError'] = $this->validate_form->mostrarError();
        
		if (!$this->error) {
			return true;
		} else {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_required_data');
			}
			return false;
		}
	}
    
	public function zone() {
		$output = '';
		
		$this->load->auto('localisation/zone');
		
		$results = $this->modelZone->getZonesByCountryId($this->request->get['country_id']);
		
		foreach ($results as $result) {
			$output .= '<option value="' . $result['zone_id'] . '"';

			if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
				$output .= ' selected="selected"';
			}

			$output .= '>' . $result['name'] . '</option>';
		}

		if (!$results) {
			$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
		}

		$this->response->setOutput($output, $this->config->get('config_compression'));
	}

    public function template() {
		$template = basename($this->request->get['template']);
	 
		if (file_exists(DIR_IMAGE . 'templates/' . $template . '.png')) {
			$image = HTTP_IMAGE . 'templates/' . $template . '.png';
		} else {
			$image = HTTP_IMAGE . 'no_image.jpg';
		}
		
		$this->response->setOutput('<img src="' . $image . '" alt="" title="" style="border: 1px solid #EEEEEE;" />');
	}
    
}
