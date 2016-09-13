<?php
/*
* ver. 0.2.0
* PayU Payment Modules
*
* @copyright  Copyright 2014 by PayU
* @license    http://opensource.org/licenses/GPL-3.0  Open Software License (GPL 3.0)
* http://www.payu.com
* http://twitter.com/openpayu
*/
class ModelPaymentPayu extends Model
{
    public function getMethod($address)
    {
        $this->load->language('payment/payu');

        if ($this->config->get('payu_status')) {
            $status = true;
        } else {
            $status = false;
        }
        /*
          $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('payu_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

          if ($this->config->get('payu_total') > $total) {
              $status = false;
          } elseif (!$this->config->get('payu_geo_zone_id')) {
              $status = true;
          } elseif ($query->num_rows) {
              $status = true;
          } else {
              $status = false;
          }
          */

        $method_data = array();
        if ($status) {
            $method_data = array(
                'id' => 'payu',
                'code' => 'payu',
                'title' => $this->language->get('text_title'),
                'sort_order' => $this->config->get('payu_sort_order')
            );
        }

        return $method_data;
    }
}