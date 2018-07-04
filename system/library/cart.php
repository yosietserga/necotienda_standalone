<?php

final class Cart
{
    public function __construct($registry)
    {
        $this->config = $registry->get('config');
        $this->customer = $registry->get('customer');
        $this->session = $registry->get('session');
        $this->db = $registry->get('db');
        $this->tax = $registry->get('tax');
        $this->weight = $registry->get('weight');

        if (!$this->session->has('cart') || !is_array($this->session->get('cart'))) {
            $this->session->set('cart', array());
        }
    }

    public function getProducts($data=null)
    {
        $product_data = array();

        if (isset($data['start'])) {
            $a = $this->session->get('cart');
            $limit = abs($data['limit'] - count($a));
            $results = array_slice($a, $data['start'], $limit, true);
        } else {
            $results = $this->session->get('cart');
        }

        foreach ($results as $key => $value) {
            $array = explode(':', $key);
            $product_id = $array[0];
            $quantity = $value;
            $stock = true;

            if (isset($array[1])) {
                $options = explode('.', $array[1]);
            } else {
                $options = array();
            }

            $product_query = $this->db->query("SELECT *, wcd.unit AS weight_class, mcd.unit AS length_class
              FROM " . DB_PREFIX . "product p 
                  LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) 
                  LEFT JOIN " . DB_PREFIX . "weight_class wc ON (p.weight_class_id = wc.weight_class_id) 
                  LEFT JOIN " . DB_PREFIX . "weight_class_description wcd ON (wc.weight_class_id = wcd.weight_class_id) 
                  LEFT JOIN " . DB_PREFIX . "length_class mc ON (p.length_class_id = mc.length_class_id) 
                  LEFT JOIN " . DB_PREFIX . "length_class_description mcd ON (mc.length_class_id = mcd.length_class_id) 
              WHERE p.product_id = '" . (int)$product_id . "' 
                  AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
                  AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
                  AND p.date_available <= NOW() 
                  AND p.status = '1'");

            if ($product_query->num_rows) {
                $option_price = 0;

                $option_data = array();

                foreach ($options as $product_option_value_id) {
                    $option_value_query = $this->db->query("SELECT pov.product_option_id, povd.name, pov.price, pov.quantity, pov.subtract, pov.prefix
                     FROM " . DB_PREFIX . "product_option_value pov 
                        LEFT JOIN " . DB_PREFIX . "product_option_value_description povd ON (pov.product_option_value_id = povd.product_option_value_id) 
                     WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' 
                         AND pov.product_id = '" . (int)$product_id . "' 
                         AND povd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
                     ORDER BY pov.sort_order");

                    if ($option_value_query->num_rows) {
                        $option_query = $this->db->query("SELECT pod.name
                        FROM " . DB_PREFIX . "product_option po 
                            LEFT JOIN " . DB_PREFIX . "product_option_description pod ON (po.product_option_id = pod.product_option_id) 
                        WHERE po.product_option_id = '" . (int)$option_value_query->row['product_option_id'] . "' 
                            AND po.product_id = '" . (int)$product_id . "' 
                            AND pod.language_id = '" . (int)$this->config->get('config_language_id') . "' 
                        ORDER BY po.sort_order");

                        if ($option_value_query->row['prefix'] == '+') {
                            $option_price = $option_price + $option_value_query->row['price'];
                        } elseif ($option_value_query->row['prefix'] == '-') {
                            $option_price = $option_price - $option_value_query->row['price'];
                        }

                        $option_data[] = array(
                            'product_option_value_id' => $product_option_value_id,
                            'name' => $option_query->row['name'],
                            'value' => $option_value_query->row['name'],
                            'prefix' => $option_value_query->row['prefix'],
                            'price' => $option_value_query->row['price']
                        );

                        if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
                            $stock = false;
                        }
                    }
                }

                if ($this->customer->isLogged()) {
                    $customer_group_id = $this->customer->getCustomerGroupId();
                } else {
                    $customer_group_id = $this->config->get('config_customer_group_id');
                }

                $discount_quantity = 0;
                foreach ($this->session->get('cart') as $k => $v) {
                    $array2 = explode(':', $k);
                    if ($array2[0] == $product_id) {
                        $discount_quantity += $v;
                    }
                }

                $product_discount_query = $this->db->query("SELECT price
                FROM " . DB_PREFIX . "product_discount 
                WHERE product_id = '" . (int)$product_id . "' 
                    AND customer_group_id = '" . (int)$customer_group_id . "' 
                    AND quantity <= '" . (int)$discount_quantity . "' 
                    AND ((date_start = '0000-00-00' OR date_start < NOW()) 
                    AND (date_end = '0000-00-00' OR date_end> NOW())) 
                ORDER BY quantity DESC, priority ASC, price ASC 
                LIMIT 1");

                if ($product_discount_query->num_rows) {
                    $price = $product_discount_query->row['price'];
                } else {
                    $product_special_query = $this->db->query("SELECT price
                    FROM " . DB_PREFIX . "product_special 
                    WHERE product_id = '" . (int)$product_id . "' 
                        AND customer_group_id = '" . (int)$customer_group_id . "' 
                        AND ((date_start = '0000-00-00' OR date_start < NOW()) 
                        AND (date_end = '0000-00-00' OR date_end> NOW())) 
                    ORDER BY priority ASC, price ASC 
                    LIMIT 1");

                    if ($product_special_query->num_rows) {
                        $price = $product_special_query->row['price'];
                    } else {
                        $price = $product_query->row['price'];
                    }
                }

                $download_data = array();

                $download_query = $this->db->query("SELECT *
                FROM " . DB_PREFIX . "product_to_download p2d 
                    LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) 
                    LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) 
                WHERE p2d.product_id = '" . (int)$product_id . "' 
                    AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                foreach ($download_query->rows as $download) {
                    $download_data[] = array(
                        'download_id' => $download['download_id'],
                        'name' => $download['name'],
                        'filename' => $download['filename'],
                        'mask' => $download['mask'],
                        'remaining' => $download['remaining']
                    );
                }

                if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity)) {
                    $stock = false;
                }
                $attributes = $this->getAllProductProperties($product_query->row['product_id'], 'attribute');
                $product_data[$key] = array(
                    'key' => $key,
                    'product_id' => $product_query->row['product_id'],
                    'name' => $product_query->row['name'],
                    'model' => $product_query->row['model'],
                    'shipping' => $product_query->row['shipping'],
                    'image' => $product_query->row['image'],
                    'option' => $option_data,
                    'attributes' => $attributes,
                    'download' => $download_data,
                    'quantity' => $quantity,
                    'minimum' => $product_query->row['minimum'],
                    'stock' => $stock,
                    'price' => ($price + $option_price),
                    'total' => ($price + $option_price) * $quantity,
                    'tax_class_id' => $product_query->row['tax_class_id'],
                    'weight' => $product_query->row['weight'],
                    'weight_class' => $product_query->row['weight_class'],
                    'length' => $product_query->row['length'],
                    'width' => $product_query->row['width'],
                    'height' => $product_query->row['height'],
                    'length_class' => $product_query->row['length_class']
                );
            } else {
                $this->remove($key);
            }
        }

        return $product_data;
    }

