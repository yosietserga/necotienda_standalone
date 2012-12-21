<?php   
class ControllerCommonHome extends Controller {   
	public function index() {
		$this->document->title = $this->language->get('heading_title');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_overview']          = $this->language->get('text_overview');
		$this->data['text_statistics']        = $this->language->get('text_statistics');
		$this->data['text_latest_10_orders']  = $this->language->get('text_latest_10_orders');
		$this->data['text_total_sale']        = $this->language->get('text_total_sale');
		$this->data['text_total_sale_year']   = $this->language->get('text_total_sale_year');
		$this->data['text_total_order']       = $this->language->get('text_total_order');
		$this->data['text_total_customer']    = $this->language->get('text_total_customer');
		$this->data['text_total_customer_approval'] = $this->language->get('text_total_customer_approval');
		$this->data['text_total_product']     = $this->language->get('text_total_product');
		$this->data['text_total_review']      = $this->language->get('text_total_review');
		$this->data['text_total_review_approval'] = $this->language->get('text_total_review_approval');
		$this->data['text_day']               = $this->language->get('text_day');
		$this->data['text_week']              = $this->language->get('text_week');
		$this->data['text_month']             = $this->language->get('text_month');
		$this->data['text_year']              = $this->language->get('text_year');
		$this->data['text_no_results']        = $this->language->get('text_no_results');

		$this->data['column_order'] = $this->language->get('column_order');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_firstname'] = $this->language->get('column_firstname');
		$this->data['column_lastname'] = $this->language->get('column_lastname');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['entry_range'] = $this->language->get('entry_range');

		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);
		
		$this->data['token'] = $this->session->get('ukey');
		$this->data['total_sale'] = $this->currency->format($this->modelOrder->getTotalSales(), $this->config->get('config_currency'));
		$this->data['total_sale_year'] = $this->currency->format($this->modelOrder->getTotalSalesByYear(date('Y')), $this->config->get('config_currency'));
		$this->data['total_order'] = $this->modelOrder->getTotalOrders();
		$this->data['total_customer'] = $this->modelCustomer->getTotalCustomers();
		$this->data['total_customer_approval'] = $this->modelCustomer->getTotalCustomersAwaitingApproval();
		$this->data['total_product'] = $this->modelProduct->getTotalProducts();
		$this->data['total_review'] = $this->modelReview->getTotalReviews();
		$this->data['total_review_approval'] = $this->modelReview->getTotalReviewsAwaitingApproval();
		
		$this->data['orders'] = array(); 
		
		$data = array(
			'sort'  => 'o.date_added',
			'order' => 'DESC',
			'start' => 0,
			'limit' => 10
		);
		
		$results = $this->modelOrder->getOrders($data);
    	
    	foreach ($results as $result) {
			$action = array();
			 
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => Url::createAdminUrl('sale/order/update',array('order_id'=>$result['order_id']))
			);
					
