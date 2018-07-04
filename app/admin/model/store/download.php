<?php
/**
 * ModelStoreDownload
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 */
class ModelStoreDownload extends Model {
	/**
	 * ModelStoreDownload::add()
	 * 
	 * @param mixed $data
	 * @return void
	 */
	public function add($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "download SET ".
      		"`remaining`  = '" . (int)$data['remaining'] . "', ".
      		"date_added = NOW()");

      	$download_id = $this->db->getLastId(); 

      	if (isset($data['download'])) {
        	$this->db->query("UPDATE " . DB_PREFIX . "download SET ".
            "`filename`   = '" . $this->db->escape($data['download']) . "', ".
            "`mask`       = '" . $this->db->escape($data['mask']) . "' ".
            "WHERE download_id = '" . (int)$download_id . "'");
      	}

        $this->setDescriptions($download_id, $data['download_description']);

            foreach ($data['stores'] as $store) {
        		$this->db->query("INSERT INTO " . DB_PREFIX . "download_to_store SET ".
                "store_id    = '". intval($store) ."', ".
                "download_id = '". intval($download_id) ."'");
            }
        
        
        return $download_id;
	}
	
	/**
	 * ModelStoreDownload::editDownload()
	 * 
	 * @param int $download_id
	 * @param mixed $data
	 * @return void
	 */
	public function update($download_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "download SET ".
            "`remaining` = '" . (int)$data['remaining'] . "' ".
            "WHERE download_id = '" . (int)$download_id . "'");
      	
		if (isset($data['download'])) {
        	$this->db->query("UPDATE " . DB_PREFIX . "download SET ".
        		"`filename` = '" . $this->db->escape($data['download']) . "', ".
        		"`mask` = '" . $this->db->escape($data['mask']) . "' ".
        		"WHERE download_id = '" . (int)$download_id . "'");
      	}
		
		if (isset($data['update'])) {
        	$query = $this->db->query("SELECT filename from " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "'");
     		$filename = $query->row['filename'];
      		$this->db->query("UPDATE " . DB_PREFIX . "order_download SET ".
      			"`filename` = '" . $this->db->escape($data['download']) . "', ".
      			"`mask` = '" . $this->db->escape(basename($data['mask'])) . "' ".
      			"WHERE `filename` = '" . $this->db->escape($filename) . "'");
      	}
		
        $this->setDescriptions($download_id, $data['download_description']);        
	}
	
	/**
	 * ModelStoreProduct::copy()
	 * 
	 * @param int $product_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function copy($download_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download d 
        LEFT JOIN " . DB_PREFIX . "description dd ON (d.download_id = dd.object_id) 
        WHERE d.download_id = '" . (int)$download_id . "' 
        AND object_type = 'download' 
        AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
		
		if ($query->num_rows) {
			$data = array();
			$data = $query->row;
			$data['download'] = $data['filename'];
			$data = array_merge($data, array('download_description' => $this->getDescriptions($download_id)));
			$this->add($data);
		}
	}
	
	/**
	 * ModelContentPost::delete()
	 * 
	 * @param int $post_id
     * @see DB
     * @see Cache
	 * @return void
	 */
	public function delete($download_id) {
        $shared_tables = array(
            'property',
            'description',
            'stat',
            'url_alias',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id = '" . (int) $download_id . "' ".
                "AND object_type = 'download'");
        }

		$this->db->query("DELETE FROM " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "download_to_store WHERE download_id = '" . (int)$download_id . "'");
		$this->cache->delete("download");
	}	

	public function getStores($id) {
		$data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download_to_store WHERE download_id = '" . (int)$id . "'");
		foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
		}
		return $data;
	}	
	
    public function getById($id) {
        $result = $this->getAll(array(
            'download_id'=>$id,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.downloads";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "download t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'td.title',
                    'remaining',
                    't.date_added'
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
        $cache_prefix = "admin.downloads.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "download t ";
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

        $sql .= "LEFT JOIN " . DB_PREFIX . "description td ON (t.download_id = td.object_id) ";
        $criteria[] = " td.object_type = 'download' ";

        $data['download_id'] = !is_array($data['download_id']) && !empty($data['download_id']) ? array($data['download_id']) : $data['download_id'];
        $data['product_id'] = !is_array($data['product_id']) && !empty($data['product_id']) ? array($data['product_id']) : $data['product_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "download_to_store t2s ON (t.download_id = t2s.download_id) ";
            $criteria[] = " t2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['product_id']) && !empty($data['product_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "product_to_download p2d ON (t.download_id = p2d.download_id) ";
            $criteria[] = " p2d.product_id IN (" . implode(', ', $data['product_id']) . ") ";
        }

        if (isset($data['download_id']) && !empty($data['download_id'])) {
            $criteria[] = " t.download_id IN (" . implode(', ', $data['download_id']) . ") ";
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

        if (isset($data['filename']) && !empty($data['filename'])) {
            $criteria[] = " LCASE(t.`filename`) LIKE '%" . $this->db->escape(strtolower($data['filename'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['mask']) && !empty($data['mask'])) {
            $criteria[] = " LCASE(t.`mask`) LIKE '%" . $this->db->escape(strtolower($data['mask'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (t.download_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'download' ";
            }
        }

        if (!empty($data['date_start']) && !empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape($data['date_end']) ."'";
        } elseif (!empty($data['date_start']) && empty($data['date_end'])) {
            $criteria[] = " t.date_added BETWEEN '". $this->db->escape($data['date_start']) ."' AND '". $this->db->escape(date('Y-m-d h:i:s')) ."'";
        }

        if ($criteria) {
            $sql .= " WHERE " . implode(" AND ",$criteria);
        }

        if (!$countAsTotal) {
            if (isset($sort_data)) {
                $sql .= " GROUP BY t.download_id";
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

    public function activate($id) {
        return $this->__activate('download', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('download', $id);
    }
    
    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('download', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('download', $id, $data);
    }

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('download', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('download', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('download', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('download', $id, $group);
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