    public function add($product_id, $qty = 1, $options = array())
    {
        if (!$options) {
            $key = $product_id;
        } else {
            $key = $product_id . ':' . implode('.', $options);
        }

        //TODO: Acomodar el metodo session->set para aceptar subkeys o reescribir este bloque de c�digo
        //TODO: agregar actividad del carrito en bd para CRM 
        if ((int)$qty && ((int)$qty > 0)) {
            if (!$this->session->has('cart', $key)) {
                $this->session->data[C_CODE . "_" . 'cart'][$key] = (int)$qty;
            } else {
                $this->session->data[C_CODE . "_" . 'cart'][$key] += (int)$qty;
            }
        }
        $this->setMinQty();
    }

    public function update($key, $qty)
    {
        if ((int)$qty && ((int)$qty > 0)) {
            $this->session->data[C_CODE . "_" . 'cart'][$key] = (int)$qty;
        } else {
            $this->remove($key);
        }
        //TODO: agregar actividad del carrito en bd para CRM 
        $this->setMinQty();
    }

    public function remove($key)
    {
        if ($this->session->has('cart', $key)) {
            $this->session->clear('cart', $key);
        }
    }

    public function clear()
    {
        $this->session->set('cart', array());
    }

    public function getWeight()
    {
        $weight = 0;

        foreach ($this->getProducts() as $product) {
            if ($product['shipping']) {
                $weight += $this->weight->convert($product['weight'] * $product['quantity'], $product['weight_class'], $this->config->get('config_weight_class'));
            }
        }

        return $weight;
    }