			$this->data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'name'       => $result['name'],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'total'      => $this->currency->format($result['total'], $result['currency'], $result['value']),
				'action'     => $action
			);
		}

		if ($this->config->get('config_currency_auto')) {
			$this->load->auto('localisation/currency');
			$this->modelCurrency->updateCurrencies();
		}
		
        // javascript files
        $javascripts[] = "js/vendor/highcharts/highcharts.js";
        
        $this->data['javascripts'] = $this->javascripts = array_merge($javascripts,$this->javascripts);
        
        
        // SCRIPTS
        $scripts[] = array('id'=>'categoryList','method'=>'ready','script'=>
            "$('#chartOrders').load('". Url::createAdminUrl("chart/order") ."');
            $('#chartCustomers').load('". Url::createAdminUrl("chart/customer") ."');");
        $this->scripts = array_merge($this->scripts,$scripts);
        
        
		$this->template = 'common/home.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
	
	public function chart() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
        header("Cache-Control: no-cache, must-revalidate"); 
        header("Pragma: no-cache");
        header("Content-type: application/json");
        
		$data = array();
		
		$data['order'] = array();
		$data['customer'] = array();
		$data['xaxis'] = array();
		
		$data['order']['label'] = $this->language->get('text_order');
		$data['customer']['label'] = $this->language->get('text_customer');
		
		if (isset($this->request->get['range'])) {
			$range = $this->request->get['range'];
		} else {
			$range = 'month';
		}
		
		switch ($range) {
			case 'day':
				for ($i = 0; $i < 24; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id> '0' AND (DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "') GROUP BY HOUR(date_added) ORDER BY date_added ASC");
					
					if ($query->num_rows) {
						$data['order']['data'][]  = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][]  = array($i, 0);
					}
					
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE DATE(date_added) = DATE(NOW()) AND HOUR(date_added) = '" . (int)$i . "' GROUP BY HOUR(date_added) ORDER BY date_added ASC");
					
					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}
			
					$data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
				}					
				break;
			case 'week':
				$date_start = strtotime('-' . date('w') . ' days'); 
				
				for ($i = 0; $i < 7; $i++) {
					$date = date('Y-m-d', $date_start + ($i * 86400));

					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id> '0' AND DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");
			
					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}
				
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer` WHERE DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DATE(date_added)");
			
					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}
		
					$data['xaxis'][] = array($i, date('D', strtotime($date)));
				}
				
				break;
			default:
			case 'month':
				for ($i = 1; $i <= date('t'); $i++) {
					$date = date('Y') . '-' . date('m') . '-' . $i;
					
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id> '0' AND (DATE(date_added) = '" . $this->db->escape($date) . "') GROUP BY DAY(date_added)");
					
					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}	
				
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE DATE(date_added) = '" . $this->db->escape($date) . "' GROUP BY DAY(date_added)");
			
					if ($query->num_rows) {
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}	
					
					$data['xaxis'][] = array($i, date('j', strtotime($date)));
				}
				break;
			case 'year':
				for ($i = 1; $i <= 12; $i++) {
					$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id> '0' AND YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");
					
					if ($query->num_rows) {
						$data['order']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['order']['data'][] = array($i, 0);
					}
					
					$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE YEAR(date_added) = '" . date('Y') . "' AND MONTH(date_added) = '" . $i . "' GROUP BY MONTH(date_added)");
					
					if ($query->num_rows) { 
						$data['customer']['data'][] = array($i, (int)$query->row['total']);
					} else {
						$data['customer']['data'][] = array($i, 0);
					}
					
					$data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
				}			
				break;	
		} 
		
		$this->response->setOutput(Json::encode($data));
	}
	
	public function login() { 
		if (!$this->user->validSession()) {
            $this->user->logout();
			return $this->forward('common/login');
		}
        
		if (isset($this->request->get['r']) && !isset($this->request->get['token'])) {
			$route = '';
			$part = explode('/', $this->request->get['r']);
			
			if (isset($part[0])) {
				$route .= $part[0];
			}
			
			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}
			
			$ignore = array(
				'common/login',
				'common/logout',
				'error/not_found',
				'error/permission'
			);
			
			$config_ignore = array();
			
			if ($this->config->get('config_token_ignore')) {
				$config_ignore = unserialize($this->config->get('config_token_ignore'));
			}
				
			$ignore = array_merge($ignore, $config_ignore);
						
			if (!in_array($route, $ignore)) {
				if (!isset($this->request->get['token']) || !$this->user->validSession() || ($this->request->get['token'] != $this->session->get('ukey'))) {
				    $this->user->logout();
					return $this->forward('common/login');
				}
			}
		}
        
        if (substr_count($_SERVER['QUERY_STRING'],'token') >= 2) {
            foreach ($_GET as $arg => $value) {
                if ($arg == 'token') unset($_GET[$arg]);
            }
            $this->user->logout();
            return $this->forward('common/login');
		}
        if (!isset($this->request->get['token'])) {
				$this->user->logout();
                return $this->forward('common/login');
		}
        if ($this->request->get['token'] != $this->session->get('ukey')) {
				$this->user->logout();
                return $this->forward('common/login');
		}
	}
	
	public function permission() {
		if (isset($this->request->get['r'])) {
			$route = '';
			
			$part = explode('/', $this->request->get['r']);
			
			if (isset($part[0])) {
				$route .= $part[0];
			}
			
			if (isset($part[1])) {
				$route .= '/' . $part[1];
			}
			
			$ignore = array(
				'common/home',
				'common/login',
				'common/logout',
				'error/not_found',
				'error/permission',
				'error/token'		
			);			
						
			if (!in_array($route, $ignore)) {
				if (!$this->user->hasPermission('access', $route)) {
					return $this->forward('error/permission');
				}
			}
		}
	}
    
    
     public function slug() {
        //TODO: check if the slug doesn´t exists else put a number at the end
        $str = $_GET['slug'];
        if (isset($str)) {
        	if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
        		$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
        	$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
        	$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
        	$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
        	$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
        	$str = strtolower( trim($str, '-') );
            $return['slug'] = $str;
        } else {
            $return['error'] = 1;
        }
    	print json_encode($return);
    }
}