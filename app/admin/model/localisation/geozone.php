<?php

class ModelLocalisationGeoZone extends Model {

    public function add($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "geo_zone SET 
            name = '" . $this->db->escape($data['name']) . "', 
            description = '" . $this->db->escape($data['description']) . "', 
            date_added = NOW()");

        $geo_zone_id = $this->db->getLastId();
        
        if (isset($data['zone_to_geo_zone'])) {
            foreach ($data['zone_to_geo_zone'] as $value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "zone_to_geo_zone SET 
                    country_id = '"  . (int)$value['country_id'] . "', 
                    zone_id = '"  . (int)$value['zone_id'] . "', 
                    geo_zone_id = '"  .(int)$geo_zone_id . "', 
                    date_added = NOW()");
            }
        }
        
        $this->cache->delete('geo_zone');
    }
    
    public function update($geo_zone_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "geo_zone SET 
            name = '" . $this->db->escape($data['name']) . "', 
            description = '" . $this->db->escape($data['description']) . "', 
            date_modified = NOW() 
            WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
        if (isset($data['zone_to_geo_zone'])) {
            foreach ($data['zone_to_geo_zone'] as $value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "zone_to_geo_zone SET 
                    country_id = '"  . (int)$value['country_id'] . "', 
                    zone_id = '"  . (int)$value['zone_id'] . "', 
                    geo_zone_id = '"  .(int)$geo_zone_id . "', 
                    date_added = NOW()");
            }
        }
        
        $this->cache->delete('geo_zone');
    }
    
    public function delete($geo_zone_id) {
        $shared_tables = array(
            'property',
            'stat',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id  = ". (int)$geo_zone_id ." ".
                "AND object_type = 'geo_zone'");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "geo_zone WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "zone_to_geo_zone WHERE zone_id = '" . (int)$geo_zone_id . "'");

        $this->cache->delete('geo_zone');
    }
    
    public function getZoneToGeoZones($geo_zone_id) {   
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$geo_zone_id . "'");
        
        return $query->rows;    
    }       

    public function getAllTotalByGeoZoneId($geo_zone_id) {
        return $this->getAllTotal(array(
            'geo_zone_id'=>$geo_zone_id
        ));
    }
    
    public function getAllTotalByCountryId($country_id) {
        return $this->getAllTotal(array(
            'country_id'=>$country_id
        ));
    }   
    
    public function getAllTotalByZoneId($zone_id) {
        return $this->getAllTotal(array(
            'zone_id'=>$zone_id
        ));
    }   

    public function getById($id) {
        $result = $this->getAll(array(
            'geo_zone_id'=>$id
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.geo_zones";
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
            $sql = "SELECT * FROM " . DB_PREFIX . "geo_zone t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    't.name',
                    'date_modified'
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
        $cache_prefix = "admin.geo_zones.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "geo_zone t ";
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

        $data['geo_zone_id'] = !is_array($data['geo_zone_id']) && !empty($data['geo_zone_id']) ? array($data['geo_zone_id']) : $data['geo_zone_id'];
        $data['zone_id'] = !is_array($data['zone_id']) && !empty($data['zone_id']) ? array($data['zone_id']) : $data['zone_id'];
        $data['country_id'] = !is_array($data['country_id']) && !empty($data['country_id']) ? array($data['country_id']) : $data['country_id'];

        if (isset($data['geo_zone_id']) && !empty($data['geo_zone_id'])) {
            $criteria[] = " t.geo_zone_id IN (" . implode(', ', $data['geo_zone_id']) . ") ";
        }

        if (isset($data['zone_id']) 
            || isset($data['zone'])
            || isset($data['country_id']) 
            || isset($data['country']) ) {
            $sql .= "LEFT JOIN ". DB_PREFIX . "zone_to_geo_zone t2 ON (t.geo_zone_id = t2.geo_zone_id) ";
        }

        if (isset($data['zone_id']) && !empty($data['zone_id'])) {
            $criteria[] = " t2.zone_id IN (" . implode(', ', $data['zone_id']) . ") ";
        }

        if (isset($data['country_id']) && !empty($data['country_id'])) {
            $criteria[] = " t2.country_id IN (" . implode(', ', $data['country_id']) . ") ";
        }

        if (isset($data['name']) && !empty($data['name'])) {
            $criteria[] = " LCASE(t.`name`) LIKE '%" . $this->db->escape(strtolower($data['name'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['zone']) && !empty($data['zone'])) {
            $sql .= "LEFT JOIN ". DB_PREFIX . "zone z ON (z.zone_id = t2.zone_id) ";
            $sql .= "LEFT JOIN ". DB_PREFIX . "description zd ON (z.zone_id = zd.object_id) ";
            $criteria[] = " zd.object_type = 'zone' ";
            $criteria[] = " LCASE(zd.`title`) LIKE '%" . $this->db->escape(strtolower($data['zone'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['country']) && !empty($data['country'])) {
            $sql .= "LEFT JOIN ". DB_PREFIX . "country c ON (c.country_id = t2.country_id) ";
            $sql .= "LEFT JOIN ". DB_PREFIX . "description cd ON (c.country_id = cd.object_id) ";
            $criteria[] = " cd.object_type = 'country' ";
            $criteria[] = " LCASE(cd.`title`) LIKE '%" . $this->db->escape(strtolower($data['zone'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property tp ON (t.currency_id = tp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(tp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(tp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " tp.object_type = 'geo_zone' ";
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
                $sql .= " GROUP BY t.geo_zone_id";
                $sql .= (in_array($data['sort'], $sort_data)) ? " ORDER BY " . $data['sort'] : " ORDER BY t.name";
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

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('geo_zone', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('geo_zone', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('geo_zone', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('geo_zone', $id, $group);
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
