<?php
class ModelStoreSearch extends Model {
	public function add() {
        $this->load->library('browser');
        $browser = new Browser;
        if ($browser->getBrowser() != 'GoogleBot') {
            $sql = "INSERT INTO " . DB_PREFIX . "search SET
                `customer_id`   = '". (int)$this->customer->getId() ."',
                store_id   = '" . (int)STORE_ID . "',
                `request`       = '". $this->db->escape(serialize($_REQUEST)) ."',
                `urlQuery`      = '". $this->db->escape($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']) ."',
                `browser`       = '". $this->db->escape($browser->getBrowser()) ."',
                `browser_version`= '". $this->db->escape($browser->getVersion()) ."',
                `os`            = '". $this->db->escape($browser->getPlatform()) ."',
                `ip`            = '". $this->db->escape($_SERVER['REMOTE_ADDR']) ."',
                `date_added`    = NOW()";

    		$this->db->query($sql);
            return $this->db->getLastId();
        }
	}

	public function getAllProducts($data) {
            $cache_prefix = "shop.searches.products";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT DISTINCT *, pd.name AS name FROM " . DB_PREFIX . "product p
            LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

   	        $criteria = array();
            $search = "";

            $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
            $criteria[] = " p.status = '1'";
            $criteria[] = " p.date_available <= NOW()";

            if ($data['queries']) {
                foreach ($data['queries'] as $key => $value) {
                    if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                        $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                    $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                    $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                    $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                    $search .= " LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
                }
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
            if (!empty($data['category'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = p2c.category_id) ";
                $criteria[] = " LCASE(cd.name) = '" . $this->db->escape(strtolower($data['category'])) . "' ";
            }
            if (!empty($data['properties'])) {
               $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";
               foreach ($data['properties'] as $key => $value) {
                   $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' ";
                   $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
               }
            }
            if (!empty($data['zone'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_zone p2z ON (p.product_id = p2z.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "zone z ON (z.zone_id = p2z.zone_id) ";
                $criteria[] = " LCASE(z.name) = '" . $this->db->escape(strtolower($data['zone'])) . "' ";
            }
            if (!empty($data['stock_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) ";
                $criteria[] = " ss.language_id = '". (int)$this->config->get('config_language_id') ."'";
                $criteria[] = " LCASE(ss.name) LIKE '%" . $this->db->escape($data['stock_status']) . "%' ";
            }
            if (!empty($data['seller'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "customer cu ON (p.owner_id = cu.customer_id) ";
                $criteria[] = " LCASE(cu.company) = '" . $this->db->escape(strtolower($data['seller'])) . "' ";
                $criteria[] = " cu.status = '1'";
            }
            if (!empty($data['manufacturer'])) {
                $criteria[] = " LCASE(m.name) LIKE '%" . $this->db->escape(strtolower($data['manufacturer'])) . "%' ";
            }
            if (!empty($data['store'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "store s ON (s.store_id = p2s.store_id) ";
                $criteria[] = " LCASE(s.name) = '" . $this->db->escape(strtolower($data['store'])) . "' ";
            }
            if (!empty($data['shipping_method']) || !empty($data['payment_method']) || !empty($data['product_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";

                if (!empty($data['shipping_method'])) {
                    foreach ($data['shipping_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'shipping_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['payment_method'])) {
                    foreach ($data['payment_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'payment_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['product_status'])) {
                    foreach ($data['product_status'] as $key => $value) {
                        $criteria[] = " `group` = 'product_status' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }
            }

            if (!empty($data['date_start']) && !empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            } elseif (!empty($data['date_start'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND NOW()";
            } elseif (!empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN NOW() AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            }

            if (!empty($data['price_start']) && !empty($data['price_end'])) {
                $criteria[] = " p.price BETWEEN '". (float)$data['price_start'] ."' AND '". (float)$data['price_end'] ."'";
            } elseif (!empty($data['price_start'])) {
                $criteria[] = " p.price >= '". (float)$data['price_start'] ."'";
            } elseif (!empty($data['price_end'])) {
                $criteria[] = " p.price <= '". (float)$data['price_end'] ."'";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }

    		$sort_data = array(
    			'pd.name',
    			'p.sort_order',
    			'p.viewed',
    			'p.mailed',
    			'p.called',
    			'p.buyed',
    			'p.price'
    		);

    		$sql .=  (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY p.sort_order";
    		$sql .=  ($data['order'] == 'DESC') ? " DESC" : " ASC";

    		if ($data['start'] < 0) $data['start'] = 0;
    		if (!$data['limit']) $data['limit'] = 50;

    		$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];

            $query = $this->db->query($sql);

            return $query->rows;
        } else {
            return $cached;
        }
	}

	public function getAllProductsTotal($data) {
            $cache_prefix = "shop.searches.products.total";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p
            LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) ";

            $criteria = array();

            $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
            $criteria[] = " p.status = '1'";
            $criteria[] = " p.date_available <= NOW()";
           $search = '';

            if ($data['queries']) {
                foreach ($data['queries'] as $key => $value) {
                    if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                        $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                    $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                    $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                    $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                    $search .= " LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
                }
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
            if (!empty($data['category'])) {
               $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) ";
               $sql .= " LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = p2c.category_id) ";
               $criteria[] = " LCASE(cd.name) = '" . $this->db->escape(strtolower($data['category'])) . "' ";
            }
            if (!empty($data['properties'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";
                foreach ($data['properties'] as $key => $value) {
                    $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' ";
                    $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                }
            }
            if (!empty($data['zone'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_zone p2z ON (p.product_id = p2z.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "zone z ON (z.zone_id = p2z.zone_id) ";
                $criteria[] = " LCASE(z.name) = '" . $this->db->escape(strtolower($data['zone'])) . "' ";
            }
            if (!empty($data['stock_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) ";
                $criteria[] = " ss.language_id = '". (int)$this->config->get('config_language_id') ."'";
                $criteria[] = " LCASE(ss.name) LIKE '%" . $this->db->escape($data['stock_status']) . "%' ";
            }
            if (!empty($data['seller'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "customer cu ON (p.owner_id = cu.customer_id) ";
                $criteria[] = " LCASE(cu.company) = '" . $this->db->escape(strtolower($data['seller'])) . "' ";
                $criteria[] = " cu.status = '1'";
            }
            if (!empty($data['manufacturer'])) {
                $criteria[] = " LCASE(m.name) LIKE '%" . $this->db->escape(strtolower($data['manufacturer'])) . "%' ";
            }
            if (!empty($data['store'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "store s ON (s.store_id = p2s.store_id) ";
                $criteria[] = " LCASE(s.name) = '" . $this->db->escape(strtolower($data['store'])) . "' ";
            }
            if (!empty($data['shipping_method']) || !empty($data['payment_method']) || !empty($data['product_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";

                if (!empty($data['shipping_method'])) {
                    foreach ($data['shipping_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'shipping_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['payment_method'])) {
                    foreach ($data['payment_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'payment_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['product_status'])) {
                    foreach ($data['product_status'] as $key => $value) {
                        $criteria[] = " `group` = 'product_status' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }
            }

            if (!empty($data['date_start']) && !empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            } elseif (!empty($data['date_start'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND NOW()";
            } elseif (!empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN NOW() AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            }

            if (!empty($data['price_start']) && !empty($data['price_end'])) {
                $criteria[] = " p.price BETWEEN '". (float)$data['price_start'] ."' AND '". (float)$data['price_end'] ."'";
            } elseif (!empty($data['price_start'])) {
                $criteria[] = " p.price >= '". (float)$data['price_start'] ."'";
            } elseif (!empty($data['price_end'])) {
                $criteria[] = " p.price <= '". (float)$data['price_end'] ."'";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }

            $query = $this->db->query($sql);
            return $query->row['total'];
        } else {
            return $cached;
        }
	}

    public function getCategoriesByProduct($data) {
            $cache_prefix = "shop.searches.categories";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT DISTINCT cd.category_id, cd.name, COUNT(*) AS total FROM " . DB_PREFIX . "product_to_category p2c
                LEFT JOIN " . DB_PREFIX . "category_description cd ON (p2c.category_id = cd.category_id)
                LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = p2c.product_id)
                LEFT JOIN " . DB_PREFIX . "product_description pd ON (pd.product_id = p2c.product_id) ";

            $search = "";
   	        $criteria   = array();
            $criteria[] = " p.status = '1'";
            $criteria[] = " p.date_available <= NOW()";
            $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

            if ($data['queries']) {
                foreach ($data['queries'] as $key => $value) {
                    if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                        $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                    $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                    $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                    $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                    $search .= " LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
                }
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
            if (!empty($data['properties'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";
                foreach ($data['properties'] as $key => $value) {
                    $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' ";
                    $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                }
            }
            if (!empty($data['zone'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_zone p2z ON (p.product_id = p2z.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "zone z ON (z.zone_id = p2z.zone_id) ";
                $criteria[] = " LCASE(z.name) = '" . $this->db->escape(strtolower($data['zone'])) . "' ";
            }
            if (!empty($data['stock_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) ";
                $criteria[] = " ss.language_id = '". (int)$this->config->get('config_language_id') ."'";
                $criteria[] = " LCASE(ss.name) LIKE '%" . $this->db->escape($data['stock_status']) . "%' ";
            }
            if (!empty($data['seller'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "customer cu ON (p.owner_id = cu.customer_id) ";
                $criteria[] = " LCASE(cu.company) = '" . $this->db->escape(strtolower($data['seller'])) . "' ";
                $criteria[] = " cu.status = '1'";
            }
            if (!empty($data['manufacturer'])) {
                $criteria[] = " LCASE(m.name) LIKE '%" . $this->db->escape(strtolower($data['manufacturer'])) . "%' ";
            }
            if (!empty($data['store'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "store s ON (s.store_id = p2s.store_id) ";
                $criteria[] = " LCASE(s.name) = '" . $this->db->escape(strtolower($data['store'])) . "' ";
            }
            if (!empty($data['shipping_method']) || !empty($data['payment_method']) || !empty($data['product_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";

                if (!empty($data['shipping_method'])) {
                    foreach ($data['shipping_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'shipping_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['payment_method'])) {
                    foreach ($data['payment_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'payment_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['product_status'])) {
                    foreach ($data['product_status'] as $key => $value) {
                        $criteria[] = " `group` = 'product_status' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }
            }

            if (!empty($data['date_start']) && !empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            } elseif (!empty($data['date_start'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND NOW()";
            } elseif (!empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN NOW() AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            }

            if (!empty($data['price_start']) && !empty($data['price_end'])) {
                $criteria[] = " p.price BETWEEN '". (float)$data['price_start'] ."' AND '". (float)$data['price_end'] ."'";
            } elseif (!empty($data['price_start'])) {
                $criteria[] = " p.price >= '". (float)$data['price_start'] ."'";
            } elseif (!empty($data['price_end'])) {
                $criteria[] = " p.price <= '". (float)$data['price_end'] ."'";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }
            $sql .= " GROUP BY p2c.category_id";
    		$query = $this->db->query($sql);

   			$this->cache->set($cachedId,$query->rows);
    		return $query->rows;
        } else {
            return $this->cache->get($cachedId, $cache_prefix);
        }

    }

    public function getStoresByProduct($data) {
            $cache_prefix = "shop.searches.stores";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT DISTINCT s.store_id, s.name, s.folder, COUNT(*) AS total FROM " . DB_PREFIX . "product_to_store p2s
                LEFT JOIN " . DB_PREFIX . "store s ON (p2s.store_id = s.store_id)
                LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = p2s.product_id)
                LEFT JOIN " . DB_PREFIX . "product_description pd ON (pd.product_id = p2s.product_id) ";

            $search ="";
       	    $criteria   = array();
            $criteria[] = " p.status = '1'";
            $criteria[] = " p2s.store_id <> 0";
            $criteria[] = " p.date_available <= NOW()";
            $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

            if ($data['queries']) {
                foreach ($data['queries'] as $key => $value) {
                    if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                        $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                    $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                    $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                    $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                    $search .= " LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
                }
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
            if (!empty($data['category'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = p2c.category_id) ";
                $criteria[] = " LCASE(cd.name) = '" . $this->db->escape(strtolower($data['category'])) . "' ";
            }
            if (!empty($data['properties'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";
                foreach ($data['properties'] as $key => $value) {
                    $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' ";
                    $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                }
            }
            if (!empty($data['zone'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_zone p2z ON (p.product_id = p2z.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "zone z ON (z.zone_id = p2z.zone_id) ";
                $criteria[] = " LCASE(z.name) = '" . $this->db->escape(strtolower($data['zone'])) . "' ";
            }
            if (!empty($data['stock_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) ";
                $criteria[] = " ss.language_id = '". (int)$this->config->get('config_language_id') ."'";
                $criteria[] = " LCASE(ss.name) LIKE '%" . $this->db->escape($data['stock_status']) . "%' ";
            }
            if (!empty($data['seller'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "customer cu ON (p.owner_id = cu.customer_id) ";
                $criteria[] = " LCASE(cu.company) = '" . $this->db->escape(strtolower($data['seller'])) . "' ";
                $criteria[] = " cu.status = '1'";
            }
            if (!empty($data['manufacturer'])) {
                $criteria[] = " LCASE(m.name) LIKE '%" . $this->db->escape(strtolower($data['manufacturer'])) . "%' ";
            }
            if (!empty($data['shipping_method']) || !empty($data['payment_method']) || !empty($data['product_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";

                if (!empty($data['shipping_method'])) {
                    foreach ($data['shipping_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'shipping_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['payment_method'])) {
                    foreach ($data['payment_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'payment_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['product_status'])) {
                    foreach ($data['product_status'] as $key => $value) {
                        $criteria[] = " `group` = 'product_status' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }
            }

            if (!empty($data['date_start']) && !empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            } elseif (!empty($data['date_start'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND NOW()";
            } elseif (!empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN NOW() AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            }

            if (!empty($data['price_start']) && !empty($data['price_end'])) {
                $criteria[] = " p.price BETWEEN '". (float)$data['price_start'] ."' AND '". (float)$data['price_end'] ."'";
            } elseif (!empty($data['price_start'])) {
                $criteria[] = " p.price >= '". (float)$data['price_start'] ."'";
            } elseif (!empty($data['price_end'])) {
                $criteria[] = " p.price <= '". (float)$data['price_end'] ."'";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }
            $sql .= " GROUP BY p2s.store_id";
    		$query = $this->db->query($sql);

   			$this->cache->set($cachedId,$query->rows);
    		return $query->rows;
        } else {
            return $this->cache->get($cachedId, $cache_prefix);
        }

    }

    public function getZonesByProduct($data) {
        $cache_prefix = "shop.searches.zones";
        $cachedId = $cache_prefix.(int)STORE_ID ."_". implode('_',$data);

	   $cached = $this->cache->get($cachedId, $cache_prefix);
       if (!$cached) {
            $sql = "SELECT DISTINCT z.zone_id, z.name, COUNT(*) AS total FROM " . DB_PREFIX . "product_to_zone p2z
                LEFT JOIN " . DB_PREFIX . "zone z ON (p2z.zone_id = z.zone_id)
                LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = p2z.product_id)
                LEFT JOIN " . DB_PREFIX . "product_description pd ON (pd.product_id = p2z.product_id) ";

            $search = "";
   	        $criteria = array();

            $criteria[] = " p.status = '1'";
            $criteria[] = " p.date_available <= NOW()";
            $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

            if ($data['queries']) {
                foreach ($data['queries'] as $key => $value) {
                    if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                        $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                    $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                    $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                    $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                    $search .= " LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
                }
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
            if (!empty($data['category'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = p2c.category_id) ";
                $criteria[] = " LCASE(cd.name) = '" . $this->db->escape(strtolower($data['category'])) . "' ";
            }
            if (!empty($data['properties'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";
                foreach ($data['properties'] as $key => $value) {
                    $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' ";
                    $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                }
            }
            if (!empty($data['stock_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) ";
                $criteria[] = " ss.language_id = '". (int)$this->config->get('config_language_id') ."'";
                $criteria[] = " LCASE(ss.name) LIKE '%" . $this->db->escape($data['stock_status']) . "%' ";
            }
            if (!empty($data['seller'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "customer cu ON (p.owner_id = cu.customer_id) ";
                $criteria[] = " LCASE(cu.company) = '" . $this->db->escape(strtolower($data['seller'])) . "' ";
                $criteria[] = " cu.status = '1'";
            }
            if (!empty($data['manufacturer'])) {
                $criteria[] = " LCASE(m.name) LIKE '%" . $this->db->escape(strtolower($data['manufacturer'])) . "%' ";
            }
            if (!empty($data['store'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "store s ON (s.store_id = p2s.store_id) ";
                $criteria[] = " LCASE(s.name) = '" . $this->db->escape(strtolower($data['store'])) . "' ";
            }
            if (!empty($data['shipping_method']) || !empty($data['payment_method']) || !empty($data['product_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";

                if (!empty($data['shipping_method'])) {
                    foreach ($data['shipping_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'shipping_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['payment_method'])) {
                    foreach ($data['payment_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'payment_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['product_status'])) {
                    foreach ($data['product_status'] as $key => $value) {
                        $criteria[] = " `group` = 'product_status' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }
            }

            if (!empty($data['date_start']) && !empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            } elseif (!empty($data['date_start'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND NOW()";
            } elseif (!empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN NOW() AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            }

            if (!empty($data['price_start']) && !empty($data['price_end'])) {
                $criteria[] = " p.price BETWEEN '". (float)$data['price_start'] ."' AND '". (float)$data['price_end'] ."'";
            } elseif (!empty($data['price_start'])) {
                $criteria[] = " p.price >= '". (float)$data['price_start'] ."'";
            } elseif (!empty($data['price_end'])) {
                $criteria[] = " p.price <= '". (float)$data['price_end'] ."'";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }
            $sql .= " GROUP BY p2z.zone_id";
    		$query = $this->db->query($sql);

   			$this->cache->set($cachedId,$query->rows);
    		return $query->rows;
        } else {
            return $this->cache->get($cachedId, $cache_prefix);
        }

    }

    public function getManufacturersByProduct($data) {
            $cache_prefix = "shop.searches.manufacturers";
        $cachedId = $cache_prefix.
            (int)STORE_ID ."_".
            serialize($data).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $cache_prefix);
        if (!$cached) {
            $sql = "SELECT DISTINCT m.manufacturer_id, m.name, COUNT(*) AS total FROM " . DB_PREFIX . "product p
                LEFT JOIN " . DB_PREFIX . "manufacturer m ON (m.manufacturer_id = p.manufacturer_id)
                LEFT JOIN " . DB_PREFIX . "product_description pd ON (pd.product_id = p.product_id) ";

            $search ="";
   	        $criteria = array();

            $criteria[] = " p.status = '1'";
            $criteria[] = " p.manufacturer_id <> 0";
            $criteria[] = " p.date_available <= NOW()";
            $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

            if ($data['queries']) {
                foreach ($data['queries'] as $key => $value) {
                    if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                        $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                    $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                    $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                    $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                    $search .= " LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
                }
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
            if (!empty($data['category'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = p2c.category_id) ";
                $criteria[] = " LCASE(cd.name) = '" . $this->db->escape(strtolower($data['category'])) . "' ";
            }
            if (!empty($data['properties'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";
                foreach ($data['properties'] as $key => $value) {
                    $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' ";
                    $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                }
            }
            if (!empty($data['zone'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_zone p2z ON (p.product_id = p2z.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "zone z ON (z.zone_id = p2z.zone_id) ";
                $criteria[] = " LCASE(z.name) = '" . $this->db->escape(strtolower($data['zone'])) . "' ";
            }
            if (!empty($data['stock_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) ";
                $criteria[] = " ss.language_id = '". (int)$this->config->get('config_language_id') ."'";
                $criteria[] = " LCASE(ss.name) LIKE '%" . $this->db->escape($data['stock_status']) . "%' ";
            }
            if (!empty($data['seller'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "customer cu ON (p.owner_id = cu.customer_id) ";
                $criteria[] = " LCASE(cu.company) = '" . $this->db->escape(strtolower($data['seller'])) . "' ";
                $criteria[] = " cu.status = '1'";
            }
            if (!empty($data['store'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "store s ON (s.store_id = p2s.store_id) ";
                $criteria[] = " LCASE(s.name) = '" . $this->db->escape(strtolower($data['store'])) . "' ";
            }
            if (!empty($data['shipping_method']) || !empty($data['payment_method']) || !empty($data['product_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";

                if (!empty($data['shipping_method'])) {
                    foreach ($data['shipping_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'shipping_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['payment_method'])) {
                    foreach ($data['payment_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'payment_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['product_status'])) {
                    foreach ($data['product_status'] as $key => $value) {
                        $criteria[] = " `group` = 'product_status' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }
            }

            if (!empty($data['date_start']) && !empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            } elseif (!empty($data['date_start'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND NOW()";
            } elseif (!empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN NOW() AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            }

            if (!empty($data['price_start']) && !empty($data['price_end'])) {
                $criteria[] = " p.price BETWEEN '". (float)$data['price_start'] ."' AND '". (float)$data['price_end'] ."'";
            } elseif (!empty($data['price_start'])) {
                $criteria[] = " p.price >= '". (float)$data['price_start'] ."'";
            } elseif (!empty($data['price_end'])) {
                $criteria[] = " p.price <= '". (float)$data['price_end'] ."'";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }
            $sql .= " GROUP BY p.manufacturer_id";
    		$query = $this->db->query($sql);

   			$this->cache->set($cachedId,$query->rows);
    		return $query->rows;
        } else {
            return $this->cache->get($cachedId, $cache_prefix);
        }

    }

    public function getSellersByProduct($data) {
        $cache_prefix = "shop.searches.sellers";
        $cachedId = $cache_prefix. (int)STORE_ID ."_". implode('_',$data);

	   $cached = $this->cache->get($cachedId, $cache_prefix);
       if (!$cached) {
            $sql = "SELECT DISTINCT c.customer_id, c.company, COUNT(*) AS total FROM " . DB_PREFIX . "product p
                LEFT JOIN " . DB_PREFIX . "customer c ON (c.customer_id = p.owner_id)
                LEFT JOIN " . DB_PREFIX . "product_description pd ON (pd.product_id = p.product_id) ";

            $search ="";
   	        $criteria = array();

            $criteria[] = " p.status = '1'";
            $criteria[] = " p.owner_id <> 0";
            $criteria[] = " p.date_available <= NOW()";
            $criteria[] = " pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

            if ($data['queries']) {
                foreach ($data['queries'] as $key => $value) {
                    if ($value !== mb_convert_encoding( mb_convert_encoding($value, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                        $value = mb_convert_encoding($value, 'UTF-8', mb_detect_encoding($value));
                    $value = htmlentities($value, ENT_NOQUOTES, 'UTF-8');
                    $value = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $value);
                    $value = html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
                    $search .= " LCASE(pd.name) LIKE '%" . $this->db->escape(strtolower($value)) . "%' collate utf8_general_ci OR";
                }
                $criteria[] = " (". rtrim($search,'OR') .")";
            }
            if (!empty($data['category'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = p2c.category_id) ";
                $criteria[] = " LCASE(cd.name) = '" . $this->db->escape(strtolower($data['category'])) . "' ";
            }
            if (!empty($data['properties'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";
                foreach ($data['properties'] as $key => $value) {
                    $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' ";
                    $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                }
            }
            if (!empty($data['zone'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_zone p2z ON (p.product_id = p2z.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "zone z ON (z.zone_id = p2z.zone_id) ";
                $criteria[] = " LCASE(z.name) = '" . $this->db->escape(strtolower($data['zone'])) . "' ";
            }
            if (!empty($data['stock_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id) ";
                $criteria[] = " ss.language_id = '". (int)$this->config->get('config_language_id') ."'";
                $criteria[] = " LCASE(ss.name) LIKE '%" . $this->db->escape($data['stock_status']) . "%' ";
            }
            if (!empty($data['manufacturer'])) {
                $criteria[] = " LCASE(m.name) LIKE '%" . $this->db->escape(strtolower($data['manufacturer'])) . "%' ";
            }
            if (!empty($data['store'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) ";
                $sql .= " LEFT JOIN " . DB_PREFIX . "store s ON (s.store_id = p2s.store_id) ";
                $criteria[] = " LCASE(s.name) = '" . $this->db->escape(strtolower($data['store'])) . "' ";
            }
            if (!empty($data['shipping_method']) || !empty($data['payment_method']) || !empty($data['product_status'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_property pp ON (p.product_id = pp.product_id) ";

                if (!empty($data['shipping_method'])) {
                    foreach ($data['shipping_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'shipping_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['payment_method'])) {
                    foreach ($data['payment_methods'] as $key => $value) {
                        $criteria[] = " `group` = 'payment_methods' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }

                if (!empty($data['product_status'])) {
                    foreach ($data['product_status'] as $key => $value) {
                        $criteria[] = " `group` = 'product_status' ";
                        $criteria[] = " LCASE(pp.`key`) LIKE '%" . $this->db->escape(strtolower($value)) . "%' ";
                    }
                }
            }

            if (!empty($data['date_start']) && !empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            } elseif (!empty($data['date_start'])) {
                $criteria[] = " p.date_added BETWEEN '". date('Y-m-d',strtotime($data['date_start'])) ."' AND NOW()";
            } elseif (!empty($data['date_end'])) {
                $criteria[] = " p.date_added BETWEEN NOW() AND '". date('Y-m-d',strtotime($data['date_end'])) ."'";
            }

            if (!empty($data['price_start']) && !empty($data['price_end'])) {
                $criteria[] = " p.price BETWEEN '". (float)$data['price_start'] ."' AND '". (float)$data['price_end'] ."'";
            } elseif (!empty($data['price_start'])) {
                $criteria[] = " p.price >= '". (float)$data['price_start'] ."'";
            } elseif (!empty($data['price_end'])) {
                $criteria[] = " p.price <= '". (float)$data['price_end'] ."'";
            }

            if ($criteria) {
                $sql .= " WHERE " . implode(" AND ",$criteria);
            }
            $sql .= " GROUP BY p.owner_id";
    		$query = $this->db->query($sql);

   			$this->cache->set($cachedId,$query->rows);
    		return $query->rows;
        } else {
            return $this->cache->get($cachedId, $cache_prefix);
        }

    }

	public function getProductsByTag($tag, $category_id = 0, $sort = 'p.sort_order', $order = 'ASC', $start = 0, $limit = 20) {
		if ($tag) {

			$sql = "SELECT *, p.date_added AS created, pd.name AS name, p.image, m.name AS manufacturer, ss.name AS stock, (SELECT AVG(r.rating) FROM " . DB_PREFIX . "review r WHERE p.product_id = r.object_id AND `object_type` = 'product' GROUP BY r.object_id) AS rating
            FROM " . DB_PREFIX . "product p
                LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
                LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
                LEFT JOIN " . DB_PREFIX . "product_tags pt ON (p.product_id = pt.product_id)
                LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
                LEFT JOIN " . DB_PREFIX . "stock_status ss ON (p.stock_status_id = ss.stock_status_id)
            WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
                AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "'
                AND pt.language_id = '" . (int)$this->config->get('config_language_id') . "'
                AND p2s.store_id = '". (int)STORE_ID ."'
                AND (LCASE(pt.tag) = '" . $this->db->escape(strtolower($tag)) . "'";

			$keywords = explode(" ", $tag);

			foreach ($keywords as $keyword) {
				$sql .= " OR LCASE(pt.tag) = '" . $this->db->escape(strtolower($keyword)) . "'";
			}

			$sql .= ")";

			if ($category_id) {
				$data = array();

				$this->load->model('store/category');

				$string = rtrim($this->getPath($category_id), ',');

				foreach (explode(',', $string) as $category_id) {
					$data[] = "category_id = '" . (int)$category_id . "'";
				}

				$sql .= " AND p.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE " . implode(" OR ", $data) . ")";
			}

			$sql .= " AND p.status = '1' AND p.date_available <= NOW() GROUP BY p.product_id";

			$sort_data = array(
				'pd.name',
				'p.sort_order',
				'special',
				'rating'
			);

			if (in_array($sort, $sort_data)) {
				if ($sort == 'pd.name') {
					$sql .= " ORDER BY LCASE(" . $sort . ")";
				} else {
					$sql .= " ORDER BY " . $sort;
				}
			} else {
				$sql .= " ORDER BY p.sort_order";
			}

			if ($order == 'DESC') {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if ($start < 0) {
				$start = 0;
			}

			$sql .= " LIMIT " . (int)$start . "," . (int)$limit;

			$query = $this->db->query($sql);

			$products = array();

			foreach ($query->rows as $key => $value) {
				$products[$value['product_id']] = $this->getProduct($value['product_id']);
			}

			return $products;
		}
	}


    public function getPath($category_id) {
        $string = $category_id . ',';
        $results = $this->modelCategory->getCategories($category_id);
        foreach ($results as $result) {
            $string .= $this->getPath($result['category_id']);
        }

        return $string;
    }

}