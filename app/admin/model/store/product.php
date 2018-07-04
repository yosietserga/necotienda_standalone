<?php

/**
 * ModelStoreProduct
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Model
 */
class ModelStoreProduct extends Model {

    public function add($data) {
        if (empty($data['model'])) return false;

        $sql = "INSERT INTO " . DB_PREFIX . "product SET ";
        $sql .= "model = '" . $this->db->escape($data['model']) . "', ";

        if (isset($data['stock_status_id'])) $sql .= "stock_status_id = '" . (int)$data['stock_status_id'] . "', ";
        if (isset($data['weight_class_id'])) $sql .= "weight_class_id = '" . (int)$data['weight_class_id'] . "', ";
        if (isset($data['length_class_id'])) $sql .= "length_class_id = '" . (int)$data['length_class_id'] . "', ";
        if (isset($data['tax_class_id'])) $sql    .= "tax_class_id    = '" . (int)$data['tax_class_id'] . "', ";
        if (isset($data['manufacturer_id'])) $sql .= "manufacturer_id = '" . (int)$data['manufacturer_id'] . "', ";

        if (isset($data['sku'])) $sql .= "sku = '" . $this->db->escape($data['sku']) . "', ";
        if (isset($data['location'])) $sql .= "location = '" . $this->db->escape($data['location']) . "', ";
        if (isset($data['date_available'])) $sql .= "date_available = '" . $this->db->escape($data['date_available']) . "', ";

        if (isset($data['quantity'])) $sql   .= "quantity = '" . (int)$data['quantity'] . "', ";
        if (isset($data['minimum'])) $sql    .= "minimum  = '" . (int)$data['minimum'] . "', ";
        if (isset($data['subtract'])) $sql   .= "subtract = '" . (int)$data['subtract'] . "', ";
        if (isset($data['shipping'])) $sql   .= "shipping = '" . (int)$data['shipping'] . "', ";
        if (isset($data['status'])) $sql     .= "status   = '" . (int)$data['status'] . "', ";
        if (isset($data['sort_order'])) $sql .= "sort_order = '" . (int)$data['sort_order'] . "', ";

        if (isset($data['price'])) $sql  .= "price  = '" . (float)$data['price'] . "', ";
        if (isset($data['cost'])) $sql   .= "cost   = '" . (float)$data['cost'] . "', ";
        if (isset($data['weight'])) $sql .= "weight = '" . (float)$data['weight'] . "', ";
        if (isset($data['length'])) $sql .= "length = '" . (float)$data['length'] . "', ";
        if (isset($data['width'])) $sql  .= "width  = '" . (float)$data['width'] . "', ";
        if (isset($data['height'])) $sql .= "height = '" . (float)$data['height'] . "', ";

        $sql .= "date_added = NOW()";

        $this->db->query($sql);
        $product_id = $this->db->getLastId();

        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int) $product_id . "'");
        }

        if (isset($data['descriptions'])) 
            $this->setDescriptions($product_id, $data['descriptions']);

        if (isset($data['stores'])) 
            foreach ($data['stores'] as $store_id) {
                $this->setStore(array(
                    'product_id'=>$product_id,
                    'store_id'=>$store_id
                ));
            }

        if (isset($data['attributes'])) {
            $this->setAttributes(array(
                'product_id'=>$product_id,
                'Attributes'=>$data['attributes'],
            ));
        }

        if (isset($data['options'])) 
            foreach ($data['options'] as $product_option) {
                $product_option['product_id'] = $product_id;
                $this->setOption($product_option);
            }

        if (isset($data['discounts'])) 
            foreach ($data['discounts'] as $value) {
                $value['product_id'] = $product_id;
                $this->setDiscount($value);
            }

        if (isset($data['specials'])) 
            foreach ($data['specials'] as $value) {
                $value['product_id'] = $product_id;
                $this->setSpecial($value);
            }

        if (isset($data['images'])) 
            foreach ($data['images'] as $value) {
                $this->setImage(array(
                    'product_id'=>$product_id,
                    'image'=>$value
                ));
            }

        if (isset($data['downloads'])) 
            foreach ($data['downloads'] as $download_id) {
                $this->setDownload(array(
                    'product_id'=>$product_id,
                    'download_id'=>$download_id
                ));
            }
        
        if (isset($data['categories'])) 
            foreach ($data['categories'] as $category_id) {
                $this->setCategory(array(
                    'product_id'=>$product_id,
                    'category_id'=>$category_id
                ));
            }

        if (isset($data['related'])) 
            foreach ($data['related'] as $related_id) {
                $this->setRelated(array(
                    'product_id'=>$product_id,
                    'related_id'=>$related_id
                ));
            }

        $this->cache->delete('products');
        $this->cache->delete('product');

        return $product_id;
    }

    public function update($product_id, $data) {

        $sql = "UPDATE " . DB_PREFIX . "product SET ";

        if (isset($data['stock_status_id'])) $sql .= "stock_status_id = '" . (int)$data['stock_status_id'] . "', ";
        if (isset($data['weight_class_id'])) $sql .= "weight_class_id = '" . (int)$data['weight_class_id'] . "', ";
        if (isset($data['length_class_id'])) $sql .= "length_class_id = '" . (int)$data['length_class_id'] . "', ";
        if (isset($data['tax_class_id'])) $sql    .= "tax_class_id    = '" . (int)$data['tax_class_id'] . "', ";
        if (isset($data['manufacturer_id'])) $sql .= "manufacturer_id = '" . (int)$data['manufacturer_id'] . "', ";

        if (isset($data['model'])) $sql .= "model = '" . $this->db->escape($data['model']) . "', ";
        if (isset($data['sku'])) $sql .= "sku = '" . $this->db->escape($data['sku']) . "', ";
        if (isset($data['location'])) $sql .= "location = '" . $this->db->escape($data['location']) . "', ";
        if (isset($data['date_available'])) $sql .= "date_available = '" . $this->db->escape($data['date_available']) . "', ";

        if (isset($data['quantity'])) $sql   .= "quantity = '" . (int)$data['quantity'] . "', ";
        if (isset($data['minimum'])) $sql    .= "minimum  = '" . (int)$data['minimum'] . "', ";
        if (isset($data['subtract'])) $sql   .= "subtract = '" . (int)$data['subtract'] . "', ";
        if (isset($data['shipping'])) $sql   .= "shipping = '" . (int)$data['shipping'] . "', ";
        if (isset($data['status'])) $sql     .= "status   = '" . (int)$data['status'] . "', ";
        if (isset($data['sort_order'])) $sql .= "sort_order = '" . (int)$data['sort_order'] . "', ";

        if (isset($data['price'])) $sql  .= "price  = '" . (float)$data['price'] . "', ";
        if (isset($data['cost'])) $sql   .= "cost   = '" . (float)$data['cost'] . "', ";
        if (isset($data['weight'])) $sql .= "weight = '" . (float)$data['weight'] . "', ";
        if (isset($data['length'])) $sql .= "length = '" . (float)$data['length'] . "', ";
        if (isset($data['width'])) $sql  .= "width  = '" . (float)$data['width'] . "', ";
        if (isset($data['height'])) $sql .= "height = '" . (float)$data['height'] . "', ";

        $sql .= "date_modified = NOW() ";
        $sql .= "WHERE product_id = '" . (int) $product_id . "' ";

        $this->db->query($sql);

        if (isset($data['image'])) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET 
            image = '" . $this->db->escape($data['image']) . "' 
            WHERE product_id = '" . (int) $product_id . "'");
        }

        $this->setDescriptions($product_id, $data['descriptions']);

        $this->deleteStores($product_id);
        $this->deleteOptions($product_id);
        $this->deleteDiscounts($product_id);
        $this->deleteSpecials($product_id);
        $this->deleteImages($product_id);
        $this->deleteDownloads($product_id);
        $this->deleteCategories($product_id);
        $this->deleteRelated($product_id);

        foreach ($data['stores'] as $store_id) {
            $this->setStore(array(
                'product_id'=>$product_id,
                'store_id'=>$store_id
            ));
        }

        if (isset($data['Attributes'])) {
            $this->setAttributes(array(
                'product_id'=>$product_id,
                'Attributes'=>$data['Attributes'],
            ));
        }

        foreach ($data['product_option'] as $product_option) {
            $product_option['product_id'] = $product_id;
            $this->setOption($product_option);
        }

        foreach ($data['product_discount'] as $value) {
            $value['product_id'] = $product_id;
            $this->setDiscount($value);
        }

        foreach ($data['product_special'] as $value) {
            $value['product_id'] = $product_id;
            $this->setSpecial($value);
        }

        foreach ($data['product_image'] as $value) {
            $this->setImage(array(
                'product_id'=>$product_id,
                'image'=>$value
            ));
        }

        foreach ($data['product_download'] as $download_id) {
            $this->setDownload(array(
                'product_id'=>$product_id,
                'download_id'=>$download_id
            ));
        }
        
        foreach ($data['product_category'] as $category_id) {
            $this->setCategory(array(
                'product_id'=>$product_id,
                'category_id'=>$category_id
            ));
        }

        foreach ($data['product_related'] as $related_id) {
            $this->setRelated(array(
                'product_id'=>$product_id,
                'related_id'=>$related_id
            ));
        }

        $this->cache->delete('product');
        $this->cache->delete('products');
    }

    public function setAttributes($data) {
        $this->deleteProperty($product_id, 'attribute');
        $this->deleteProperty($product_id, 'attributes');
        $this->deleteProperty($product_id, 'attribute_group');

        $attribute_group_ids = array();
        foreach ($data['Attributes'] as $attribute_group_id => $attributes) {
            $attribute_group_ids[] = $attribute_group_id;
            foreach ($attributes as $key => $value) {
                $this->setProperty($data['product_id'], 'attribute', $key .":". $attribute_group_id, $value);
            }
        }

        $this->setProperty($data['product_id'], 'attributes', 'admin_attributes', $data['Attributes']);
        $this->setProperty($data['product_id'], 'attribute_group', 'attribute_group_id', $attribute_group_ids);
    }

    public function setRelated($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET 
        product_id = '" . (int) $data['product_id'] . "', 
        related_id = '" . (int) $data['related_id'] . "'");
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET 
        product_id = '" . (int) $data['related_id'] . "', 
        related_id = '" . (int) $data['product_id'] . "'");
    }

    public function setStore($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET 
            product_id = '" . (int)$data['product_id'] . "',
            store_id = '" . (int)$data['store_id'] . "'");
    }

    public function setCategory($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET 
            product_id = '" . (int)$data['product_id'] . "',
            category_id = '" . (int)$data['category_id'] . "'");
    }

    public function setDownload($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET 
            product_id = '" . (int)$data['product_id'] . "',
            download_id = '" . (int)$data['download_id'] . "'");
    }

    public function setImage($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET 
            product_id = '" . (int) $data['product_id'] . "', 
            image = '" . $this->db->escape($data['image']) . "'");

        return $this->db->getLastId();
    }

    public function setSpecial($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET 
            product_id = '" . (int) $data['product_id'] . "', 
            customer_group_id = '" . (int) $data['customer_group_id'] . "', 
            priority = '" . (int) $data['priority'] . "', 
            price = '" . (float) $data['price'] . "', 
            date_start = '" . $this->db->escape($data['date_start']) . "', 
            date_end = '" . $this->db->escape($data['date_end']) . "'");

        return $this->db->getLastId();
    }

    public function setDiscount($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET 
            product_id = '" . (int) $data['product_id'] . "', 
            customer_group_id = '" . (int) $data['customer_group_id'] . "', 
            quantity = '" . (int) $data['quantity'] . "', 
            priority = '" . (int) $data['priority'] . "', 
            price = '" . (float) $data['price'] . "', 
            date_start = '" . $this->db->escape($data['date_start']) . "', 
            date_end = '" . $this->db->escape($data['date_end']) . "'");

        return $this->db->getLastId();
    }

    public function setOption($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET 
        product_id = '" . (int) $data['product_id'] . "', 
        sort_order = '" . (int) $data['sort_order'] . "'");

        $product_option_id = $this->db->getLastId();

        foreach ($data['language'] as $language_id => $language) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_description SET 
            product_option_id = '" . (int) $product_option_id . "', 
            language_id = '" . (int) $language_id . "', 
            product_id = '" . (int) $data['product_id'] . "', 
            name = '" . $this->db->escape(str_replace('.', '', $language['name'])) . "'");
        }

        if (isset($data['product_option_value'])) {
            foreach ($data['product_option_value'] as $product_option_value) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET 
                product_option_id = '" . (int) $product_option_id . "', 
                product_id = '" . (int) $data['product_id'] . "', 
                quantity = '" . (int) $product_option_value['quantity'] . "', 
                subtract = '" . (int) $product_option_value['subtract'] . "', 
                price = '" . (float) $product_option_value['price'] . "', 
                prefix = '" . $this->db->escape($product_option_value['prefix']) . "', 
                sort_order = '" . (int) $product_option_value['sort_order'] . "'");

                $product_option_value_id = $this->db->getLastId();

                foreach ($product_option_value['language'] as $language_id => $language) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value_description SET 
                    product_option_value_id = '" . (int) $product_option_value_id . "', 
                    language_id = '" . (int) $language_id . "', 
                    product_id = '" . (int) $data['product_id'] . "', 
                    name = '" . $this->db->escape($language['name']) . "'");
                }
            }
        }
        return $product_option_id;
    }

    public function deleteOptions($product_id) {        
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_description WHERE product_id = '" . (int) $product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int) $product_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value_description WHERE product_id = '" . (int) $product_id . "'");
    }

    public function deleteStores($product_id) {        
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $product_id . "'");
    }

    public function deleteDiscounts($product_id) {        
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "'");
    }

    public function deleteSpecials($product_id) {        
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "'");
    }

    public function deleteImages($product_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $product_id . "'");
    }

    public function deleteDownloads($product_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int) $product_id . "'");
    }

    public function deleteCategories($product_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "'");
    }

    public function deleteRelated($product_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $product_id . "' OR related_id = '" . (int) $product_id . "'");
    }

    public function copy($product_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p WHERE p.product_id = '" . (int) $product_id . "' ");

        if ($query->num_rows) {
            $data = array();

            $data = $query->row;

            $data = array_merge($data, array('product_description' => $this->getDescriptions($product_id)));
            $data = array_merge($data, array('product_option' => $this->getOptions($product_id)));

            foreach ($data['product_description'] as $k => $v) {
                $data['product_description'][$k]['keyword'] = $v['keyword'] . uniqid("-");
            }

            $data['model'] = $data['model'] . uniqid("-");

            $data['product_image'] = array();

            $results = $this->getImages($product_id);

            foreach ($results as $result) {
                $data['product_image'][] = $result['image'];
            }

            $data = array_merge($data, array('product_discount' => $this->getDiscounts($product_id)));
            $data = array_merge($data, array('product_special' => $this->getSpecials($product_id)));
            $data = array_merge($data, array('product_download' => $this->getDownloads($product_id)));
            $data = array_merge($data, array('product_category' => $this->getCategories($product_id)));
            $data = array_merge($data, array('product_related' => $this->getRelated($product_id)));
            $data = array_merge($data, array('product_tags' => $this->getTags($product_id)));
            $data = array_merge($data, array('stores' => $this->getStores($product_id)));

            $this->add($data);
        }
    }

    public function getStores($id) {
        $data = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $id . "'");
        foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
        }
        return $data;
    }

    public function delete($product_id) {
        $shared_tables = array(
            'property',
            'description',
            'stat',
            'url_alias',
            'review',
        );

        foreach ($shared_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "$table ".
                "WHERE object_id = '" . (int) $product_id . "' ".
                "AND object_type = 'category'");
        }

        $product_tables = array(
            'option',
            'option_description',
            'option_value',
            'option_value_description',
            'discount',
            'image',
            'related',
            'to_download',
            'to_category',
            'to_store',
            'tags',
            'to_download',
        );

        foreach ($product_tables as $table) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "product_{$table} WHERE product_id = '" . (int) $product_id . "' ");
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $product_id . "'");

        $this->cache->delete('product');
        $this->cache->delete('products');
    }

    public function getAllByKeyword($keyword) {
        return $this->getAll(array(
            'queries'=>explode(' ', $keyword),
            'model'=>$keyword,
        ));
    }

    public function getAllByStoreId($id) {
        return $this->getAll(array(
            'store_id'=>$id
        ));
    }

    public function getAllByCategoryId($id) {
        return $this->getAll(array(
            'category_id'=>$id
        ));
    }

    public function getAllByManufacturerId($id) {
        return $this->getAll(array(
            'manufacturer_id'=>$id
        ));
    }

    public function getOptions($product_id) {
        $product_option_data = array();

        $product_option = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "' ORDER BY sort_order");

        foreach ($product_option->rows as $product_option) {
            $product_option_value_data = array();

            $product_option_value = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int) $product_option['product_option_id'] . "' ORDER BY sort_order");

            foreach ($product_option_value->rows as $product_option_value) {
                $product_option_value_description_data = array();

                $product_option_value_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value_description WHERE product_option_value_id = '" . (int) $product_option_value['product_option_value_id'] . "'");

                foreach ($product_option_value_description->rows as $result) {
                    $product_option_value_description_data[$result['language_id']] = array('name' => $result['name']);
                }

                $product_option_value_data[] = array(
                    'product_option_value_id' => $product_option_value['product_option_value_id'],
                    'language' => $product_option_value_description_data,
                    'quantity' => $product_option_value['quantity'],
                    'subtract' => $product_option_value['subtract'],
                    'price' => $product_option_value['price'],
                    'prefix' => $product_option_value['prefix'],
                    'sort_order' => $product_option_value['sort_order']
                );
            }

            $product_option_description_data = array();

            $product_option_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_description WHERE product_option_id = '" . (int) $product_option['product_option_id'] . "'");

            foreach ($product_option_description->rows as $result) {
                $product_option_description_data[$result['language_id']] = array('name' => $result['name']);
            }

            $product_option_data[] = array(
                'product_option_id' => $product_option['product_option_id'],
                'language' => $product_option_description_data,
                'product_option_value' => $product_option_value_data,
                'sort_order' => $product_option['sort_order']
            );
        }

        return $product_option_data;
    }

    public function getImages($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $product_id . "'");

        return $query->rows;
    }

    public function getDiscounts($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "' ORDER BY quantity, priority, price");

        return $query->rows;
    }

    public function getSpecials($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "' ORDER BY priority, price");

        return $query->rows;
    }

    public function getDownloads($product_id) {
        $product_download_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int) $product_id . "'");

        foreach ($query->rows as $result) {
            $product_download_data[] = $result['download_id'];
        }

        return $product_download_data;
    }

    public function getCategories($product_id) {
        $product_category_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "'");

        foreach ($query->rows as $result) {
            $product_category_data[] = $result['category_id'];
        }

        return $product_category_data;
    }

    public function getRelated($product_id) {
        $product_related_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $product_id . "'");

        foreach ($query->rows as $result) {
            $product_related_data[] = $result['related_id'];
        }

        return $product_related_data;
    }

    public function getTags($product_id) {
        $query = $this->db->query("SELECT * 
            FROM " . DB_PREFIX . "product_tags 
            WHERE product_id = '" . (int) $product_id . "'");

        foreach ($query->rows as $result) {
            $query2 = $this->db->query("SELECT tag 
                FROM " . DB_PREFIX . "product_tags 
                WHERE product_id = '" . (int) $product_id . "' 
                AND language_id = '" . (int) $result['language_id'] . "'");

            $product_tags_data[$result['language_id']] = array(
                'tag' => implode(",", $query2->rows)
            );
        }

        return $product_tags_data;
    }

    public function getAllTotalByStockStatusId($id) {
        return $this->getAllTotal(array(
            'stock_status_id'=>$id
        ));
    }

    public function getAllTotalByTaxClassId($id) {
        return $this->getAllTotal(array(
            'tax_class_id'=>$id
        ));
    }

    public function getAllTotalByWeightClassId($id) {
        return $this->getAllTotal(array(
            'weight_class_id'=>$id
        ));
    }

    public function getAllTotalByLengthClassId($id) {
        return $this->getAllTotal(array(
            'length_class_id'=>$id
        ));
    }

    public function getAllTotalByOptionId($option_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_option WHERE option_id = '" . (int) $option_id . "'");

        return $query->row['total'];
    }

    public function getAllTotalByDownloadId($download_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int) $download_id . "'");

        return $query->row['total'];
    }

    public function getAllTotalByManufacturerId($id) {
        return $this->getAllTotal(array(
            'manufacturer_id'=>$id
        ));
    }

    public function sortProduct($data) {
        if (!is_array($data))
            return false;
        $pos = 1;
        foreach ($data as $id) {
            $this->db->query("UPDATE " . DB_PREFIX . "product SET sort_order = '" . (int) $pos . "' WHERE product_id = '" . (int) $id . "'");
            $pos++;
        }
        return true;
    }

    public function getSeoTitleRating() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE CHAR_LENGTH(`title`) NOT BETWEEN 8 AND 55 AND object_type = 'product' ");
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE object_type = 'product'");
        return $query->row['total'] * 100 / $query2->row['total'];
    }

    public function getSeoMetaDescripionRating() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE CHAR_LENGTH(`meta_description`) NOT BETWEEN 8 AND 155 AND object_type = 'product'");
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE object_type = 'product'");
        return $query->row['total'] * 100 / $query2->row['total'];
    }

    public function getSeoDescriptionRating() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE CHAR_LENGTH(`description`) < 150 AND object_type = 'product'");
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "description` WHERE object_type = 'product'");
        return $query->row['total'] * 100 / $query2->row['total'];
    }

    public function getSeoUrlRating() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product` WHERE product_id NOT IN (SELECT `object_id` FROM `" . DB_PREFIX . "url_alias` WHERE `object_type` = 'product')");
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "product`");
        return $query->row['total'] * 100 / $query2->row['total'];
    }

    public function getCategoriesByAttributeGroupId($id) {
        if (is_array($id)) {
            $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_attribute_to_category ".
                "WHERE product_attribute_group_id IN ('" . implode("','", $id) . "') ");
        } else {
            $query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_attribute_to_category ".
                "WHERE product_attribute_group_id = '" . (int)$id . "' ");
        }

        foreach ($query->rows as $row) {
            $return[] = $row['category_id'];
        }

        return $return;
    }

    public function getAttributeGroupsByCategoriesId($id) {
        if (is_array($id)) {
            $query = $this->db->query("SELECT product_attribute_group_id FROM " . DB_PREFIX . "product_attribute_to_category ".
                "WHERE product_attribute_group_id IN ('" . implode("','", $id) . "') ");
        } else {
            $query = $this->db->query("SELECT product_attribute_group_id FROM " . DB_PREFIX . "product_attribute_to_category ".
                "WHERE category_id = '" . (int)$id . "' ");
        }

        foreach ($query->rows as $row) {
            $return[] = $row['product_attribute_group_id'];
        }

        return $return;
    }

    public function getById($id) {
        $result = $this->getAll(array(
            'product_id'=>$id,
            'language_id'=>$this->config->get('config_language_id')
        ));
        return $result[0];
    }

    public function getAll($data=null) {
        $cache_prefix = "admin.products";
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
            $sql = "SELECT *, 
            t.product_id as pid,
            td.description as pdescription,
            t.image as pimage,
            t.status as status,
            td.title as pname, 
            ss.name as ssname,
            m.name as mname,
            tc.title as tctitle, 
            t.viewed AS pviewed FROM " . DB_PREFIX . "product t ";

            if (!isset($sort_data)) {
                $sort_data = array(
                    'td.title',
                    't.model',
                    't.price',
                    't.quantity',
                    't.viewed',
                    't.stock_status_id',
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
        $cache_prefix = "admin.products.total";
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
            $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product t ";
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

        $sql .= "LEFT JOIN " . DB_PREFIX . "description td ON (t.product_id = td.object_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "stock_status ss ON (t.stock_status_id = ss.stock_status_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "manufacturer m ON (t.manufacturer_id = m.manufacturer_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "tax_class tc ON (t.tax_class_id = tc.tax_class_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "weight_class wc ON (t.weight_class_id = wc.weight_class_id) ";
        $sql .= "LEFT JOIN " . DB_PREFIX . "description wcd ON (wc.weight_class_id = wcd.object_id) ";

        $criteria[] = " td.object_type = 'product' ";

        $data['category_id'] = !is_array($data['category_id']) && !empty($data['category_id']) ? array($data['category_id']) : $data['category_id'];
        $data['manufacturer_id'] = !is_array($data['manufacturer_id']) && !empty($data['manufacturer_id']) ? array($data['manufacturer_id']) : $data['manufacturer_id'];
        $data['language_id'] = !is_array($data['language_id']) && !empty($data['language_id']) ? array($data['language_id']) : $data['language_id'];
        $data['store_id'] = !is_array($data['store_id']) && !empty($data['store_id']) ? array($data['store_id']) : $data['store_id'];
        $data['product_id'] = !is_array($data['product_id']) && !empty($data['product_id']) ? array($data['product_id']) : $data['product_id'];
        $data['stock_status_id'] = !is_array($data['stock_status_id']) && !empty($data['stock_status_id']) ? array($data['stock_status_id']) : $data['stock_status_id'];
        $data['weight_class_id'] = !is_array($data['weight_class_id']) && !empty($data['weight_class_id']) ? array($data['weight_class_id']) : $data['weight_class_id'];
        $data['length_class_id'] = !is_array($data['length_class_id']) && !empty($data['length_class_id']) ? array($data['length_class_id']) : $data['length_class_id'];

        if (isset($data['store_id']) && !empty($data['store_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "product_to_store t2s ON (t.product_id = t2s.product_id) ";
            $criteria[] = " t2s.store_id IN (" . implode(', ', $data['store_id']) . ") ";
        }

        if (isset($data['category_id']) && !empty($data['category_id'])) {
            $sql .= "LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (t.product_id = p2c.product_id) ";
            $criteria[] = " p2c.category_id IN (" . implode(', ', $data['category_id']) . ") ";
        }

        if (isset($data['length_class_id']) && !empty($data['length_class_id'])) {
            $criteria[] = " t.length_class_id IN (" . implode(', ', $data['length_class_id']) . ") ";
        }

        if (isset($data['weight_class_id']) && !empty($data['weight_class_id'])) {
            $criteria[] = " t.weight_class_id IN (" . implode(', ', $data['weight_class_id']) . ") ";
        }

        if (isset($data['stock_status_id']) && !empty($data['stock_status_id'])) {
            $criteria[] = " t.stock_status_id IN (" . implode(', ', $data['stock_status_id']) . ") ";
        }

        if (isset($data['product_id']) && !empty($data['product_id'])) {
            $criteria[] = " t.product_id IN (" . implode(', ', $data['product_id']) . ") ";
        }

        if (isset($data['manufacturer_id']) && !empty($data['manufacturer_id'])) {
            $criteria[] = " t.manufacturer_id IN (" . implode(', ', $data['manufacturer_id']) . ") ";
        }

        if (isset($data['language_id']) && !empty($data['language_id'])) {
            $criteria[] = " td.language_id IN (" . implode(', ', $data['language_id']) . ") ";
            $criteria[] = " wcd.language_id IN (" . implode(', ', $data['language_id']) . ") ";
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

        if (isset($data['from_price']) || isset($data['to_price'])) {

            if (isset($data['from_price']) && !empty($data['from_price'])) {
                $criteria[] = " t.`price` >= '" . $this->db->escape((float)$data['from_price']) . "' ";
            }

            if (isset($data['to_price']) && !empty($data['to_price'])) {
                $criteria[] = " t.`price` <= '" . $this->db->escape((float)$data['to_price']) . "' ";
            }

        } elseif (isset($data['price']) && !empty($data['price'])) {
            $criteria[] = " t.`price` = '" . $this->db->escape((float)$data['price']) . "' ";
        } 

        if (isset($data['from_quantity']) || isset($data['to_quantity'])) {

            if (isset($data['from_quantity']) && !empty($data['from_quantity'])) {
                $criteria[] = " t.`quantity` >= '" . $this->db->escape((int)$data['from_quantity']) . "' ";
            }

            if (isset($data['to_quantity']) && !empty($data['to_quantity'])) {
                $criteria[] = " t.`quantity` <= '" . $this->db->escape((int)$data['to_quantity']) . "' ";
            }

        } elseif (isset($data['quantity']) && !empty($data['quantity'])) {
            $criteria[] = " t.`quantity` = '" . $this->db->escape((float)$data['quantity']) . "' ";
        } 

        if (isset($data['title']) && !empty($data['title'])) {
            $criteria[] = " LCASE(td.`title`) LIKE '%" . $this->db->escape(strtolower($data['title'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['model']) && !empty($data['model'])) {
            $criteria[] = " LCASE(t.`model`) LIKE '%" . $this->db->escape(strtolower($data['model'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['type']) && !empty($data['type'])) {
            $criteria[] = " LCASE(t.`type`) LIKE '%" . $this->db->escape(strtolower($data['type'])) . "%' collate utf8_general_ci ";
        }

        if (isset($data['sku']) && !empty($data['sku'])) {
            $criteria[] = " LCASE(t.`sku`) LIKE '%" . $this->db->escape(strtolower($data['sku'])) . "%' collate utf8_general_ci ";
        }

        if (!empty($data['status']) && is_numeric($data['status'])) {
            $criteria[] = " t.status = '". intval($data['status']) ."' ";
        }

        if (!empty($data['properties'])) {
            $sql .= " LEFT JOIN " . DB_PREFIX . "property pp ON (t.product_id = pp.object_id) ";
            foreach ($data['properties'] as $key => $value) {
                $criteria[] = " LCASE(pp.`key`)  LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['key']))) . "%' collate utf8_general_ci ";
                $criteria[] = " CONVERT(LCASE(pp.`value`) USING utf8) LIKE '%" . $this->db->escape(strtolower(str_replace('-',' ',$value['value']))) . "%' ";
                $criteria[] = " pp.object_type = 'product' ";
            }
        }

        if (!empty($data['publish_date_start'])) {
            $criteria[] = "date_available <= '" . date('Y-m-d h:i:s', strtotime($data['publish_date_start'])) . "'";
        }

        if (!empty($data['publish_date_end'])) {
            $criteria[] = "date_available >= '" . date('Y-m-d h:i:s', strtotime($data['publish_date_end'])) . "'";
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
                $sql .= " GROUP BY t.product_id";
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
        return $this->__activate('product', $id);
    }

    public function desactivate($id) {
        return $this->__desactivate('product', $id);
    }
    
    public function getDescriptions($id, $language_id=null) {
        return $this->__getDescriptions('product', $id, $language_id);
    }

    public function setDescriptions($id, $data) {
        return $this->__setDescriptions('product', $id, $data);

        foreach ($data as $language_id => $value) {
            $tags = explode(',', $value['meta_keywords']);
            foreach ($tags as $tag) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "product_tags SET 
                product_id = '" . (int) $id . "', 
                language_id = '" . (int) $language_id . "', 
                tag = '" . $this->db->escape(trim($tag)) . "'");
            }
        }

    }

    public function getProperty($id, $group, $key) {
        return $this->__getProperty('product', $id, $group, $key);
    }

    public function setProperty($id, $group, $key, $value) {
        return $this->__setProperty('product', $id, $group, $key, $value);
    }

    public function deleteProperty($id, $group='*', $key='*') {
        return $this->__deleteProperties('product', $id, $group, $key);
    }

    public function getAllProperties($id, $group = '*') {
        return $this->__getProperties('product', $id, $group);
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
