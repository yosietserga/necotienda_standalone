<?php
class ModelAccountCustomer extends Model {
	public function addCustomer($data) {
	   if ($this->getTotalCustomersByEmail($data['email'] > 0)) {
	       $strError =  "<li>El email ya existe</li>";
           $error = true;
	   } 
       if (!$error) {
      	$result = $this->db->query("INSERT INTO `" . DB_PREFIX . "customer` SET 
          `store` = '" . (int)C_CODE . "', 
          `email` = '" . $this->db->escape($data['email']) . "', 
          `rif` = '" . $this->db->escape($data['rif']) . "', 
          `company` = '" . $this->db->escape($data['company']) . "', 
          `password` = '" . $this->db->escape(md5($data['password'])) . "', 
          `codigo` = '" . $this->db->escape(md5($data['codigo'])) . "',
          `customer_group_id` = '" . (int)$this->config->get('config_customer_group_id') . "', 
          `status` = '1', 
          `date_added` = NOW()");
		$customer_id = $this->db->getLastId();
        
      	$this->db->query("INSERT INTO " . DB_PREFIX . "address SET 
          customer_id = '" . (int)$customer_id . "', 
          firstname = '" . $this->db->escape($data['firstname']) . "', 
          lastname = '" . $this->db->escape($data['lastname']) . "', 
          company = '" . $this->db->escape($data['company']) . "', 
          address_1 = '" . $this->db->escape($data['address_1']) . "',
          city = '" . $this->db->escape($data['city']) . "', 
          postcode = '" . $this->db->escape($data['postcode']) . "', 
          country_id = '" . (int)$data['country_id'] . "', 
          zone_id = '" . (int)$data['zone_id'] . "'");
		
		$address_id = $this->db->getLastId();

      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
		
		if ($this->config->get('config_customer_approval')) {
			$this->db->query("UPDATE `" . DB_PREFIX . "customer` SET `approved` = '1' WHERE `customer_id` = '" . (int)$customer_id . "'");
		}
        return $result;	
      }
      return $strError;	
	}
	
	public function editCustomer($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET 
        firstname = '" . $this->db->escape($data['firstname']) . "', 
        lastname = '" . $this->db->escape($data['lastname']) . "', 
        nacimiento = '" .$this->db->escape($data['nacimiento']) . "', 
        telephone = '" . $this->db->escape($data['telephone']) . "', 
        fax = '" . $this->db->escape($data['fax']) . "', 
        sexo = '" . $this->db->escape($data['sexo']) . "', 
        blog = '" . $this->db->escape($data['blog']) . "', 
        website = '" . $this->db->escape($data['website']) . "', 
        profesion = '" . $this->db->escape($data['profesion']) . "', 
        titulo = '" . $this->db->escape($data['titulo']) . "', 
        msn = '" . $this->db->escape($data['msn']) . "', 
        gmail = '" . $this->db->escape($data['gmail']) . "', 
        yahoo = '" . $this->db->escape($data['yahoo']) . "', 
        skype = '" . $this->db->escape($data['skype']) . "', 
        facebook = '" . $this->db->escape($data['facebook']) . "', 
        twitter = '" . $this->db->escape($data['twitter']) . "', 
        foto = '" . $this->db->escape($data['foto']) . "',  
        rif = '" . $this->db->escape($data['rif']) . "',
        company = '" . $this->db->escape($data['company']) . "' 
        WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}
    
    public function addPersonal($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "address SET 
          customer_id = '" . (int)$customer_id . "', 
          address_1 = '" . $this->db->escape($data['address_1']) . "', 
          city = '" . $this->db->escape($data['city']) . "', 
          postcode = '" . $this->db->escape($data['postcode']) . "', 
          country_id = '" . (int)$data['country_id'] . "', 
          zone_id = '" . (int)$data['zone_id'] . "'");
          
        $address_id = $this->db->getLastId();
        
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET 
        firstname = '" . $this->db->escape($data['firstname']) . "', 
        lastname = '" . $this->db->escape($data['lastname']) . "', 
        nacimiento = '" .$this->db->escape($data['nacimiento']) . "', 
        telephone = '" . $this->db->escape($data['telephone']) . "', 
        sexo = '" . $this->db->escape($data['sexo']) . "', 
        address_id = '" . (int)$address_id . "'
        WHERE customer_id = '" . (int)$this->customer->getId() . "'");
        
        return $this->db->countAffected();
	}
    
    
    public function addSocial($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET 
        msn = '" . $this->db->escape($data['msn']) . "', 
        gmail = '" . $this->db->escape($data['gmail']) . "', 
        yahoo = '" . $this->db->escape($data['yahoo']) . "', 
        skype = '" . $this->db->escape($data['skype']) . "', 
        facebook = '" . $this->db->escape($data['facebook']) . "', 
        twitter = '" . $this->db->escape($data['twitter']) . "',
        blog = '" . $this->db->escape($data['blog']) . "', 
        website = '" . $this->db->escape($data['website']) . "'
        WHERE customer_id = '" . (int)$this->customer->getId() . "'");
        return $this->db->countAffected();
	}
    
    public function addProfesion($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET 
        blog = '" . $this->db->escape($data['blog']) . "', 
        website = '" . $this->db->escape($data['website']) . "', 
        profesion = '" . $this->db->escape($data['profesion']) . "', 
        titulo = '" . $this->db->escape($data['titulo']) . "' 
        WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}
    
    public function addFoto($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET 
        foto = '" . $this->db->escape($data['foto']) . "' 
        WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}
    
    public function completeUser() {
        $result = $this->db->query("UPDATE " . DB_PREFIX . "customer SET 
        complete = '1' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
            return $result;
    }

	public function editPassword($email, $password) {
      	$this->db->query("UPDATE " . DB_PREFIX . "customer SET 
          `password` = '" . $this->db->escape(md5($password)) . "' 
          WHERE `email` = '" . $this->db->escape($email) . "'");
	}

	public function editNewsletter($newsletter) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET 
        newsletter = '" . (int)$newsletter . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}
			
	public function getCustomer($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customer_id . "'");
		
		return $query->row;
	}
	
	public function getTotalCustomersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($email) . "'");
		
		return $query->row['total'];
	}
    
    public function addTransferencia($data) {
        $strError = '';
        if (!$this->checkOrderStatus($data['order_id'])) {
            $strError .= "Estado Incorrecto";
            $error = true;
        }
        
        if ($data['forma_de_pago'] == 'Deposito') {
            if (!$this->checkPaymentMethod($data['order_id'],'Cheque')) {
                $strError .= "<li>Lo siento, la forma de pago elegida para este pedido es diferente a <b>Dep&oacute;sito Bancario</b>.";
                $error = true;
            }
        }
        if ($data['forma_de_pago'] == 'Transferencia') {
            if (!$this->checkPaymentMethod($data['order_id'],'Transferencia Bancaria')) {
                $strError .= "<li>Lo siento, la forma de pago elegida para este pedido es diferente a <b>Transferencia Bancaria</b>.";
                $error = true;
            }
        }
        
        $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$data['order_id'] . "'");
        if ($order_query->num_rows) {
            if ($this->checkTransaccionID($data['order_id'],$order_query->row['customer_id'],$data['numero_transaccion'])) {
               $strError .= "<li>El n&uacute;mero de transacci&oacute;n ya existe.</li>";
               $error = true;
            }
        }
             
        if (!$this->checkFechaPago($data['order_id'],$data['fecha_pago'])) {
            $strError .= "<li>Por su seguridad, no puede reportar un pago con fecha inferior a la fecha del pedido.</li>";
            $error = true;
        }
        if (!$strError) {
    	    $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$data['order_id'] . "'");
            if ($order_query->num_rows) {
                $customer_id      = $order_query->row['customer_id'];
                $resta            = (float)$order_query->row['total'] - (float)$data['monto_cancelado'];
                $monto_a_devolver = 0;
                $monto_restante   = 0;
                if ($resta > 0) {
                    $monto_restante = $resta;
                } elseif ($resta < 0) {
                    $monto_a_devolver = str_replace('-','',$resta);
                } 
                
                $pago_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "pago` ORDER BY pago_id DESC LIMIT 1");
                if ($pago_query->num_rows) {
                    $pago_id = $pago_query->row['pago_id'] + 1;
                } else {
                    $pago_id = 1;
                }
                $codigo = sha1((int)$data['order_id'].(int)$customer_id.$data['numero_transaccion']);
                $result = $this->db->query("INSERT INTO `" . DB_PREFIX . "pago` SET pago_id = '" . (int)$pago_id . "', order_id = '" . (int)$data['order_id'] . "', customer_id = '" . (int)$customer_id . "', numero_transaccion = '" . $this->db->escape($data['numero_transaccion']) . "', nombre = '" . $this->db->escape($data['nombre']) . "', mi_banco = '" . $this->db->escape($data['mi_banco']) . "', forma_de_pago = '" . $this->db->escape($data['forma_de_pago']) . "', tipo_deposito = '" . $this->db->escape($data['tipo_deposito']) . "', su_banco = '" . $this->db->escape($data['su_banco']) . "', monto_cancelado = '" . (float)$data['monto_cancelado'] . "', monto_del_pedido = '" . (float)$order_query->row['total'] . "', monto_a_devolver = '" . (float)$monto_a_devolver . "', monto_restante = '" . (float)$monto_restante . "', observacion = '" . $this->db->escape($data['observacion']) . "', codigo = '" . md5($codigo) . "', fecha_pago = '" . date('Y-m-d',strtotime($data['fecha_pago'])) . "', fecha_creado = now()");
                $pago_id = $this->db->getLastId();
                $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '7' WHERE order_id = '" . (int)$data['order_id'] . "'");
                return $result;
            }
        }
        $strError .= "<br><h3>Si posee alguna duda o pregunta sobre el proceso, por favor cont&aacute;ctenos.</h3>.";
        return $strError;
    }  


	public function getTransferenciaByOrder($order_id) {
		$query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "transferencia WHERE order_id = '" . (int)$order_id . "'");
		return $query->row['total'];
	}
    
    public function getTransferencia($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pago WHERE order_id = '" . (int)$order_id . "'");
		return $query->row;
	}
    
    public function checkOrderStatus($order_id) {
        $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
        if (($order_query->row['order_status_id'] == 1) || ($order_query->row['order_status_id'] == 7)) {
            return true;
        } 
    }
    
    public function checkPaymentMethod($order_id,$method,$language_id = 1) {
          $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE `order_id` = '" . (int)$order_id . "' and `language_id` = '" . (int)$language_id . "'");
          if (($order_query->row['payment_method'] == $method)) {
                return true;
          } 
    }
    
    public function checkTransaccionID($order_id,$customer_id,$transaccionID) {
        $pago_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "pago`");
        if ($pago_query->num_rows) {
            $codigo = sha1($order_id.$customer_id.$transaccionID);
            foreach($pago_query->rows as $value) {
                if (md5($codigo) == $value['codigo']) {
                    return true;
                }
            }
        }
    }
    
    public function checkFechaPago($order_id,$fecha) {
        if (!empty($order_id)) {
            $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "'");
            if ($order_query->num_rows) {
                if ($fecha > date('d-m-Y',strtotime($order_query->row['date_added']))) {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
