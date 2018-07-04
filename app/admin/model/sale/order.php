<?php  
/**
 * ModelSaleOrder
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 */
class ModelSaleOrder extends Model {
	
	public function add($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET ".
        "customer_id 	= '" . $this->db->escape($data['customer_id']) . "',".
        "store_name 	= '" . $this->db->escape($data['store_name']) . "',".
        "store_url 		= '" . $this->db->escape($data['store_url']) . "', ".
		"firstname 		= '" . $this->db->escape($data['firstname']) . "', ".
		"lastname 		= '" . $this->db->escape($data['lastname']) . "', ".
		"telephone 		= '" . $this->db->escape($data['telephone']) . "', ".
		"email 			= '" . $this->db->escape($data['email']) . "', ".

		"shipping_firstname 	= '" . $this->db->escape($data['shipping_firstname']) . "',".
		"shipping_lastname 		= '" . $this->db->escape($data['shipping_lastname']) . "', ".
		"shipping_company 		= '" . $this->db->escape($data['shipping_company']) . "', ".
		"shipping_address_1 	= '" . $this->db->escape($data['shipping_address_1']) . "',".
		"shipping_address_2 	= '" . $this->db->escape($data['shipping_address_2']) . "',".
		"shipping_city 			= '" . $this->db->escape($data['shipping_city']) . "', ".
		"shipping_zone 			= '" . $this->db->escape($data['shipping_zone']) . "', ".
		"shipping_zone_id 		= '" . (int)$data['shipping_zone_id'] . "', ".
		"shipping_country 		= '" . $this->db->escape($data['shipping_country']) . "',".
		"shipping_country_id 	= '" . (int)$data['shipping_country_id'] . "', ".

		"payment_firstname 		= '" . $this->db->escape($data['payment_firstname']) . "',".
		"payment_lastname 		= '" . $this->db->escape($data['payment_lastname']) . "', ".
		"payment_company 		= '" . $this->db->escape($data['payment_company']) . "', ".
		"payment_address_1 		= '" . $this->db->escape($data['payment_address_1']) . "',".
		"payment_address_2 		= '" . $this->db->escape($data['payment_address_2']) . "', ".
		"payment_city 			= '" . $this->db->escape($data['payment_city']) . "', ".
		"payment_postcode 		= '" . $this->db->escape($data['payment_postcode']) . "',".
		"payment_zone 			= '" . $this->db->escape($data['payment_zone']) . "', ".
		"payment_zone_id 		= '" . (int)$data['payment_zone_id'] . "', ".
		"payment_country 		= '" . $this->db->escape($data['payment_country']) . "',".
		"payment_country_id 	= '" . (int)$data['payment_country_id'] . "', ".

		"ip 			= '" . $this->db->escape('0.0.0.0') . "', ".
		"total 			= '" . $this->db->escape(preg_replace("/[^0-9.]/",'', $data['total'])) . "',".
		"date_added 	= NOW(), ".
		"date_modified 	= NOW()");
		
		$order_id = $this->db->getLastId();
		
