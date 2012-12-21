<?php
class NecoWidget { 
    /**
     * @param $user_banned
     * Utilizado para saber cuando usuario está bloqueado
     * */
    private $user_banned = false;
    
    private $db;
    private $user;
    private $resgistry;
    private $widgets;
    private $data = array();
    private $result = array();
    
    

    //TODO: construir un mapa de todas las funciones llamables a través de ajax
    public function __construct($registry,$route=null,$app='store') {
  	 
  	 /**
      * 1. cargar todos los widgets {precargar los widgets en cache}
      * 2. almacenar los widgets en una variable pública
      * 3. 
      * 
      * */
      
        $this->landing_page = $route;
        $this->app = $app;
        $this->registry = $registry;
        $this->config = $this->registry->get('config');
        $this->cache = $this->registry->get('cache');
        $this->db = $this->registry->get('db');
        $this->ip = $_SERVER['REMOTE_ADDR'];
        
  	}
    
    public function getWidgets($position=null) {
        if (!$position) {
            $cacheId = 'widgets.'.str_replace("/",".",$this->landing_page).'.'.$this->config->get('config_language_id').'.'.$this->config->get('config_currency');
            //if (!($this->widgets = $this->cache->get($cacheId))) {
                $widgets = $this->db->query("SELECT * 
                FROM `" . DB_PREFIX . "widget` w 
                WHERE w.`status` = 1
                AND w.`landing_page` = '". $this->db->escape($this->landing_page)."'
                AND w.`app` = '". $this->db->escape($this->app)."'");
            //}
        } else {
            $cacheId = 'widgets.'.str_replace("/",".",$this->landing_page).'.'.$position.'.'.$this->config->get('config_language_id').'.'.$this->config->get('config_currency');
            //if (!($this->widgets = $this->cache->get($cacheId))) {
                $widgets = $this->db->query("SELECT * 
                FROM `" . DB_PREFIX . "widget` w 
                WHERE w.`status` = 1
                AND w.`position` = '". $this->db->escape($position)."'
                AND w.`landing_page` = '". $this->db->escape($this->landing_page)."'");
            //}
        }
        $this->widgets = $widgets->rows;
        $this->cache->set($cacheId,$this->widgets);
        return isset($this->widgets) ? $this->widgets : null;
    }
    
    public function __get($key) {
        return $this->data[$key];
    }
    
    public function __set($key,$value) {
        $this->data[$key] = $value;
    }
    
    public function __isset($key) {
        return isset($this->data[$key]);
    }
}
