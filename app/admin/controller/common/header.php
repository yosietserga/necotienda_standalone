<?php 
class ControllerCommonHeader extends Controller {
	/**
	 * ControllerCommonHeader::index()
	 * 
	 * @return
	 */
	protected function index() {
	   /*
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."slider`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."slider_description`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."slider_to_store`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."customer_group`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."store`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."address_book`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."product_stats`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."category_stats`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."post_stats`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."manufacturer_stats`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."post_category_stats`");
       $this->db->query("DROP TABLE IF EXISTS `". DB_PREFIX ."twitter_timeline`");
       
       //ADD FIELDS
       $this->db->query("ALTER TABLE `". DB_PREFIX ."url_alias` ADD  `object_id` INT( 11 ) NOT NULL AFTER  `url_alias_id` ,
       ADD  `language_id` INT( 11 ) NOT NULL AFTER  `object_id` ,
       ADD  `object_type` VARCHAR( 50 ) NOT NULL AFTER  `language_id`");
       $this->db->query("ALTER TABLE `". DB_PREFIX ."setting` ADD  `store_id` INT( 11 ) NOT NULL AFTER  `setting_id`");
       $this->db->query("ALTER TABLE `". DB_PREFIX ."search` ADD  `store_id` INT( 11 ) NOT NULL AFTER  `search_id`");
       $this->db->query("ALTER TABLE `". DB_PREFIX ."widget` ADD  `store_id` INT( 11 ) NOT NULL AFTER  `widget_id`");
       $this->db->query("ALTER TABLE  `". DB_PREFIX ."review` ADD  `store_id` INT( 11 ) NOT NULL AFTER  `review_id`");
       $this->db->query("ALTER TABLE `". DB_PREFIX ."customer` ADD  `store_id` INT( 11 ) NOT NULL AFTER  `customer_id`");
       $this->db->query("ALTER TABLE `". DB_PREFIX ."customer` ADD  `congrats` INT( 1 ) NOT NULL AFTER  `status`");
       $this->db->query("ALTER TABLE `". DB_PREFIX ."menu` ADD  `default` INT( 1 ) NOT NULL AFTER  `menu_id`");
       $this->db->query("ALTER TABLE `". DB_PREFIX ."manufacturer` ADD  `date_added` DATETIME NOT NULL");
       
        //CHANGE FIELDS
       $this->db->query("ALTER TABLE `". DB_PREFIX ."customer` CHANGE  `store`  `store_id` INT( 11 ) NOT NULL DEFAULT  '0'");
       $this->db->query("ALTER TABLE `". DB_PREFIX ."customer` CHANGE  `nacimiento`  `birthday` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL");
       $this->db->query("ALTER TABLE `". DB_PREFIX ."customer` CHANGE  `codigo`  `activation_code` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL");
       */
       
       
	   /*
       $results = $this->db->query("DELETE FROM ". DB_PREFIX ."product_to_store");
       $results = $this->db->query("SELECT product_id FROM ". DB_PREFIX ."product");
       foreach ($results->rows as $result) {
            $this->db->query("INSERT INTO ". DB_PREFIX ."product_to_store SET store_id = 0, product_id = '". (int)$result['product_id'] ."'");
       }
       
       $results = $this->db->query("DELETE FROM ". DB_PREFIX ."category_to_store");
       $results = $this->db->query("SELECT category_id FROM ". DB_PREFIX ."category");
       foreach ($results->rows as $result) {
            $this->db->query("INSERT INTO ". DB_PREFIX ."category_to_store SET store_id = 0, category_id = '". (int)$result['category_id'] ."'");
       }
       
       $results = $this->db->query("DELETE FROM ". DB_PREFIX ."manufacturer_to_store");
       $results = $this->db->query("SELECT manufacturer_id FROM ". DB_PREFIX ."manufacturer");
       foreach ($results->rows as $result) {
            $this->db->query("INSERT INTO ". DB_PREFIX ."manufacturer_to_store SET store_id = 0, manufacturer_id = '". (int)$result['manufacturer_id'] ."'");
       }
       
       $results = $this->db->query("DELETE FROM ". DB_PREFIX ."post_to_store");
       $results = $this->db->query("SELECT post_id FROM ". DB_PREFIX ."post");
       foreach ($results->rows as $result) {
            $this->db->query("INSERT INTO ". DB_PREFIX ."post_to_store SET store_id = 0, post_id = '". (int)$result['post_id'] ."'");
       }
       
       $results = $this->db->query("DELETE FROM ". DB_PREFIX ."post_category_to_store");
       $results = $this->db->query("SELECT post_category_id FROM ". DB_PREFIX ."post_category");
       foreach ($results->rows as $result) {
            $this->db->query("INSERT INTO ". DB_PREFIX ."post_category_to_store SET store_id = 0, post_category_id = '". (int)$result['post_category_id'] ."'");
       }
       
       $results = $this->db->query("DELETE FROM ". DB_PREFIX ."menu_to_store");
       $results = $this->db->query("SELECT menu_id FROM ". DB_PREFIX ."menu");
       foreach ($results->rows as $result) {
            $this->db->query("INSERT INTO ". DB_PREFIX ."menu_to_store SET store_id = 0, menu_id = '". (int)$result['menu_id'] ."'");
       }
       
       $results = $this->db->query("DELETE FROM ". DB_PREFIX ."banner_to_store");
       $results = $this->db->query("SELECT banner_id FROM ". DB_PREFIX ."banner");
       foreach ($results->rows as $result) {
            $this->db->query("INSERT INTO ". DB_PREFIX ."banner_to_store SET store_id = 0, banner_id = '". (int)$result['banner_id'] ."'");
       }
       
       $results = $this->db->query("DELETE FROM ". DB_PREFIX ."bank_account_to_store");
       $results = $this->db->query("SELECT bank_account_id FROM ". DB_PREFIX ."bank_account");
       foreach ($results->rows as $result) {
            $this->db->query("INSERT INTO ". DB_PREFIX ."bank_account_to_store SET store_id = 0, bank_account_id = '". (int)$result['bank_account_id'] ."'");
       }
       */
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
		
        $this->load->library('browser');
        $browser = new Browser;
        if ($browser->getBrowser() == 'Internet Explorer' && $browser->getVersion() <= 8) {
            $this->redirect(Url::createUrl("page/deprecated", null, 'NONSSL', HTTP_CATALOG));
        }
       
		if (!$this->user->validSession()) {
			$this->data['logged'] = '';
			$this->data['home'] = Url::createAdminUrl('common/login');
		} else {
			$this->data['logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());
            
            $this->load->library('update');
            $update = new Update($this->registry);
            $this->data['msg'] = $update->checkForUpdates();
            //var_dump($update->getInfo());
            
            if ($this->session->has('success')) {
                $this->data['success'] = $this->session->get('success');
                $this->session->clear('success');
            }
            
            if ($this->session->has('error')) {
                $this->data['error'] = $this->session->get('error');
                $this->session->clear('error');
            }
            
            $this->load->auto('sale/customer');
            $this->load->auto('sale/order');
            $this->load->auto('store/review');
            $this->load->auto("setting/store");
            
            $this->data['new_customers']= $this->modelCustomer->getAllTotalAwaitingApproval();
            $this->data['new_reviews']  = $this->modelReview->getAllTotalAwaitingApproval();
            $this->data['new_orders']   = $this->modelOrder->getAllTotalWithoutInvoice();
            $this->data['stores']       = $this->modelStore->getAll();
		}
        
        // style files
        $csspath = defined("CDN_CSS") ? CDN_CSS : HTTP_ADMIN_CSS;
        $styles[] = array('media'=>'all','href'=>$csspath.'normalize.min.css');
        $styles[] = array('media'=>'all','href'=>$csspath.'chosen.min.css');
        $styles[] = array('media'=>'all','href'=>$csspath.'reset.css');
        $styles[] = array('media'=>'all','href'=>$csspath.'text.css');
        $styles[] = array('media'=>'all','href'=>$csspath.'screen.css');
        $styles[] = array('media'=>'all','href'=>$csspath.'main.css');
        if ($styles) $this->styles = $this->data['styles'] = array_merge($this->styles,$styles);
        
		$this->id       = 'header';
		$this->template = 'common/header.tpl';
		
		$this->render();
	}
}