		foreach ($data['product'] as $product) {
			if (!$product['product_id']) continue;
			$product['order_id'] = $order_id;
			$this->setProducts($data);
		}
	}
	
	public function update($order_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET 
        telephone 	= '" . $this->db->escape($data['telephone']) . "', 
        email 		= '" . $this->db->escape($data['email']) . "', 

        shipping_firstname 	= '" . $this->db->escape($data['shipping_firstname']) . "', 
        shipping_lastname 	= '" . $this->db->escape($data['shipping_lastname']) . "', 
        shipping_company 	= '" . $this->db->escape($data['shipping_company']) . "', 
        shipping_address_1 	= '" . $this->db->escape($data['shipping_address_1']) . "', 
        shipping_address_2 	= '" . $this->db->escape($data['shipping_address_2']) . "', 
        shipping_city 		= '" . $this->db->escape($data['shipping_city']) . "', 
        shipping_zone 		= '" . $this->db->escape($data['shipping_zone']) . "', 
        shipping_zone_id 	= '" . (int)$data['shipping_zone_id'] . "', 
        shipping_country 	= '" . $this->db->escape($data['shipping_country']) . "', 
        shipping_country_id = '" . (int)$data['shipping_country_id'] . "', 
        shipping_method 	= '" . $this->db->escape($data['shipping_method']) . "', 

        payment_firstname 	= '" . $this->db->escape($data['payment_firstname']) . "', 
        payment_lastname 	= '" . $this->db->escape($data['payment_lastname']) . "', 
        payment_company 	= '" . $this->db->escape($data['payment_company']) . "', 
        payment_address_1 	= '" . $this->db->escape($data['payment_address_1']) . "', 
        payment_address_2 	= '" . $this->db->escape($data['payment_address_2']) . "', 
        payment_city 		= '" . $this->db->escape($data['payment_city']) . "', 
        payment_postcode 	= '" . $this->db->escape($data['payment_postcode']) . "', 
        payment_zone 		= '" . $this->db->escape($data['payment_zone']) . "', 
        payment_zone_id 	= '" . (int)$data['payment_zone_id'] . "', 
        payment_country 	= '" . $this->db->escape($data['payment_country']) . "', 
        payment_country_id 	= '" . (int)$data['payment_country_id'] . "', 
        payment_method 		= '" . $this->db->escape($data['payment_method']) . "', 

        date_modified 		= NOW() 
        WHERE order_id 		= '" . (int)$order_id . "'");
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
		foreach ($data['product'] as $product) {
			if (!$product['product_id']) continue;
			$product['order_id'] = $order_id;
			$this->setProducts($data);
		}
		
		foreach ($data['totals'] as $key => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "order_total SET text = '" . $this->db->escape($value) . "' WHERE order_total_id = '" . (int)$key . "'");
		}
	}
	
	public function setProducts($data) {
		$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p ".
        	"LEFT JOIN " . DB_PREFIX . "description pd ON (p.product_id = pd.object_id) ".
        "WHERE p.product_id='" . (int)$data['product_id'] . "' ".
        	"AND pd.object_type = 'product' ".
        	"AND pd.language_id = '". $this->config->get('config_language_id') ."' ");
							
		$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET ".
			"order_id 	= '" . (int)$data['order_id'] . "', ".
			"product_id = '" . (int)$data['product_id'] . "', ".
			"name 		= '" . $this->db->escape($product_query->row['title']) . "', ".
			"model 		= '" . $this->db->escape($product_query->row['model']) . "', ".
			"price 		= '" . $this->db->escape(preg_replace("/[^0-9.]/",'', $data['price'])) . "', ".
	        "total 		= '" . $this->db->escape(preg_replace("/[^0-9.]/",'', $data['total'])) . "', ".
	        "quantity 	= '" . $this->db->escape($data['quantity']) . "'");
	}

	public function delete($order_id) {
		if ($this->config->get('config_stock_subtract')) {
			$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` ".
	            "WHERE order_status_id > '0' ".
	            	"AND order_id = '" . (int)$order_id . "'");
			
			if ($order_query->num_rows) {
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
				
				foreach($product_query->rows as $product) {
					$this->db->query("UPDATE `" . DB_PREFIX . "product` SET ".
                    "quantity = (quantity + " . (int)$product['quantity'] . ") ".
                    "WHERE product_id = '" . (int)$product['product_id'] . "'");
					
					$option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option ".
	                    "WHERE order_id = '" . (int)$order_id . "' ".
	                    	"AND order_product_id = '" . (int)$product['order_product_id'] . "'");
				
					foreach ($option_query->rows as $option) {
						$this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET ".
	                        	"quantity = (quantity + " . (int)$product['quantity'] . ") ".
	                        "WHERE product_option_value_id = '" . (int)$option['product_option_value_id'] . "' ".
	                        	"AND subtract = '1'");
					}				
				}
			}
		}
		
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$order_id ." ".
                "AND object_type = 'order'");
        }

		$this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
      	$this->db->query("DELETE FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");
      	$this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
      	$this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "'");
	  	$this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "'");
      	$this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "'");
	}
	
	public function addHistory($order_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET 
        order_status_id = '" . (int)$data['order_status_id'] . "', 
        date_modified = NOW() 
        WHERE order_id = '" . (int)$order_id . "'");

		if ($data['append']) {
      		$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET 
              order_id = '" . (int)$order_id . "', 
              order_status_id = '" . (int)$data['order_status_id'] . "', 
              notify = '" . (isset($data['notify']) ? (int)$data['notify'] : 0) . "', 
              comment = '" . $this->db->escape(strip_tags($data['comment'])) . "', 
              date_added = NOW()");
		}
	}

    public function getById($id) {
        $result = $this->getAll(array(
            'order_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.orders";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->user->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT *, ".
            "os.name AS status, ".

            "zosd.title AS shipping_zone, ".
            "zos.code AS shipping_zone_code, ".
            "cos.iso_code_2 AS shipping_iso_code_2, ".
            "cos.iso_code_3 AS shipping_iso_code_3, ".
            "cosd.title AS shipping_country, ".

            "zopd.title AS payment_zone, ".
            "zop.code AS payment_zone_code, ".
            "cop.iso_code_2 AS payment_iso_code_2, ".
            "cop.iso_code_3 AS payment_iso_code_3, ".
            "copd.title AS payment_country ".

            " FROM " . DB_PREFIX . "order t ";

            if (!isset($sort_data)) {
                $sort_data = array(
					't.order_id',
					't.firstname',
					't.date_modified',
					't.total'
                );
            }
            $sql .= $this->buildSQLQuery($data, $sort_data);
            $query = $this->db->query($sql);

            $this->cache->set($cachedId, $query->rows);
            return $query->rows;
        } else {
            return $cached;
        }
    }

    public function getAllTotal($data=null) {
        $cache_prefix = "admin.orders.total";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->user->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order t ";
            $sql .= $this->buildSQLQuery($data, null, true);
            $query = $this->db->query($sql);

            $this->cache->set($cachedId, $query->row['total']);

            return $query->row['total'];
        } else {
            return $cached;
        }
    }

    public function getAllSum($data=null) {
        $cache_prefix = "admin.orders.sum";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->user->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT SUM(t.total) AS total FROM " . DB_PREFIX . "order t ";
            $sql .= $this->buildSQLQuery($data, null, true);
            $query = $this->db->query($sql);

            $this->cache->set($cachedId, $query->row['total']);
            return $query->row['total'];
        } else {
            return $cached;
        }
    }

    private function buildSQLQuery($data, $sort_data = null, $countAsTotal = false) {
        $criteria = array();
        $sql = "";

		$sql .= "LEFT JOIN `" . DB_PREFIX . "country` cos ON (cos.country_id = t.shipping_country_id) ";
		$sql .= "LEFT JOIN `" . DB_PREFIX . "country` cop ON (cop.country_id = t.payment_country_id) ";
		$sql .= "LEFT JOIN `" . DB_PREFIX . "zone` zos ON (zos.zone_id = t.shipping_zone_id) ";
		$sql .= "LEFT JOIN `" . DB_PREFIX . "zone` zop ON (zop.zone_id = t.payment_zone_id) ";

        if (!$countAsTotal) {
			$sql .= "LEFT JOIN `" . DB_PREFIX . "description` zopd ON (zos.zone_id = zopd.object_id) ";
			$sql .= "LEFT JOIN `" . DB_PREFIX . "description` zosd ON (zos.zone_id = zosd.object_id) ";
			$sql .= "LEFT JOIN `" . DB_PREFIX . "description` cosd ON (cos.country_id = cosd.object_id) ";
			$sql .= "LEFT JOIN `" . DB_PREFIX . "description` copd ON (cop.country_id = copd.object_id) ";
		}

        $sql .= "LEFT JOIN `" . DB_PREFIX . "customer` c ON (t.customer_group_id = c.customer_id) ";
        $sql .= "LEFT JOIN `" . DB_PREFIX . "customer_group` cg ON (t.customer_group_id = cg.customer_group_id) ";
        $sql .= "LEFT JOIN `" . DB_PREFIX . "order_status` os ON (t.order_status_id = os.order_status_id) ";
        $sql .= "LEFT JOIN `" . DB_PREFIX . "currency` cur ON (t.currency_id = cur.currency_id) ";

        $data['currency_id'] = !is_array($data['currency_id']) && !empty($data['currency_id']) ? array($data['currency_id']) : $data['currency_id'];
        $data['customer_id'] = !is_array($data['customer_id']) && !empty($data['customer_id']) ? array($data['customer_id']) : $data['customer_id'];
        $data['customer_group_id'] = !is_array($data['customer_group_id']) && !empty($data['customer_group_id']) ? array($data['customer_group_id']) : $data['customer_group_id'];
        $data['shipping_country_id'] = !is_array($data['shipping_country_id']) && !empty($data['shipping_country_id']) ? array($data['shipping_country_id']) : $data['shipping_country_id'];
        $data['payment_country_id'] = !is_array($data['payment_country_id']) && !empty($data['payment_country_id']) ? array($data['payment_country_id']) : $data['payment_country_id'];
        $data['shipping_zone_id'] = !is_array($data['shipping_zone_id']) && !empty($data['shipping_zone_id']) ? array($data['shipping_zone_id']) : $data['shipping_zone_id'];
        $data['payment_zone_id'] = !is_array($data['payment_zone_id']) && !empty($data['payment_zone_id']) ? array($data['payment_zone_id']) : $data['payment_zone_id'];
        $data['order_status_id'] = !is_array($data['order_status_id']) && !empty($data['order_status_id']) ? array($data['order_status_id']) : $data['order_status_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];
        $data['coupon_id'] = !is_array($data['coupon_id']) && !empty($data['coupon_id']) ? array($data['coupon_id']) : $data['coupon_id'];
        $data['invoice_id'] = !is_array($data['invoice_id']) && !empty($data['invoice_id']) ? array($data['invoice_id']) : $data['invoice_id'];
        $data['order_id'] = !is_array($data['order_id']) && !empty($data['order_id']) ? array($data['order_id']) : $data['order_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $criteria[] = " t.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }


        $criteria[] = " os.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (isset($data['order_id']) && !empty($data['order_id'])) {
            $criteria[] = " t.order_id IN (" . implode(', ', $data['order_id']) . ") ";
        }

        if (isset($data['invoice_id']) && !empty($data['invoice_id'])) {
            $criteria[] = " t.invoice_id IN (" . implode(', ', $data['invoice_id']) . ") ";
        }

        if (isset($data['coupon_id']) && !empty($data['coupon_id'])) {
        	$sql .= "LEFT JOIN `" . DB_PREFIX . "coupon` cou ON (t.coupon_id = cou.coupon_id) ";
            $criteria[] = " t.coupon_id IN (" . implode(', ', $data['coupon_id']) . ") ";
        }

        if (isset($data['customer_id']) && !empty($data['customer_id'])) {
            $criteria[] = " t.customer_id IN (" . implode(', ', $data['customer_id']) . ") ";
        }

        if (isset($data['customer_group_id']) && !empty($data['customer_group_id'])) {
            $criteria[] = " t.customer_group_id IN (" . implode(', ', $data['customer_group_id']) . ") ";
        }

        if (isset($data['currency_id']) && !empty($data['currency_id'])) {
            $criteria[] = " t.currency_id IN (" . implode(', ', $data['currency_id']) . ") ";
        }

        if (isset($data['shipping_country_id']) && !empty($data['shipping_country_id'])) {
            $criteria[] = " t.shipping_country_id IN (" . implode(', ', $data['shipping_country_id']) . ") ";
        }

        if (isset($data['payment_country_id']) && !empty($data['payment_country_id'])) {
            $criteria[] = " t.payment_country_id IN (" . implode(', ', $data['payment_country_id']) . ") ";
        }

        if (isset($data['shipping_zone_id']) && !empty($data['shipping_zone_id'])) {
            $criteria[] = " t.shipping_zone_id IN (" . implode(', ', $data['shipping_zone_id']) . ") ";
        }

        if (isset($data['payment_zone_id']) && !empty($data['payment_zone_id'])) {
            $criteria[] = " t.payment_zone_id IN (" . implode(', ', $data['payment_zone_id']) . ") ";
        }

        if (isset($data['order_status_id']) && !empty($data['order_status_id'])) {
            $criteria[] = " t.order_status_id IN (" . implode(', ', $data['order_status_id']) . ") ";
        } else {
            $criteria[] = " t.order_status_id > 0 ";
        }

        if (isset($data['customer_name']) && !empty($data['customer_name'])) {
            $criteria[] = " LCASE(CONCAT(t.firstname, ' ', t.lastname)) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['firstname']) && !empty($data['firstname'])) {
            $criteria[] = " LCASE(t.firstname) LIKE '%" . $this->db->escape(strtolower($data['firstname'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['lasttname']) && !empty($data['lasttname'])) {
            $criteria[] = " LCASE(t.lasttname) LIKE '%" . $this->db->escape(strtolower($data['lasttname'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['company']) && !empty($data['company'])) {
            $criteria[] = " LCASE(c.company) LIKE '%" . $this->db->escape(strtolower($data['company'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['rif']) && !empty($data['rif'])) {
            $criteria[] = " LCASE(c.`rif`) LIKE '%" . $this->db->escape(strtolower($data['rif'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['email']) && !empty($data['email'])) {
            $criteria[] = " LCASE(t.`email`) LIKE '%" . $this->db->escape(strtolower($data['email'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['telephone']) && !empty($data['telephone'])) {
            $criteria[] = " LCASE(t.`telephone`) LIKE '%" . $this->db->escape(strtolower($data['telephone'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['currency']) && !empty($data['currency'])) {
            $criteria[] = " LCASE(t.`currency`) LIKE '%" . $this->db->escape(strtolower($data['currency'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['ip']) && !empty($data['ip'])) {
            $criteria[] = " LCASE(t.`ip`) LIKE '%" . $this->db->escape(strtolower($data['ip'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['from_total']) || isset($data['to_total'])) {

            if (isset($data['from_total']) && !empty($data['from_total'])) {
                $criteria[] = " t.`total` >= '" . $this->db->escape((float)$data['from_total']) . "' ";
            }

            if (isset($data['to_total']) && !empty($data['to_total'])) {
                $criteria[] = " t.`total` <= '" . $this->db->escape((float)$data['to_total']) . "' ";
            }

        } elseif (isset($data['total']) && !empty($data['total'])) {
            $criteria[] = " t.`total` = '" . $this->db->escape((float)$data['total']) . "' ";
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " t.date_modified BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " t.date_modified BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.order_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'order' ";
            }
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.order_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.date_modified";
                $sql .= ($data['order'] == 'DESC') ? " DESC" : " ASC";
            }

            if ($data['start'] && $data['limit']) {
                if ($data['start'] < 0) $data['start'] = 0;
                if (!$data['limit']) $data['limit'] = 24;

                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            } elseif ($data['limit']) {
                if (!$data['limit']) $data['limit'] = 24;

                $sql .= " LIMIT ". (int)$data['limit'];
            }
        }
        return $sql;
    }
	
	public function generateInvoiceId($order_id) {
		$query = $this->db->query("SELECT MAX(invoice_id) AS invoice_id FROM `" . DB_PREFIX . "order`");
		
		if ($query->row['invoice_id']) {
			$invoice_id = (int)$query->row['invoice_id'] + 1;
		} elseif ($this->config->get('config_invoice_id')) {
			$invoice_id = $this->config->get('config_invoice_id');
		} else {
			$invoice_id = 1;
		}
		
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET ".
				"invoice_id = '" . (int)$invoice_id . "', ".
				"invoice_prefix = '" . $this->db->escape($this->config->get('config_invoice_prefix')) . "', ".
				"date_modified = NOW() ".
			"WHERE order_id = '" . (int)$order_id . "'");
		
		return $this->config->get('config_invoice_prefix') . $invoice_id;
	}
	
	public function getProducts($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
	
		return $query->rows;
	}

	public function getOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");
	
		return $query->rows;
	}
	
	public function getTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");
	
		return $query->rows;
	}	

	public function getHistory($order_id) { 
		$query = $this->db->query("SELECT ".
				"oh.date_added, ".
				"os.name AS status, ".
				"oh.comment, ".
				"oh.notify ".
			"FROM " . DB_PREFIX . "order_history oh ".
				"LEFT JOIN " . DB_PREFIX . "order_status os ON (oh.order_status_id = os.order_status_id) ".
			"WHERE oh.order_id = '" . (int)$order_id . "' ".
				"AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ".
			"ORDER BY oh.date_added");
	
		return $query->rows;
	}	

	public function getDownloads($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int)$order_id . "' ORDER BY name");

		return $query->rows; 
	}	
	
	public function getHistoryTotalByOrderStatusId($order_status_id) {
	  	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history oh ".
			"LEFT JOIN `" . DB_PREFIX . "order` o ON (oh.order_id = o.order_id) ".
		"WHERE oh.order_status_id = '" . (int)$order_status_id . "' ".
			"AND o.order_status_id > '0' ".
		"GROUP BY order_id");

		return $query->row['total'];
	}

	public function getAllTotalByLanguageId($language_id) {
		return $this->getAllTotal(array(
			'language_id' => (int)$language_id
		));
	}	
	
	public function getAllTotalByCurrencyId($currency_id) {
		return $this->getAllTotal(array(
			'currency_id' => (int)$currency_id
		));
	}

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('order', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('order', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('order', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('order', $id, $group);
    }

    public function setAllProperties($id, $group, $data) {
        if (is_array($data) && !empty($data)) {
            $this->deleteProperty($id, $group);
            foreach ($data as $key => $value) {
                $this->setProperty($id, $group, $key, $value);
            }
        }
    }
}
