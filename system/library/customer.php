<?php
final class Customer {
	private $customer_id;
	private $firstname;
	private $lastname;
	private $email;
	private $telefono;
	private $cedula;
	private	$rif;
	private	$company;
	private	$foto;
	private	$nacimiento;
	private	$blog;
	private	$website;
	private	$telephone;
	private	$profesion;
	private	$titulo;
	private	$msn;
	private	$gmail;
	private	$yahoo;
	private	$skype;
	private	$facebook;
	private	$twitter;
	private	$complete;
	private	$sexo;
	private	$customer_group_id;
	private	$address_id;
    
    private $key = "946VBA4kg84tbsdowyJF63KGUn4f3mj32nci34JQ53Ejnejs";
	private $registry;
    
	public $skey; //utilizado para verificar la sesión del usuario
	
  	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');
		$this->registry = $registry;
		$this->skey = md5($this->session->get('token')).$this->key."_".$this->getId();
		//if ($this->validSession()) { 
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->get('customer_id') . "' AND status = '1'");
			
			if ($customer_query->num_rows) {
				$this->customer_id   = $customer_query->row['customer_id'];
				$this->firstname     = $customer_query->row['firstname'];
				$this->lastname      = $customer_query->row['lastname'];
				$this->email         = $customer_query->row['email'];
				$this->cedula        = $customer_query->row['cedula'];
				$this->telefono      = $customer_query->row['telefono'];
    			$this->rif           = $customer_query->row['rif'];
    			$this->company       = $customer_query->row['company'];
    			$this->foto          = $customer_query->row['foto'];
    			$this->nacimiento    = $customer_query->row['nacimiento'];
    			$this->blog          = $customer_query->row['blog'];
    			$this->website       = $customer_query->row['website'];
    			$this->telephone     = $customer_query->row['telephone'];
    			$this->profesion     = $customer_query->row['profesion'];
    			$this->titulo        = $customer_query->row['titulo'];
    			$this->msn           = $customer_query->row['msn'];
    			$this->gmail         = $customer_query->row['gmail'];
    			$this->yahoo         = $customer_query->row['yahoo'];
    			$this->skype         = $customer_query->row['skype'];
    			$this->facebook      = $customer_query->row['facebook'];
    			$this->twitter       = $customer_query->row['twitter'];
    			$this->complete      = $customer_query->row['complete'];
    			$this->sexo          = $customer_query->row['sexo'];
    			$this->customer_group_id = $customer_query->row['customer_group_id'];
    			$this->address_id    = $customer_query->row['address_id'];
                
                $this->skey=$this->session->get('skey');
							
      		} else {
				$this->logout();
			}
  		//}
	}
    
    public function validSession() {        
        if (!$this->session->has('customer_id') || !$this->session->has('skey') || ($this->session->get('skey') != $this->skey)) return false;
        //TODO: verificar la llave de la sesión del usuario
        $customer_id = substr($this->session->get('skey'),strpos($this->session->get('skey'),'_')+1);
        if ($this->session->get('customer_id') != $customer_id) return false;
        return true;
    }
		
  	public function login($email, $password) {
		if (!$this->config->get('config_customer_approval')) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($email) . "' AND password = '" . $this->db->escape(md5($password)) . "' AND status = '1'");
		} else {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($email) . "' AND password = '" . $this->db->escape(md5($password)) . "' AND status = '1' AND approved = '1'");
		}
		
		if ($customer_query->num_rows) {
			$this->session->set('customer_id',$customer_query->row['customer_id']);
            $tk = $this->session->has('token') ? $this->session->get('token') : strtotime(date('d-m-Y h:i:s')) . mt_rand(1000000000,9999999999);
            $this->session->set('token',$tk);
			$this->skey = md5($this->session->get('token')).$this->key."_".$customer_query->row['customer_id'];	
			$this->session->set('skey',$this->skey);	
            
            //insertamos un registro del usuario para saber cuando ingresó, desde que ip, etc
		    $this->db->query("INSERT INTO " . DB_PREFIX . "customer_stats SET 
            customer_id = '".$customer_query->row['customer_id']."',
            ip = '".$_SERVER['REMOTE_ADDR']."',
            date_added = NOW()");
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET visits = visits + 1 WHERE customer_id = '" . (int)$customer_query->row['customer_id'] . "'");
    		
            
			if (($customer_query->row['cart']) && (is_string($customer_query->row['cart']))) {
				$cart = unserialize($customer_query->row['cart']);
				
				foreach ($cart as $key => $value) {
					if (!array_key_exists($key, $this->session->get('cart'))) {
						$this->session->data['cart'][$key] = $value;
					} else {
						$this->session->data['cart'][$key] += $value;
					}
				}			
			}
			
			$this->customer_id   = $customer_query->row['customer_id'];
			$this->firstname     = $customer_query->row['firstname'];
			$this->lastname      = $customer_query->row['lastname'];
			$this->email         = $customer_query->row['email'];
			$this->rif           = $customer_query->row['rif'];
			$this->company       = $customer_query->row['company'];
			$this->foto          = $customer_query->row['foto'];
			$this->nacimiento    = $customer_query->row['nacimiento'];
			$this->blog          = $customer_query->row['blog'];
			$this->website       = $customer_query->row['website'];
			$this->profesion     = $customer_query->row['profesion'];
			$this->titulo        = $customer_query->row['titulo'];
			$this->msn           = $customer_query->row['msn'];
			$this->gmail         = $customer_query->row['gmail'];
			$this->yahoo         = $customer_query->row['yahoo'];
			$this->skype         = $customer_query->row['skype'];
			$this->facebook      = $customer_query->row['facebook'];
			$this->twitter       = $customer_query->row['twitter'];
			$this->complete      = $customer_query->row['complete'];
            $this->telephone     = $customer_query->row['telephone'];
			$this->fax           = $customer_query->row['fax'];
			$this->sexo          = $customer_query->row['sexo'];
			$this->newsletter    = $customer_query->row['newsletter'];
			$this->customer_group_id = $customer_query->row['customer_group_id'];
			$this->address_id    = $customer_query->row['address_id'];
      
	  		return true;
    	} else {
      		return false;
    	}
  	}
  
  	public function logout() {
		$this->session->clear('customer_id');
		$this->session->clear('skey');
		$this->session->clear('token');

		$this->customer_id = '';
		$this->firstname = '';
		$this->lastname = '';
		$this->email = '';
		$this->rif = '';
		$this->company = '';
		$this->foto = '';
		$this->nacimiento = '';
		$this->blog = '';
		$this->website = '';
		$this->profesion = '';
		$this->titulo = '';
		$this->msn = '';
		$this->gmail = '';
		$this->yahoo = '';
		$this->skype = '';
		$this->facebook = '';
		$this->twitter = '';
		$this->telephone = '';
		$this->fax = '';
		$this->newsletter = '';
		$this->customer_group_id = '';
		$this->address_id = '';
  	}
  
  	public function isLogged() {
    	return $this->customer_id;
  	}
    
    public function activateUser($codigo) {
        $result = $this->db->query("UPDATE " . DB_PREFIX . "customer SET approved = '1' WHERE codigo = '" . $this->db->escape($codigo) . "'");
            return $result;
    }
    
    public function setComplete() {
        $result = $this->db->query("UPDATE " . DB_PREFIX . "customer SET complete= '1' WHERE customer_id = '" . (int)$this->getId() . "'");
            return $result;
    }
    
  	public function getId() {
    	return $this->customer_id;
  	}
      
  	public function getFirstName() {
		return $this->firstname;
  	}
  
  	public function getLastName() {
		return $this->lastname;
  	}
  
  	public function getEmail() {
		return $this->email;
  	}
  
  	public function getRif() {
		return $this->rif;
  	}
  
  	public function getCompany() {
		return $this->company;
  	}
  
  	public function getFoto() {
		return $this->foto;
  	}
  
  	public function getNacimiento() {
		return $this->nacimiento;
  	}
  
  	public function getBlog() {
		return $this->blog;
  	}
  
  	public function getWebsite() {
		return $this->website;
  	}
  
  	public function getProfesion() {
		return $this->profesion;
  	}
  
  	public function getTitulo() {
		return $this->titulo;
  	}
  
  	public function getMsn() {
		return $this->msn;
  	}
  
  	public function getGmail() {
		return $this->gmail;
  	}
  
  	public function getYahoo() {
		return $this->yahoo;
  	}
  
  	public function getSkype() {
		return $this->skype;
  	}
  
  	public function getFacebook() {
		return $this->facebook;
  	}
  
  	public function getTwitter() {
		return $this->twitter;
  	}
    
    public function getComplete() {
        return $this->complete;
  	}
  
  	public function getTelephone() {
		return $this->telephone;
  	}
    
    public function emailExist($email) {
        $correo = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer` WHERE email = '".$this->db->escape($email)."'");
        return $correo;
  	}
  
  	public function getFax() {
		return $this->fax;
  	}
	
  	public function getNewsletter() {
		return $this->newsletter;	
  	}

  	public function getCustomerGroupId() {
		return $this->customer_group_id;	
  	}
	
  	public function getAddressId() {
		return $this->address_id;	
  	}
}
