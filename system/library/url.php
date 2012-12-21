<?php
class Url {
	private $url;
	private $ssl;
	private $db = null;
	
	public function __construct($url='', $ssl = '') {
		$this->url = $url;
		$this->ssl = $ssl;
	}

    static public function createUrl($route,$params=null,$connection= 'NONSSL',$base = null) {
        if (empty($route)) return false;
        if (isset($base)) {
            $url = $base . "index.php?r=" . $route;
        } else {
            $url = ($connection == 'SSL') ? HTTPS_HOME . "index.php?r=" . $route : HTTP_HOME . "index.php?r=" . $route;
        }
        
        if (isset($params)) {
            if (is_array($params)) {
                foreach ($params as $key => $value) {
                    if (empty($key)) continue;
                    $url .= "&" . trim($key) . "=" . trim($value);
                }
            } else {
                $url .= trim("&" . $params);
            }
        }
        
        return $url;
        //TODO: utilizar rewrite automaticamente
        
    }
    
    static public function createAdminUrl($route,$params=array()) {
        $params = is_array($params) ? array_merge(array('token'=>$_GET['token']),$params) : '&token='. $_GET['token'] . $params;
        return self::createUrl($route,$params,'NONSSL');
    }
    
    
	static public function rewrite($link) {
	       return $link;
	   if (isset($this->db)) {
    	    $url_data = parse_url(str_replace('&amp;', '&', $link));
    	    $url = ''; 
    	    $data = array();
    	    parse_str($url_data['query'], $data);
            foreach ($data as $key => $value) {
                if (($key == 'product_id') || ($key == 'manufacturer_id') || ($key == 'information_id')) {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");
                    if ($query->num_rows) {
        				$url .= '/' . $query->row['keyword'];
        				unset($data[$key]);
                    }					
    			} elseif ($key == 'path') {
    				$categories = explode('_', $value);
    				foreach ($categories as $category) {
    				    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");
    				    if ($query->num_rows) {
    					   $url .= '/' . $query->row['keyword'];
    					}							
    				}
    				unset($data[$key]);
    			}
            }
    		if ($url) {
                unset($data['r']);
    			$query = '';
    			if ($data) {
                    foreach ($data as $key => $value) {
    				    $query .= '&' . $key . '=' . $value;
                    }
    				if ($query) {
    				    $query = '?' . trim($query, '&');
    				}
    			}
                return $url_data['scheme'] . '://' . $url_data['host'] . (isset($url_data['port']) ? ':' . $url_data['port'] : '') . str_replace('/index.php', '', $url_data['path']) . $url . $query;
    		} else {
                return $link;
    		}	
	   } else {
	       return $link;
	   }	
	}
    
    static public function setDB ($db) {
        $this->db = $db;
    }
}
