<?php
/**
 * ModelSaleCoupon
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelSaleCoupon extends Model {
	/**
	 * ModelSaleCoupon::addCoupon()
	 * 
	 * @param mixed $data
     * @see DB
	 * @return void
	 */
	public function add($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET ".
          "code      = '" . $this->db->escape($data['code']) . "', ".
          "discount  = '" . (float)$data['discount'] . "', ".
          "type      = '" . $this->db->escape($data['type']) . "', ".
          "total     = '" . (float)$data['total'] . "', ".
          "logged    = '" . (int)$data['logged'] . "', ".
          "shipping  = '" . (int)$data['shipping'] . "', ".
          "date_start= '" . $this->db->escape($data['date_start']) . "', ".
          "date_end  = '" . $this->db->escape($data['date_end']) . "', ".
          "uses_total= '" . (int)$data['uses_total'] . "', ".
          "uses_customer = '" . (int)$data['uses_customer'] . "', ".
          "status    = '" . (int)$data['status'] . "', ".
          "date_added= NOW()");

      	$coupon_id = $this->db->getLastId();

        $this->setDescriptions($coupon_id, $data['coupon_description']);

        foreach ($data['stores'] as $store) {
    		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_to_store SET ".
            "store_id  = '". intval($store) ."', ".
            "coupon_id = '". intval($coupon_id) ."'");
        }
        
        foreach ($data['Products'] as $product_id => $value) {
            if ($value == 0) continue;
    		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_product SET ".
    			"product_id = '" . (int)$product_id . "', ".
    			"coupon_id  = '" . (int)$coupon_id."' ");
		}
        return $coupon_id;
	}
	
	/**
	 * ModelSaleCoupon::editCoupon()
	 * 
	 * @param int $coupon_id
	 * @param mixed $data
     * @see DB
	 * @return void
	 */
	public function update($coupon_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "coupon SET ".
          "code      = '" . $this->db->escape($data['code']) . "', ".
          "discount  = '" . (float)$data['discount'] . "', ".
          "type      = '" . $this->db->escape($data['type']) . "', ".
          "total     = '" . (float)$data['total'] . "', ".
          "logged    = '" . (int)$data['logged'] . "', ".
          "shipping  = '" . (int)$data['shipping'] . "', ".
          "date_start= '" . $this->db->escape($data['date_start']) . "', ".
          "date_end  = '" . $this->db->escape($data['date_end']) . "', ".
          "uses_total= '" . (int)$data['uses_total'] . "', ".
          "uses_customer = '" . (int)$data['uses_customer'] . "', ".
          "status    = '" . (int)$data['status'] . "' ".
        "WHERE coupon_id = '" . (int)$coupon_id . "'");

        $this->setDescriptions($coupon_id, $data['coupon_description']);

        $this->db->query("DELETE FROM " . DB_PREFIX . "coupon_to_store WHERE coupon_id = '". (int)$coupon_id ."'");
        foreach ($data['stores'] as $store) {
    		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_to_store SET ".
            "store_id  = '". intval($store) ."', ".
            "coupon_id = '". intval($coupon_id) ."'");
        }
        
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_product WHERE coupon_id = '" . (int)$coupon_id . "'");
        foreach ($data['Products'] as $product_id => $value) {
            if ($value == 0) continue;
    		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon_product SET ".
    			"product_id = '" . (int)$product_id . "', ".
    			"coupon_id  = '" . (int)$coupon_id."' ");
		}		
	}
	
	/**
	 * ModelStoreProduct::copy()
	 * 
	 * @param int $product_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function copy($coupon_id) {
		$coupon = $this->getById($coupon_id);

		if ($query->num_rows) {
			$data = array();
			$data = $coupon;
			$data['code'] = uniqid();
			$data = array_merge($data, array('coupon_description' => $this->getDescriptions($coupon_id)));
			$data = array_merge($data, array('Products' => $this->getCouponProducts($coupon_id)));
			$this->addCoupon($data);
		}
	}
	
	/**
	 * ModelSaleCoupon::deleteCoupon()
	 * 
	 * @param int $coupon_id
     * @see DB
	 * @return void
	 */
	public function delete($coupon_id) {
        $shared_tables = array(
            'property',
            'description',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$id ." ".
                "AND object_type = 'coupon'");
        }

      	$this->db->query("DELETE FROM " . DB_PREFIX . "coupon WHERE coupon_id = '" . (int)$coupon_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_product WHERE coupon_id = '" . (int)$coupon_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_to_store WHERE coupon_id = '" . (int)$coupon_id . "'");		
	}
	
    public function getByID($id) {
        $result = $this->getAll(array(
            'coupon_id'=>$id,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.coupons";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "coupon t ".
                "LEFT JOIN " . DB_PREFIX . "description td ON (t.coupon_id = td.object_id) ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'title',
					'code',
					'discount',
					't.date_start',
					't.date_end',
					't.status'
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
        $cache_prefix = "admin.coupons.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "coupon t ".
                "LEFT JOIN " . DB_PREFIX . "description td ON (t.coupon_id = td.object_id) ";
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

        $criteria[] = " td.object_type = 'coupon' ";

        $data['coupon_id'] = !is_array($data['coupon_id']) && !empty($data['coupon_id']) ? array($data['coupon_id']) : $data['coupon_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "coupon_to_store t2s ON (t.coupon_id = t2s.coupon_id) ";
            $criteria[] = " t2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['coupon_id']) && !empty($data['coupon_id'])) {
            $criteria[] = " t.coupon_id IN (" . implode(', ', $data['coupon_id']) . ") ";
        }

        if (isset($data['language_id']) && !empty($data['language_id'])) {
            $criteria[] = " td.language_id IN (" . implode(', ', $data['language_id']) . ") ";
        }

        if ($data['queries']) {
            $search = $search2 = '';
            foreach ($data['queries'] as $key => $value) {
                if (empty($value)) continue;
                if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                    $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                $search .= " LCASE(td.`title`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";

                if (isset($data['search_in_description'])) {
                    $search2 .= " LCASE(td.description) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
                }
            }
            if (!empty($search)) {
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
            if (!empty($search2)) {
                $criteria[] = " (". rtrim($search2,'OR') .")";
            }
        }

        if (isset($data['title']) && !empty($data['title'])) {
            $criteria[] = " LCASE(td.`title`) LIKE '%" . $this->db->escape(strtolower($data['title'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (p.coupon_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'coupon' ";
            }
        }

        if (!empty($data['date_start'])) {
            $criteria[] = "date_start <= '" . date('Y-m-d h:i:s', strtotime($data['date_start'])) . "'";
        }

        if (!empty($data['date_end'])) {
            $criteria[] = "date_end >= '" . date('Y-m-d h:i:s', strtotime($data['date_end'])) . "'";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.coupon_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY td.title";
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

	public function getStores($id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon_to_store WHERE coupon_id = '" . (int)$id . "'");
		foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
		}
		return $data;
	}	
	
	/**
	 * ModelSaleCoupon::getCouponProducts()
	 * 
	 * @param int $coupon_id
     * @see DB
	 * @return array sql records
	 */
	public function getProducts($coupon_id) {
		$coupon_product_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon_product WHERE coupon_id = '" . (int)$coupon_id . "'");
		
		foreach ($query->rows as $result) {
			$coupon_product_data[] = $result['product_id'];
		}
		
		return $coupon_product_data;
	}

    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('coupon', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('coupon', $id, $data);
    }

    public function activate($id) {
        return $this->__activate('coupon', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('coupon', $id);
    }
    
    public function getProperty($id, $group, $key) {
        return $this->__getProperty('coupon', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('coupon', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('coupon', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('coupon', $id, $group);
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