    public function setMinQty()
    {
        foreach ($this->getProducts() as $product) {
            if ($product['quantity'] < $product['minimum']) {
                $this->session->data[C_CODE . "_" . 'cart'][$product['key']] = $product['minimum'];
            }
        }
    }

    public function getSubTotal()
    {
        $total = 0;

        foreach ($this->getProducts() as $product) {
            $total += $product['total'];
        }

        return $total;
    }

    public function getTaxes()
    {
        $taxes = array();

        foreach ($this->getProducts() as $product) {
            if ($product['tax_class_id']) {
                if (!isset($taxes[$product['tax_class_id']])) {
                    $taxes[$product['tax_class_id']] = $product['total'] / 100 * $this->tax->getRate($product['tax_class_id']);
                } else {
                    $taxes[$product['tax_class_id']] += $product['total'] / 100 * $this->tax->getRate($product['tax_class_id']);
                }
            }
        }

        return $taxes;
    }

    public function getTotal()
    {
        $total = 0;

        foreach ($this->getProducts() as $product) {
            $total += $this->tax->calculate($product['total'], $product['tax_class_id'], $this->config->get('config_tax'));
        }

        return $total;
    }

    public function countProducts()
    {
        return array_sum($this->session->data[C_CODE . "_" . 'cart']);
    }

    public function hasProducts()
    {
        return count($this->session->data[C_CODE . "_" . 'cart']);
    }

    public function hasStock()
    {
        $stock = true;

        foreach ($this->getProducts() as $product) {
            if (!$product['stock']) {
                $stock = false;
            }
        }

        return $stock;
    }

    public function hasShipping()
    {
        $shipping = false;

        foreach ($this->getProducts() as $product) {
            if ($product['shipping']) {
                $shipping = true;
                break;
            }
        }

        return $shipping;
    }

    public function hasDownload()
    {
        $download = false;

        foreach ($this->getProducts() as $product) {
            if ($product['download']) {
                $download = true;

                break;
            }
        }

        return $download;
    }

    /**
     * ModelContentPage::getProperty()
     *
     * Obtener una propiedad del producto
     *
     * @param int $id product_id
     * @param varchar $group
     * @param varchar $key
     * @return mixed value of property
     * */
    public function getProductProperty($id, $group, $key) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_property
        WHERE `product_id` = '" . (int) $id . "'
        AND `group` = '" . $this->db->escape($group) . "'
        AND `key` = '" . $this->db->escape($key) . "'");

        return unserialize(str_replace("\'", "'", $query->row['value']));
    }

    /**
     * ModelContentPage::getAllProperties()
     *
     * Obtiene todas las propiedades del producto
     *
     * Si quiere obtener todos los grupos de propiedades
     * utilice * como nombre del grupo, ejemplo:
     *
     * $properties = getAllProperties($product_id, '*');
     *
     * Sino coloque el nombre del grupo de las propiedades
     *
     * $properties = getAllProperties($product_id, 'NombreDelGrupo');
     *
     * @param int $id product_id
     * @param varchar $group
     * @return array all properties
     * */
    public function getAllProductProperties($id, $group = '*') {
        if ($group == '*') {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_property
            WHERE `product_id` = '" . (int) $id . "'");
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_property
            WHERE `product_id` = '" . (int) $id . "'
            AND `group` = '" . $this->db->escape($group) . "'");
        }

        return $query->rows;
    }

}
