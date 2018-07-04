<?php

class NecoWidget {

    /**
     * @param $user_banned
     * Utilizado para saber cuando usuario est� bloqueado
     * */
    private $user_banned = false;
    private $db;
    private $user;
    private $resgistry;
    private $widgets;
    private $data = array();
    private $result = array();

    //TODO: construir un mapa de todas las funciones llamables a trav�s de ajax
    public function __construct($registry, $route = "all", $app = 'shop') {

        /**
         * 1. cargar todos los widgets {precargar los widgets en cache}
         * 2. almacenar los widgets en una variable p�blica
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

    public function getRoutes() {
        $routes['text_home'] = 'common/home';
        $routes['text_account_login'] = 'account/login';
        $routes['text_account_register'] = 'account/register';
        $routes['text_account_forgotten'] = 'account/forgotten';
        $routes['text_account_success'] = 'account/success';
        $routes['text_cart_success'] = 'checkout/success';
        $routes['text_cart'] = 'checkout/cart';
        $routes['text_bestseller'] = 'store/bestseller';
        $routes['text_manufacturer'] = 'store/manufacturer';
        $routes['text_manufacturers'] = 'store/manufacturer/all';
        $routes['text_category'] = 'store/category';
        $routes['text_categories'] = 'store/category/all';
        $routes['text_product'] = 'store/product';
        $routes['text_products'] = 'store/product/all';
        $routes['text_search'] = 'store/search';
        $routes['text_special'] = 'store/special';
        //$routes['text_pages'] = 'content/page/all';
        $routes['text_page'] = 'content/page';
        $routes['text_post_category'] = 'content/category';
        $routes['text_post_categories'] = 'content/category/all';
        $routes['text_post'] = 'content/post';
        $routes['text_posts'] = 'content/post/all';
        $routes['text_sitemap'] = 'page/sitemap';
        $routes['text_contact'] = 'page/contact';

        $routes['text_account_account'] = 'account/account';
        $routes['text_account_address'] = 'account/address';
        $routes['text_account_address'] = 'account/address/insert';
        $routes['text_account_address'] = 'account/address/update';
        $routes['text_account_balance'] = 'account/balance';
        $routes['text_account_download'] = 'account/download';
        $routes['text_account_edit'] = 'account/edit';
        $routes['text_account_forgotten'] = 'account/forgotten';
        $routes['text_account_history'] = 'account/history';
        $routes['text_account_invoice'] = 'account/invoice';
        $routes['text_account_login'] = 'account/login';
        $routes['text_account_logout'] = 'account/logout';
        $routes['text_account_message'] = 'account/message';
        $routes['text_account_newsletter'] = 'account/newsletter';
        $routes['text_account_order'] = 'account/order';
        $routes['text_account_password'] = 'account/password';
        $routes['text_account_payment'] = 'account/payment';
        $routes['text_account_register'] = 'account/register';
        $routes['text_account_review'] = 'account/review';
        $routes['text_account_success'] = 'account/success';
        return $routes;
    }

    public function getWidget($name) {
        $prefix = "widgets.widget.".$name;

        $cachedId = $prefix .'.'.
            (int)STORE_ID ."_".
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $prefix);
        if (!$cached) {
            $sql = "SELECT * FROM `" . DB_PREFIX . "widget` w ";

            $criteria[] = " w.`name` = '" . $this->db->escape($name) . "' ";

            if (isset($criteria)) {
                $sql .= " WHERE " . implode(" AND ", $criteria);
            }

            $q = $this->db->query($sql);

            $this->cache->set($cachedId, $q->row, $prefix);
            return $q->row;
        } else {
            return $cached;
        }
    }

    public function getWidgets($position = array()) {
        $data = is_array($position) ? $position : array('position' => $position);

        $data['landing_page'] = isset($data['landing_page']) ? $data['landing_page'] : $this->landing_page;
        $data['app'] = isset($data['app']) ? $data['app'] : $this->app;
        $data['object_type'] = isset($data['object_type']) ? $data['object_type'] : $this->object_type;
        $data['object_id'] = isset($data['object_id']) ? $data['object_id'] : $this->object_id;

        $prefix = "widgets.widgets.".
            $data['app'] .'.'.
            $data['position'] .'.'.
            $data['landing_page'] .'.'.
            $data['object_type'] .'.'.
            $data['object_id'];

        $cachedId = $prefix .'.'.
            (int)STORE_ID ."_".
            serialize($data).
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $prefix);
        if (!$cached) {
            $sql = "SELECT * FROM `" . DB_PREFIX . "widget` w ";

            $position = isset($data['position']) && !empty($data['position']) ? $data['position'] : "main";

            $criteria[] = " w.`position` = '" . $this->db->escape($position) . "' ";
            $criteria[] = " w.`store_id` = '" . (int)STORE_ID . "' ";
            $criteria[] = " w.`app` = '" . $this->db->escape($this->app) . "' ";

            if (isset($data['row_id']) && !empty($data['row_id'])) {
                $criteria[] = " `settings` LIKE '%" . $this->db->escape($data['row_id']) . "%' ";
            }

            if (isset($data['col_id']) && !empty($data['col_id'])) {
                $criteria[] = " `settings` LIKE '%" . $this->db->escape($data['col_id']) . "%' ";
            }

            if (isset($data['show_in_mobile']) && !empty($data['show_in_mobile'])) {
                $criteria[] = " `settings` LIKE '%showonmobile%' ";
            }

            if (isset($data['show_in_desktop']) && !empty($data['show_in_desktop'])) {
                $criteria[] = " `settings` LIKE '%showondesktop%' ";
            }

            if (isset($data['async']) && !empty($data['async'])) {
                $criteria[] = " `settings` LIKE '%async=on%' ";
            }

            $lp = " (`settings` LIKE '%landing_page=all%' ";
            if (isset($data['landing_page']) && !empty($data['landing_page'])) {
                $lp .= " OR `settings` LIKE '%landing_page=" . $this->db->escape($data['landing_page']) . "%' ";
            }
            $lp .= ")";
            $criteria[] = $lp;

            if (isset($data['object_type']) && !empty($data['object_type'])) {
                $criteria[] = " `settings` LIKE '%object_type=" . $this->db->escape($data['object_type']) . "%' ";
            } else {
                $criteria[] = " `settings` NOT LIKE '%object_type%' ";
            }

            if (isset($data['object_type']) && !empty($data['object_type']) && isset($data['object_id']) && !empty($data['object_id'])) {
                $criteria[] = " `settings` LIKE '%object_id=" . intval($data['object_id']) . "%' ";
            } else {
                $criteria[] = " `settings` NOT LIKE '%object_id%' ";
            }

            if (isset($criteria)) {
                $sql .= " WHERE " . implode(" AND ", $criteria);
            }

            $sql .= " ORDER BY `order` ASC";

            $widgets = $this->db->query($sql);

            $this->widgets = $widgets->rows;
            $this->cache->set($cachedId, $this->widgets, $prefix);
            return $this->widgets;
        } else {
            return $cached;
        }
    }

    public function getRows($data) {
        $prefix = "widgets.rows.".
            $data['app'] .'.'.
            $data['position'] .'.'.
            $data['landing_page'] .'.'.
            $data['object_type'] .'.'.
            $data['object_id'];

        $cachedId = $prefix .".".
            (int)STORE_ID ."_".
            serialize($data).
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $prefix);
        if (!$cached) {
            $sql = "SELECT * FROM `" . DB_PREFIX . "property` p ";

            $data['object_type'] = isset($data['object_type']) ? $data['object_type'] : $this->object_type;
            $data['object_id'] = isset($data['object_id']) ? $data['object_id'] : $this->object_id;

            $criteria[] = " p.`object_type` = 'widget_rows' ";

            if (isset($data['position']) && !empty($data['position'])) {
                $criteria[] = " p.`group` = '" . $this->db->escape($data['position']) . "' ";
            }

            if (isset($data['row_id']) && !empty($data['row_id'])) {
                $criteria[] = " p.`key` = '" . $this->db->escape($data['row_id']) . "' ";
            }

            $lp = " (p.`value` LIKE '%landing_page=all%' ";
            if (isset($data['landing_page']) && !empty($data['landing_page'])) {
                $lp .= " OR p.`value` LIKE '%landing_page=" . $this->db->escape($data['landing_page']) . "%' ";
            }
            $lp .= ")";
            $criteria[] = $lp;

            if (isset($data['app']) && !empty($data['app'])) {
                $criteria[] = " p.`value` LIKE '%app=" . $this->db->escape($data['app']) . "%' ";
            }

            if (isset($data['show_in_mobile']) && !empty($data['show_in_mobile'])) {
                $criteria[] = " p.`value` LIKE '%show_in_mobile=on%' ";
            }

            if (isset($data['show_in_desktop']) && !empty($data['show_in_desktop'])) {
                $criteria[] = " p.`value` LIKE '%show_in_desktop=on%' ";
            }

            if (isset($data['async']) && !empty($data['async'])) {
                $criteria[] = " p.`value` LIKE '%async=on%' ";
            }

            if (isset($data['object_type']) && !empty($data['object_type'])) {
                $criteria[] = " p.`value` LIKE '%object_type=" . $this->db->escape($data['object_type']) . "%' ";
            } else {
                $criteria[] = " p.`value` NOT LIKE '%object_type%' ";
            }

            if (isset($data['object_type']) && !empty($data['object_type']) && isset($data['object_id']) && !empty($data['object_id'])) {
                $criteria[] = " p.`value` LIKE '%object_id=" . intval($data['object_id']) . "%' ";
            } else {
                $criteria[] = " p.`value` NOT LIKE '%object_id%' ";
            }

            if (isset($criteria)) {
                $sql .= " WHERE " . implode(" AND ", $criteria);
            }

            $sql .= " ORDER BY `order` ASC";

            $result = $this->db->query($sql);

            if (isset($data['full_tree'])) {
                foreach ($result->rows as $k => $row) {
                    $col_data = array();
                    $col_data['row_id'] = $row['key'];
                    if (isset($data['position']) && !empty($data['position'])) $col_data['position'] = $data['position'];
                    if (isset($data['store_id']) && !empty($data['store_id'])) $col_data['store_id'] = $data['store_id'];
                    if (isset($data['object_type']) && !empty($data['object_type'])) $col_data['object_type'] = $data['object_type'];
                    if (isset($data['object_id']) && !empty($data['object_id'])) $col_data['object_id'] = $data['object_id'];
                    if (isset($data['landing_page']) && !empty($data['landing_page'])) $col_data['landing_page'] = $data['landing_page'];
                    if (isset($data['app']) && !empty($data['app'])) $col_data['app'] = $data['app'];
                    if (isset($data['show_in_mobile']) && !empty($data['show_in_mobile'])) $col_data['show_in_mobile'] = $data['show_in_mobile'];
                    if (isset($data['show_in_desktop']) && !empty($data['show_in_desktop'])) $col_data['show_in_desktop'] = $data['show_in_desktop'];
                    if (isset($data['async']) && !empty($data['async'])) $col_data['async'] = $data['async'];
                    if (isset($data['full_tree'])) $col_data['full_tree'] = $data['full_tree'];

                    $result->rows[$k]['columns'] = $this->getCols($col_data);

                    $_children = $_widget = array();
                    foreach ($result->rows[$k]['columns'] as $col) {
                        foreach ($col['widgets'] as $w) {
                            $settings = (array)unserialize($w['settings']);
                            if ($settings['autoload']) {
                                $_children[$w['name']] = $settings['route'];
                                $_widget[$w['name']] = $w;
                            }
                        }
                        $result->rows[$k]['children'] = $_children;
                        $result->rows[$k]['widget'] = $_widget;
                    }
                }
            }

            $this->cache->set($cachedId, $result->rows, $prefix);
            return $result->rows;
        } else {
            return $cached;
        }
    }

    public function getCols($data) {
            $prefix = "widgets.cols.".
                $data['app'] .'.'.
                $data['position'] .'.'.
                $data['landing_page'] .'.'.
                $data['object_type'] .'.'.
                $data['object_id'];

        $cachedId = $prefix .".".
            (int)STORE_ID ."_".
            serialize($data).
            (int)$this->config->get('config_store_id');

        $cached = $this->cache->get($cachedId, $prefix);
        if (!$cached) {
            $sql = "SELECT * FROM `" . DB_PREFIX . "property` p ";

            $data['object_type'] = isset($data['object_type']) ? $data['object_type'] : $this->object_type;
            $data['object_id'] = isset($data['object_id']) ? $data['object_id'] : $this->object_id;

            $criteria[] = " p.`object_type` = 'widget_cols' ";

            if (isset($data['position']) && !empty($data['position'])) {
                $criteria[] = " p.`group` = '" . $this->db->escape($data['position']) . "' ";
            }

            if (isset($data['col_id']) && !empty($data['col_id'])) {
                $criteria[] = " p.`key` = '" . $this->db->escape($data['col_id']) . "' ";
            }

            if (isset($data['row_id']) && !empty($data['row_id'])) {
                $criteria[] = " p.`value` LIKE '%row_id=" . $this->db->escape($data['row_id']) . "%' ";
            }

            $lp = " (p.`value` LIKE '%landing_page=all%' ";
            if (isset($data['landing_page']) && !empty($data['landing_page'])) {
                $lp .= " OR p.`value` LIKE '%landing_page=" . $this->db->escape($data['landing_page']) . "%' ";
            }
            $lp .= ")";
            $criteria[] = $lp;

            if (isset($data['app']) && !empty($data['app'])) {
                $criteria[] = " p.`value` LIKE '%app=" . $this->db->escape($data['app']) . "%' ";
            }

            if (isset($data['show_in_mobile']) && !empty($data['show_in_mobile'])) {
                $criteria[] = " p.`value` LIKE '%show_in_mobile=on%' ";
            }

            if (isset($data['show_in_desktop']) && !empty($data['show_in_desktop'])) {
                $criteria[] = " p.`value` LIKE '%show_in_desktop=on%' ";
            }

            if (isset($data['async']) && !empty($data['async'])) {
                $criteria[] = " p.`value` LIKE '%async=on%' ";
            }

            if (isset($data['object_type']) && !empty($data['object_type'])) {
                $criteria[] = " p.`value` LIKE '%object_type=" . $this->db->escape($data['object_type']) . "%' ";
            } else {
                $criteria[] = " p.`value` NOT LIKE '%object_type%' ";
            }

            if (isset($data['object_type']) && !empty($data['object_type']) && isset($data['object_id']) && !empty($data['object_id'])) {
                $criteria[] = " p.`value` LIKE '%object_id=" . intval($data['object_id']) . "%' ";
            } else {
                $criteria[] = " p.`value` NOT LIKE '%object_id%' ";
            }

            if (isset($criteria)) {
                $sql .= " WHERE " . implode(" AND ", $criteria);
            }

            $sql .= " ORDER BY `order` ASC";

            $result = $this->db->query($sql);

            if (isset($data['full_tree'])) {
                foreach ($result->rows as $k => $col) {
                    $widget_data = array();
                    $widget_data['col_id'] = $col['key'];
                    if (isset($data['position']) && !empty($data['position'])) $widget_data['position'] = $data['position'];
                    if (isset($data['store_id']) && !empty($data['store_id'])) $widget_data['store_id'] = $data['store_id'];
                    if (isset($data['object_type']) && !empty($data['object_type'])) $widget_data['object_type'] = $data['object_type'];
                    if (isset($data['object_id']) && !empty($data['object_id'])) $widget_data['object_id'] = $data['object_id'];
                    if (isset($data['landing_page']) && !empty($data['landing_page'])) $widget_data['landing_page'] = $data['landing_page'];
                    if (isset($data['app']) && !empty($data['app'])) $widget_data['app'] = $data['app'];
                    if (isset($data['show_in_mobile']) && !empty($data['show_in_mobile'])) $widget_data['show_in_mobile'] = $data['show_in_mobile'];
                    if (isset($data['show_in_desktop']) && !empty($data['show_in_desktop'])) $widget_data['show_in_desktop'] = $data['show_in_desktop'];
                    if (isset($data['async']) && !empty($data['async'])) $widget_data['async'] = $data['async'];
                    if (isset($data['full_tree'])) $widget_data['full_tree'] = $data['full_tree'];

                    $result->rows[$k]['widgets'] = $this->getWidgets($widget_data);
                }
            }

            $this->cache->set($cachedId, $result->rows, $prefix);
            return $result->rows;
        } else {
            return $cached;
        }
    }

    public function save($data) {
        if (!isset($data['name']) && !isset($data['position']))
            return false;

        $result = $this->db->query("SELECT *,COUNT(*) AS total 
                FROM `" . DB_PREFIX . "widget` w 
                WHERE w.`name` = '" . $this->db->escape($data['name']) . "'");
        if ($result->row['total']) {
            $return = $this->db->query("UPDATE `" . DB_PREFIX . "widget` SET 
                `position` = '" . $this->db->escape($data['position']) . "',
                `order` = '" . intval($data['order']) . "',
                `status` = '1',
                `settings` = '" . $this->db->escape(serialize($data['settings'])) . "'
                WHERE `name` = '" . $this->db->escape($data['name']) . "'");
            if (!empty($data['landing_page'])) {
                $this->db->query("DELETE FROM " . DB_PREFIX . "widget_landing_page WHERE `widget_id` = '" . intval($result->row['widget_id']) . "'");
                foreach ($data['landing_page'] as $landing_page) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "widget_landing_page SET
                    `widget_id` = '" . intval($result->row['widget_id']) . "',
                    landing_page = '" . $this->db->escape($landing_page) . "'");
                }
            }
        } else {
            $return = $this->db->query("INSERT INTO `" . DB_PREFIX . "widget` SET 
                `name` = '" . $this->db->escape($data['name']) . "',
                `code` = '{%" . $this->db->escape($data['name']) . "%}',
                `position` = '" . $this->db->escape($data['position']) . "',
                `extension` = '" . $this->db->escape($data['extension']) . "',
                `app` = '" . $this->db->escape($data['app']) . "',
                `order` = '" . intval($data['order']) . "',
                `store_id` = '" . intval($data['store_id']) . "',
                `status` = '1',
                `settings` = '" . $this->db->escape(serialize($data['settings'])) . "'");
            $widget_id = $this->db->getLastId();

            $this->db->query("INSERT INTO `" . DB_PREFIX . "widget_landing_page` SET 
                `widget_id` = '" . intval($widget_id) . "',
                `landing_page` = '" . $this->db->escape($data['landing_page']) . "'");
        }

        $prefix = $data['app'] .'.'. $data['position'];
        $this->cache->delete("widgets.widgets.". $prefix);
        $this->cache->delete("widgets.rows.". $prefix);
        $this->cache->delete("widgets.cols.". $prefix);
        return $return;
    }

    public function saveRow($data) {
        if (!isset($data['row_id']) && !isset($data['position']))
            return false;

        $this->db->query("DELETE FROM `" . DB_PREFIX . "property` ".
            "WHERE `key` = '" . $this->db->escape($data['row_id']) . "' ".
            "AND `object_type` = 'widget_rows' ");

        $this->db->query("INSERT INTO `" . DB_PREFIX . "property` SET ".
            "`object_id` = '" . $this->db->escape(mt_rand(1,99999999)) . "',".
            "`object_type` = 'widget_rows',".
            "`group` = '" . $this->db->escape($data['position']) . "',".
            "`key` = '" . $this->db->escape($data['row_id']) . "',".
            "`order` = '" . intval($data['order']) . "',".
            "`value` = '" . str_replace("'","\'",$this->db->escape(serialize($data['settings']))) . "'");

        $prefix = $data['app'] .'.'. $data['position'];
        $this->cache->delete("widgets.rows.". $prefix);
    }

    public function saveCol($data) {
        if (!isset($data['row_id']) && !isset($data['col_id']) && !isset($data['position']))
            return false;

        $this->db->query("DELETE FROM `" . DB_PREFIX . "property` ".
                "WHERE `key` = '" . $this->db->escape($data['col_id']) . "' ".
                "AND `object_type` = 'widget_cols' ");

        $this->db->query("INSERT INTO `" . DB_PREFIX . "property` SET ".
            "`object_id` = '" . $this->db->escape(mt_rand(1,99999999)) . "',".
            "`object_type` = 'widget_cols',".
            "`group` = '" . $this->db->escape($data['position']) . "',".
            "`key` = '" . $this->db->escape($data['col_id']) . "',".
            "`order` = '" . intval($data['order']) . "',".
            "`value` = '" . str_replace("'","\'",$this->db->escape(serialize($data['settings']))) . "'");

        $prefix = $data['app'] .'.'. $data['position'];
        $this->cache->delete("widgets.rows.". $prefix);
        $this->cache->delete("widgets.cols.". $prefix);
    }

    public function __get($key) {
        return $this->data[$key];
    }

    public function __set($key, $value) {
        $this->data[$key] = $value;
    }

    public function __isset($key) {
        return isset($this->data[$key]);
    }

}
