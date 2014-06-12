<?php    
class ControllerEmailMember extends Controller { 
	private $error = array();
  
  	public function index() {
		$this->load->language('email/member');
		 
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('email/member');
		
    	$this->getList();
  	}
    
    public function export() {
		$this->load->language('email/member');
		 
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('email/member');
		
    	$this->getExportList();
  	}
    
    public function import() {
        
        $error = false;
        $errormsg = '';
		$this->load->model('email/member');
		$member_info = $this->model_email_member->getMemberExport($this->request->get['member_id']);
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if (!empty($_FILES)) {
                $temp_file = $_FILES['file_import']['tmp_name'];
                $filename = basename($_FILES['file_import']['name']);
                $fileinfo = pathinfo($filename);
                if ($fileinfo['extension'] !== 'csv') {
                    $errormsg .= "- El formato del archivo es incorrecto\\n";
                    $error = true;
                }
                if ($_FILES['file_import']['type'] !== 'application/vnd.ms-excel') {
                    $errormsg .= "- El archivo posee un tipo de dato ilegible\\n";
                    $error = true;
                }
                $filecontent = file($temp_file);
                if (empty($filecontent)) {                    
                    $errormsg .= "- El archivo esta vacio\\n";
                    $error = true;
                }
                if ($_FILES['file_import']['size'] > 2097152) {
                    $errormsg .= "- El archivo es muy grande, solo se permiten hasta 2MB\\n";
                    $error = true;
                }
                if (!isset($this->request->post['format']) || $this->request->post['format'] == 'false') {
                    $errormsg .= "- Debe seleccionar una estructura para el archivo\\n";
                    $error = true;                    
                }
                if (!$error) {
                $data = array();         
                foreach ($filecontent as $line) {
                    $data[] = explode(',',$line);
                }   
                $csv = array();
                $csv['header'] = $data[0];
                array_shift($data);
                $csv['body'] = $data;
                switch($this->request->post['format']) {
                    case 'hotmail':  
                        array_splice($csv['header'],0,1); 
                        array_splice($csv['header'],1,1); 
                        array_splice($csv['header'],2,9); 
                        array_splice($csv['header'],7,6); 
                        array_splice($csv['header'],9,2); 
                        array_splice($csv['header'],10,11); 
                        array_splice($csv['header'],11,5); 
                        array_splice($csv['header'],12,2); 
                        array_splice($csv['header'],13,2); 
                        array_splice($csv['header'],14,27); 
                        foreach($csv['body'] as $k => $content) {
                            array_splice($content,0,1); 
                            array_splice($content,1,1); 
                            array_splice($content,2,9); 
                            array_splice($content,7,6); 
                            array_splice($content,9,2); 
                            array_splice($content,10,11); 
                            array_splice($content,11,5); 
                            array_splice($content,12,2); 
                            array_splice($content,13,2); 
                            array_splice($content,14,27); 
                            $csv['body'][$k] = $content;
                        }
                        foreach($csv['body'] as $k => $content) {  
                            $chars = array('"','\'',"[","]","[","!","#","$","%","&","/","(",")","=","?","\\","¡","¿");
                            $content = str_replace($chars,"",$content);
                            $content = str_replace("-"," ",$content);
                            $content = str_replace("_"," ",$content);
                            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `email` = '".$this->db->escape($content[11])."'");
                            if ((sizeof($query->row) > 0) || empty($content[11]) || empty($content[0]) || empty($content[1])) {
                                continue;
                            } else {
                                $sql = "INSERT INTO " . DB_PREFIX . "customer SET 
                                `firstname` = '".$content[0]."',
                                `lastname` = '".$content[1]."',
                                `fax` = '".$content[7]."',";
                                if (!empty($content[9])) {
                                    $sql .= "`telephone` = '".$content[9]."',";
                                } else {
                                    $sql .= "`telephone` = '".$content[8]."',";                                
                                }
                                $sql .= "`nacimiento` = '".$content[10]."',
                                `email` = '".$content[11]."',
                                `msn` = '".$content[11]."',
                                `website` = '".$content[14]."',
                                `ip` = '".$_SERVER['SERVER_ADDR']."',
                                `newsletter` = '1',
                                `date_added` = NOW()";
                                $this->db->query($sql);                                
                            }
                            //TODO: Limpiar el string del telefono y del fax para pasarlo a formato internacional
                            //TODO: Crear sentencia sql para guardar la dirección en el formato correcto
                            //TODO: Detectar los dominios de los emails alternos para guardarlos donde deben (msn, gmail, yahoo)
                        }
                        break;
                    case 'gmail':
                        array_splice($csv['header'],1,2); 
                        array_splice($csv['header'],2,10);
                        array_splice($csv['header'],3,13); 
                        array_splice($csv['header'],4,1); 
                        array_splice($csv['header'],5,1); 
                        foreach($csv['body'] as $k => $content) {
                        array_splice($content,1,2); 
                        array_splice($content,2,10);
                        array_splice($content,3,13); 
                        array_splice($content,4,1); 
                        array_splice($content,5,1); 
                            $csv['body'][$k] = $content;
                        }                        
                        foreach($csv['body'] as $k => $content) {  
                            $chars = array('"','\'',"[","]","[","!","#","$","%","&","/","(",")","=","?","\\","¡","¿");
                            $content = str_replace($chars,"",$content);
                            $content = str_replace("-"," ",$content);
                            $content = str_replace("_"," ",$content);
                            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `email` = '".$this->db->escape($content[3])."'");
                            if ((sizeof($query->row) > 0) || empty($content[3]) || empty($content[0]) || empty($content[1])) {
                                continue;
                            } else {
                                $sql = "INSERT INTO " . DB_PREFIX . "customer SET 
                                `firstname` = '".$content[0]."',
                                `lastname` = '".$content[1]."',
                                `telephone` = '".$content[5]."',
                                `nacimiento` = '".$content[2]."',
                                `email` = '".$content[3]."',
                                `gmail` = '".$content[3]."',
                                `website` = '".$content[14]."',
                                `ip` = '".$_SERVER['SERVER_ADDR']."',
                                `newsletter` = '1',
                                `date_added` = NOW()";
                                $this->db->query($sql);                                
                            }
                            //TODO: Limpiar el string del telefono y del fax para pasarlo a formato internacional
                            //TODO: Crear sentencia sql para guardar la dirección en el formato correcto
                            //TODO: Detectar los dominios de los emails alternos para guardarlos donde deben (msn, gmail, yahoo)
                            //TODO: Limpiar y acomodar formato de la fecha
                        }
                        break;
                    case 'yahoo':                        
                        array_splice($csv['header'],1,1); 
                        array_splice($csv['header'],2,1);
                        array_splice($csv['header'],3,3); 
                        array_splice($csv['header'],5,1); 
                        array_splice($csv['header'],7,3); 
                        array_splice($csv['header'],11,1); 
                        array_splice($csv['header'],12,5); 
                        array_splice($csv['header'],18,15); 
                        array_splice($csv['header'],19,2);
                        array_splice($csv['header'],21,2); 
                        foreach($csv['body'] as $k => $content) {
                        array_splice($content,1,1); 
                        array_splice($content,2,1);
                        array_splice($content,3,3); 
                        array_splice($content,5,1); 
                        array_splice($content,7,3); 
                        array_splice($content,11,1); 
                        array_splice($content,12,5); 
                        array_splice($content,18,15); 
                        array_splice($content,19,2);
                        array_splice($content,21,2); 
                            $csv['body'][$k] = $content;
                        }   
                        foreach($csv['body'] as $k => $content) {  
                            $chars = array('"','\'',"[","]","[","!","#","$","%","&","/","(",")","=","?","\\","¡","¿");
                            $content = str_replace($chars,"",$content);
                            $content = str_replace("-"," ",$content);
                            $content = str_replace("_"," ",$content);
                            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `email` = '".$this->db->escape($content[2])."'");
                            if ((sizeof($query->row) > 0) || empty($content[2]) || empty($content[0]) || empty($content[1])) {
                                continue;
                            } else {
                                $sql = "INSERT INTO " . DB_PREFIX . "customer SET 
                                `firstname` = '".$content[0]."',
                                `lastname` = '".$content[1]."',
                                `fax` = '".$content[5]."',";
                                if (!empty($content[6])) {
                                    $sql .= "`telephone` = '".$content[6]."',";
                                } else {
                                    $sql .= "`telephone` = '".$content[3]."',";                                
                                }
                                $sql .= "`nacimiento` = '".$content[17]."',
                                `email` = '".$content[2]."',
                                `yahoo` = '".$content[2]."',
                                `website` = '".$content[9]."',
                                `skype` = '".$content[18]."',
                                `gmail` = '".$content[19]."',
                                `msn` = '".$content[20]."',
                                `ip` = '".$_SERVER['SERVER_ADDR']."',
                                `newsletter` = '1',
                                `date_added` = NOW()";
                                $this->db->query($sql);                                
                            }
                            //TODO: Limpiar el string del telefono y del fax para pasarlo a formato internacional
                            //TODO: Crear sentencia sql para guardar la dirección en el formato correcto
                            //TODO: Detectar los dominios de los emails alternos para guardarlos donde deben (msn, gmail, yahoo)
                            //TODO: Limpiar y acomodar formato de la fecha
                        }
                        break;  
                    /* // Para cuando haya la posibilidad de exportar en formato CSV los contactos de facebook                      
                    case 'facebook':                        
                        array_splice($csv['header'],0,1); 
                        array_splice($csv['header'],2,2); 
                        array_splice($csv['header'],3,1); 
                        array_splice($csv['header'],7,4); 
                        array_splice($csv['header'],8,1); 
                        foreach($csv['body'] as $k => $content) {
                        array_splice($content,0,1); 
                        array_splice($content,2,2); 
                        array_splice($content,3,1); 
                        array_splice($content,7,4); 
                        array_splice($content,8,1); 
                            $csv['body'][$k] = $content;
                        }                         
                        foreach($csv['body'] as $k => $content) {  
                            $chars = array('"','\'',"[","]","[","!","#","$","%","&","/","(",")","=","?","\\","¡","¿");
                            $content = str_replace($chars,"",$content);
                            $content = str_replace("-"," ",$content);
                            $content = str_replace("_"," ",$content);
                            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `facebook` = '".$this->db->escape($content[7])."'");
                            if ((sizeof($query->row) > 0) || empty($content[7]) || empty($content[0]) || empty($content[1])) {
                                continue;
                            } else {
                                $sql = "INSERT INTO " . DB_PREFIX . "customer SET 
                                `firstname` = '".$content[0]."',
                                `lastname` = '".$content[1]."',
                                `nacimiento` = '".$content[2]."',
                                `facebook` = '".$content[7]."',
                                `ip` = '".$_SERVER['SERVER_ADDR']."',
                                `newsletter` = '1',
                                `date_added` = NOW()";
                                $this->db->query($sql);                                
                            }
                            //TODO: Limpiar el string del telefono y del fax para pasarlo a formato internacional
                            //TODO: Crear sentencia sql para guardar la dirección en el formato correcto
                            //TODO: Detectar los dominios de los emails alternos para guardarlos donde deben (msn, gmail, yahoo)
                            //TODO: Limpiar y acomodar formato de la fecha
                        }     
                        break;
                        */
                    default:                        
                        foreach($csv['body'] as $k => $content) {  
                            $chars = array('"','\'',"[","]","[","!","#","$","%","&","/","(",")","=","?","\\","¡","¿");
                            $content = str_replace($chars,"",$content);
                            $content = str_replace("-"," ",$content);
                            $content = str_replace("_"," ",$content);
                            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `email` = '".$this->db->escape($content[2])."'");
                            if ((sizeof($query->row) > 0) || empty($content[2]) || empty($content[0]) || empty($content[1])) {
                                continue;
                            } else {
                                $sql = "INSERT INTO " . DB_PREFIX . "customer SET 
                                `firstname` = '".$content[0]."',
                                `lastname` = '".$content[1]."',
                                `email` = '".$content[2]."',
                                `telephone` = '".$content[3]."',
                                `fax` = '".$content[4]."',
                                `company` = '".$content[5]."',
                                `rif` = '".$content[6]."',
                                `website` = '".$content[8]."',
                                `blog` = '".$content[9]."',
                                `msn` = '".$content[10]."',
                                `gmail` = '".$content[1]."',
                                `yahoo` = '".$content[12]."',
                                `facebook` = '".$content[13]."',
                                `twitter` = '".$content[14]."',
                                `skype` = '".$content[15]."',
                                `titulo` = '".$content[16]."',
                                `profesion` = '".$content[17]."',
                                `ip` = '".$_SERVER['SERVER_ADDR']."',
                                `newsletter` = '1',
                                `date_added` = NOW()";
                                $this->db->query($sql);                                
                            }
                            //TODO: Limpiar el string del telefono y del fax para pasarlo a formato internacional
                            //TODO: Crear sentencia sql para guardar la dirección en el formato correcto
                            //TODO: Detectar los dominios de los emails alternos para guardarlos donde deben (msn, gmail, yahoo)
                            //TODO: Limpiar y acomodar formato de la fecha
                            }
                        break;        
                } 
          } else { 
            echo "<script>alert('$errormsg');</script>";
        }
        } 
  	  }
		$this->load->language('email/member');
		 
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('email/member');
		
    	$this->getImportList();
  	}
    
    public function addMemberToList() {	
		$this->load->model('email/lists');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_email_lists->addMemberToList($this->request->post);
		}
  	}
    public function addMemberToAllLists() {	
		$this->load->model('email/lists');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_email_lists->addMemberToAllLists($this->request->post);
		}
  	}
    public function deleteMemberFromList() {	
		$this->load->model('email/lists');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_email_lists->deleteMemberFromList($this->request->post);
		}
  	}
    public function deleteMemberFromAllLists() {	
		$this->load->model('email/lists');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_email_lists->deleteMemberFromAllLists($this->request->post);
		}
  	}
    
    public function exportThis() {	
		$this->load->model('email/member');
        $dir_vcards = opendir($_SERVER['DOCUMENT_ROOT']);
        while ($file_vcf = readdir($dir_vcards) !== false) {
            if (!is_dir($_SERVER['DOCUMENT_ROOT'].$file_vcf)) {
                $path_vcf = pathinfo($_SERVER['DOCUMENT_ROOT'].$file_vcf);
                if ($path_vcf['extension'] === 'vcf') {
                    unlink($path_vcf['dirname'].'/'.$path_vcf['basename'].'.'.$path_vcf['extension']);
                }
            }
        }
		$member_info = $this->model_email_member->getMemberExport($this->request->get['member_id']);
        if ($member_info) {
            $rand = rand();
            $this->vcard->vCard($this->config,$_SERVER['DOCUMENT_ROOT']);
            $this->vcard->deleteOldFiles();
                $this->vcard->card_filename = $member_info['firstname'].'_'.$member_info['lastname'].'_'.$rand.'.vcf';
                $this->vcard->setFirstName($member_info['firstname']);
                $this->vcard->setLastName($member_info['lastname']);
                $this->vcard->setNickname($member_info['firstname'].'_'.$member_info['lastname']);
                $this->vcard->setCompany($member_info['company']);
                $this->vcard->setOrganisation($member_info['company']);
                $this->vcard->setDepartment($member_info['profesion']);
                $this->vcard->setJobTitle($member_info['titulo']);
                $this->vcard->setTelephoneWork1($member_info['telephone']);
                $this->vcard->setTelephoneWork2($member_info['telephone']);
                $this->vcard->setTelephoneHome1($member_info['telephone']);
                $this->vcard->setTelephoneHome2($member_info['telephone']);
                $this->vcard->setCellphone($member_info['telephone']);
                $this->vcard->setCarphone($member_info['telephone']);
                $this->vcard->setPager($member_info['telephone']);
                $this->vcard->setAdditionalTelephone($member_info['telephone']);
                $this->vcard->setFaxWork($member_info['fax']);
                $this->vcard->setFaxHome($member_info['fax']);
                $this->vcard->setPreferredTelephone($member_info['telephone']);
                $this->vcard->setTelex($member_info['telephone']);
                $this->vcard->setWorkStreet($member_info['address_1'].', '.$member_info['city']);
                $this->vcard->setHomeStreet($member_info['address_1'].', '.$member_info['city']);
                $this->vcard->setPostalStreet($member_info['address_1'].', '.$member_info['city']);
                $this->vcard->setURLWork($member_info['website']);
                $this->vcard->setEMail($member_info['email']);
                $this->vcard->writeCardFile();                  
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/'.$member_info['firstname'].'_'.$member_info['lastname'].'_'.$rand.'.vcf');   
            }
        $dir_vcards = opendir($_SERVER['DOCUMENT_ROOT']);
        while ($file_vcf = readdir($dir_vcards) !== false) {
            if (!is_dir($_SERVER['DOCUMENT_ROOT'].$file_vcf)) {
                $path_vcf = pathinfo($_SERVER['DOCUMENT_ROOT'].$file_vcf);
                if ($path_vcf['extension'] === 'vcf') {
                    unlink($path_vcf['dirname'].'/'.$path_vcf['basename'].'.'.$path_vcf['extension']);
                }
            }
        }
  	}
    
  	public function update() {
		$this->load->language('email/member');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('email/member');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_customer->editMember($this->request->get['member_id'], $this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			
			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . $this->request->get['filter_email'];
			}
			
			if (isset($this->request->get['filter_newsletter'])) {
				$url .= '&filter_newsletter=' . $this->request->get['filter_newsletter'];
			}
		
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
						
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->redirect(HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'] . $url);
		}
    
    	$this->getForm();
  	}    
    
  	private function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name'; 
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = NULL;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = NULL;
		}

		if (isset($this->request->get['filter_newsletter'])) {
			$filter_newsletter = $this->request->get['filter_newsletter'];
		} else {
			$filter_newsletter= NULL;
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = NULL;
		}		
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_newsletter'])) {
			$url .= '&filter_newsletter=' . $this->request->get['filter_newsletter'];
		}
        
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'] . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
        $this->data['insert'] = HTTPS_SERVER . 'index.php?route=email/member/insert&token=' . $this->session->data['token'] . $url;
		
		$this->data['members'] = array();

		$data = array(
			'filter_name'              => $filter_name, 
			'filter_email'             => $filter_email,  
			'filter_newsletter'        => $filter_newsletter, 
			'filter_date_added'        => $filter_date_added,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		);
		
		$member_total = $this->model_email_member->getTotalMembers($data);
	
		$results = $this->model_email_member->getMembers($data);
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => HTTPS_SERVER . 'index.php?route=email/member/update&token=' . $this->session->data['token'] . '&member_id=' . $result['customer_id'] . $url
			);
			$totalByList = $this->model_email_member->getTotalMembersByList($result['customer_id']);
			$this->data['members'][] = array(
				'customer_id'    => $result['customer_id'],
				'name'           => $result['name'],
				'firstname'      => $result['firstname'],
				'lastname'       => $result['lastname'],
				'telephone'      => $result['telephone'],
				'fax'            => $result['fax'],
				'rif'            => $result['rif'],
				'company'        => $result['company'],
				'blog'           => $result['blog'],
				'website'        => $result['website'],
				'profesion'      => $result['profesion'],
				'titulo'         => $result['titulo'],
				'msn'            => $result['msn'],
				'city'           => $result['city'],
				'address_1'      => $result['address_1'],
				'twitter'        => $result['twitter'],
				'facebook'       => $result['facebook'],
				'skype'          => $result['skype'],
				'yahoo'          => $result['yahoo'],
				'gmail'          => $result['gmail'],
				'email'          => $result['email'],
				'total'          => $totalByList['total'],
				'newsletter'     => ($result['newsletter'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'approved'       => ($result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'       => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
				'action'         => $action
			);
		}        
        $this->data['content_excel'] = "Nombre\tApellido\tEmail\tTelefono\tFax\tCompany\tRIF\tDireccion\tWebsite\tBlog\tMSN\tGmail\tYahoo\tFacebook\tTwitter\Skype\tTitulo\tProfesion\tCreado\t\n";
        $this->data['content_csv']   ="Nombre,Apellido,Email,Telefono,Fax,Company,RIF,Direccion,Website,Blog,MSN,Gmail,Yahoo,Facebook,Twitter,Skype,Titulo,Profesion,Creado\n";
        foreach ($this->data['members'] as $member) { 
                $this->data['content_excel'] .= $member['firstname']."\t".$member['lastname']."\t".$member['email']."\t".$member['telephone']."\t".$member['fax']."\t".$member['company']."\t".$member['rif']."\t".$member['address_1'].", ".$member['city']."\t".$member['website']."\t".$member['blog']."\t".$member['msn']."\t".$member['gmail']."\t".$member['yahoo']."\t".$member['facebook']."\t".$member['twitter']."\t".$member['skype']."\t".$member['titulo']."\t".$member['profesion']."\t".$member['date_added']."\t\n";
                $this->data['content_csv'] .= $member['firstname'].",".$member['lastname'].",".$member['email'].",".$member['telephone'].",".$member['fax'].",".$member['company'].",".$member['rif'].",".$member['address_1'].", ".$member['city'].",".$member['website'].",".$member['blog'].",".$member['msn'].",".$member['gmail'].",".$member['yahoo'].",".$member['facebook'].",".$member['twitter'].",".$member['skype'].",".$member['titulo'].",".$member['profesion'].",".$member['date_added'].",\n";
                $this->data['content_vcard'] = 
                    "BEGIN:VCARD
                    VERSION:2.1
                    N;ENCODING=QUOTED-PRINTABLE:".$member['lastname'].";".$member['firstname'].";;
                    FN;ENCODING=QUOTED-PRINTABLE:".$member['firstname']."  ".$member['lastname']." 
                    NICKNAME;ENCODING=QUOTED-PRINTABLE:".$member['firstname']."_".$member['lastname']."
                    ORG;LANGUAGE=es;ENCODING=QUOTED-PRINTABLE:".$member['company'].";".$member['profesion']."
                    TITLE;LANGUAGE=es;ENCODING=QUOTED-PRINTABLE:".$member['titulo']."
                    TEL;WORK;VOICE:".$member['telephone']."
                    TEL;WORK;VOICE:".$member['telephone']."
                    TEL;HOME;VOICE:".$member['telephone']."
                    TEL;CELL;VOICE:".$member['telephone']."
                    TEL;CAR;VOICE:".$member['telephone']."
                    TEL;VOICE:".$member['telephone']."
                    TEL;PAGER;VOICE:".$member['telephone']."
                    TEL;WORK;FAX:".$member['fax']."
                    TEL;HOME:".$member['telephone']."
                    TEL;PREF:".$member['telephone']."
                    ADR;WORK:;".$member['address_1'].", ".$member['city'].";;;;
                    LABEL;WORK;ENCODING=QUOTED-PRINTABLE:".$member['company']."=0D=0A".$member['address_1'].", ".$member['city']." =0D=0A,  =0D=0A
                    ADR;HOME;;".$member['address_1'].", ".$member['city']." ;;;;
                    LABEL;WORK;ENCODING=QUOTED-PRINTABLE:".$member['address_1'].", ".$member['city']." =0D=0A,  =0D=0A
                    ADR;POSTAL;;".$member['address_1'].", ".$member['city']." ;;;;
                    LABEL;POSTAL;ENCODING=QUOTED-PRINTABLE:".$member['address_1'].", ".$member['city']." =0D=0A,  =0D=0A
                    URL;WORK:".$member['website']."
                    EMAIL;PREF;INTERNET:".$member['email']."
                    EMAIL;TLX:+581234567890
                    REV:08102010T103800Z
                    END:VCARD";
        }	
					
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_newsletter'] = $this->language->get('column_newsletter');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_approve'] = $this->language->get('button_approve');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];
			
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_newsletter'])) {
			$url .= '&filter_newsletter=' . $this->request->get['filter_newsletter'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'] . '&sort=name' . $url;
		$this->data['sort_email'] = HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'] . '&sort=email' . $url;
		$this->data['sort_newsletter'] = HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'] . '&sort=newsletter' . $url;
		$this->data['sort_date_added'] = HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'] . '&sort=date_added' . $url;
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_newsletter'])) {
			$url .= '&filter_newsletter=' . $this->request->get['filter_newsletter'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $member_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'] . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_newsletter'] = $filter_newsletter;
		$this->data['filter_date_added'] = $filter_date_added;
		
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'email/member_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    private function getExportList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name'; 
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = NULL;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = NULL;
		}

		if (isset($this->request->get['filter_newsletter'])) {
			$filter_newsletter = $this->request->get['filter_newsletter'];
		} else {
			$filter_newsletter= NULL;
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = NULL;
		}		
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_newsletter'])) {
			$url .= '&filter_newsletter=' . $this->request->get['filter_newsletter'];
		}
        
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
						
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'] . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=email/member/export&token=' . $this->session->data['token'] . $url,
       		'text'      => $this->language->get('heading_export'),
      		'separator' => ' :: '
   		);
		
		$this->data['members'] = array();

		$data = array(
			'filter_name'              => $filter_name, 
			'filter_email'             => $filter_email,  
			'filter_newsletter'        => $filter_newsletter, 
			'filter_date_added'        => $filter_date_added,
			'sort'                     => $sort,
			'order'                    => $order
		);
		
		$member_total = $this->model_email_member->getTotalMembers($data);
	
		$results = $this->model_email_member->getMembers($data);
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_export'),
				'href' => HTTPS_SERVER . 'index.php?route=email/member/exportThis&token=' . $this->session->data['token'] . '&member_id=' . $result['customer_id'] . $url
			);
			$totalByList = $this->model_email_member->getTotalMembersByList($result['customer_id']);
			$this->data['members'][] = array(
				'customer_id'    => $result['customer_id'],
				'name'           => $result['name'],
				'firstname'      => $result['firstname'],
				'lastname'       => $result['lastname'],
				'telephone'      => $result['telephone'],
				'fax'            => $result['fax'],
				'rif'            => $result['rif'],
				'company'        => $result['company'],
				'blog'           => $result['blog'],
				'website'        => $result['website'],
				'profesion'      => $result['profesion'],
				'titulo'         => $result['titulo'],
				'msn'            => $result['msn'],
				'city'           => $result['city'],
				'address_1'      => $result['address_1'],
				'twitter'        => $result['twitter'],
				'facebook'       => $result['facebook'],
				'skype'          => $result['skype'],
				'yahoo'          => $result['yahoo'],
				'gmail'          => $result['gmail'],
				'email'          => $result['email'],
				'total'          => $totalByList['total'],
				'newsletter'     => ($result['newsletter'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'approved'       => ($result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'       => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
				'action'         => $action
			);
		}          
        $this->data['content_excel'] = "Nombre\tApellido\tEmail\tTelefono\tFax\tCompany\tRIF\tDireccion\tWebsite\tBlog\tMSN\tGmail\tYahoo\tFacebook\tTwitter\Skype\tTitulo\tProfesion\tCreado\t\n";
        $this->data['content_csv']   ="Nombre,Apellido,Email,Telefono,Fax,Company,RIF,Direccion,Website,Blog,MSN,Gmail,Yahoo,Facebook,Twitter,Skype,Titulo,Profesion,Creado\n";
        foreach ($this->data['members'] as $member) { 
                $this->data['content_excel'] .= $member['firstname']."\t".$member['lastname']."\t".$member['email']."\t".$member['telephone']."\t".$member['fax']."\t".$member['company']."\t".$member['rif']."\t".$member['address_1'].", ".$member['city']."\t".$member['website']."\t".$member['blog']."\t".$member['msn']."\t".$member['gmail']."\t".$member['yahoo']."\t".$member['facebook']."\t".$member['twitter']."\t".$member['skype']."\t".$member['titulo']."\t".$member['profesion']."\t".$member['date_added']."\t\n";
                $this->data['content_csv'] .= $member['firstname'].",".$member['lastname'].",".$member['email'].",".$member['telephone'].",".$member['fax'].",".$member['company'].",".$member['rif'].",".$member['address_1'].", ".$member['city'].",".$member['website'].",".$member['blog'].",".$member['msn'].",".$member['gmail'].",".$member['yahoo'].",".$member['facebook'].",".$member['twitter'].",".$member['skype'].",".$member['titulo'].",".$member['profesion'].",".$member['date_added'].",\n";
                $this->data['content_vcard'] = 
                    "BEGIN:VCARD
                    VERSION:2.1
                    N;ENCODING=QUOTED-PRINTABLE:".$member['lastname'].";".$member['firstname'].";;
                    FN;ENCODING=QUOTED-PRINTABLE:".$member['firstname']."  ".$member['lastname']." 
                    NICKNAME;ENCODING=QUOTED-PRINTABLE:".$member['firstname']."_".$member['lastname']."
                    ORG;LANGUAGE=es;ENCODING=QUOTED-PRINTABLE:".$member['company'].";".$member['profesion']."
                    TITLE;LANGUAGE=es;ENCODING=QUOTED-PRINTABLE:".$member['titulo']."
                    TEL;WORK;VOICE:".$member['telephone']."
                    TEL;WORK;VOICE:".$member['telephone']."
                    TEL;HOME;VOICE:".$member['telephone']."
                    TEL;CELL;VOICE:".$member['telephone']."
                    TEL;CAR;VOICE:".$member['telephone']."
                    TEL;VOICE:".$member['telephone']."
                    TEL;PAGER;VOICE:".$member['telephone']."
                    TEL;WORK;FAX:".$member['fax']."
                    TEL;HOME:".$member['telephone']."
                    TEL;PREF:".$member['telephone']."
                    ADR;WORK:;".$member['address_1'].", ".$member['city'].";;;;
                    LABEL;WORK;ENCODING=QUOTED-PRINTABLE:".$member['company']."=0D=0A".$member['address_1'].", ".$member['city']." =0D=0A,  =0D=0A
                    ADR;HOME;;".$member['address_1'].", ".$member['city']." ;;;;
                    LABEL;WORK;ENCODING=QUOTED-PRINTABLE:".$member['address_1'].", ".$member['city']." =0D=0A,  =0D=0A
                    ADR;POSTAL;;".$member['address_1'].", ".$member['city']." ;;;;
                    LABEL;POSTAL;ENCODING=QUOTED-PRINTABLE:".$member['address_1'].", ".$member['city']." =0D=0A,  =0D=0A
                    URL;WORK:".$member['website']."
                    EMAIL;PREF;INTERNET:".$member['email']."
                    EMAIL;TLX:+581234567890
                    REV:08102010T103800Z
                    END:VCARD";
        }			
		$this->data['heading_title'] = $this->language->get('heading_export');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_newsletter'] = $this->language->get('column_newsletter');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_approve'] = $this->language->get('button_approve');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];
			
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}
			
		if (isset($this->request->get['filter_newsletter'])) {
			$url .= '&filter_newsletter=' . $this->request->get['filter_newsletter'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=email/member/export&token=' . $this->session->data['token'] . '&sort=name' . $url;
		$this->data['sort_email'] = HTTPS_SERVER . 'index.php?route=email/member/export&token=' . $this->session->data['token'] . '&sort=email' . $url;
		$this->data['sort_newsletter'] = HTTPS_SERVER . 'index.php?route=email/member/export&token=' . $this->session->data['token'] . '&sort=newsletter' . $url;
		$this->data['sort_date_added'] = HTTPS_SERVER . 'index.php?route=email/member/export&token=' . $this->session->data['token'] . '&sort=date_added' . $url;
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		
		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . $this->request->get['filter_email'];
		}

		if (isset($this->request->get['filter_newsletter'])) {
			$url .= '&filter_newsletter=' . $this->request->get['filter_newsletter'];
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_newsletter'] = $filter_newsletter;
		$this->data['filter_date_added'] = $filter_date_added;
		
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'email/member_export.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    private function getImportList() {
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'] . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=email/member/import&token=' . $this->session->data['token'] . $url,
       		'text'      => $this->language->get('heading_import'),
      		'separator' => ' :: '
   		);
					
		$this->data['heading_title'] = $this->language->get('heading_import');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->session->data['error'])) {
			$this->data['error_warning'] = $this->session->data['error'];
			
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
        
        $this->data['action'] = HTTPS_SERVER . 'index.php?route=email/member/import&token=' . $this->session->data['token'];
		
		$this->template = 'email/member_import.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
  	
  	public function getForm() {
		$this->load->model('email/lists');
        $this->load->model('email/member');
        $this->load->model('sale/customer');
		if (isset($this->request->get['member_id'])) {
             $member_info = $this->model_email_member->getMember($this->request->get['member_id']);
             $this->data['listsByMember'] = $this->model_email_lists->getListByMember($this->request->get['member_id']);
             $lists = $this->model_email_lists->getAllLists();
             $customer_info = $this->model_sale_customer->getCustomer($this->request->get['member_id']);
        }
        $this->data['lists'] = array();
        foreach ($this->data['listsByMember'] as $list) {
            $this->data['lists'][] = $this->model_email_lists->getFullLists($list['list_id'],1);
        }
        
        $this->data['other_list_a'] = array();
        $this->data['other_list_b'] = array();
        $this->data['other_lists'] = array();
        foreach($lists as $list) {
            $this->data['other_list_a'][] = $list['list_id'];
        }
        foreach ($this->data['listsByMember'] as $list) {
            $this->data['other_list_b'][] = $list['list_id'];
        }
        $lists = array_diff($this->data['other_list_a'],$this->data['other_list_b']);
        foreach ($lists as $list) {
            $this->data['other_lists'][] = $this->model_email_lists->getFullLists($list['list_id'],1);
        }
        
			$this->load->language('email/member');
		 
			$this->document->title = $this->language->get('heading_title');
			
			$this->data['heading_title'] = $this->language->get('heading_title');
            
			$this->data['entry_list_id'] = $this->language->get('entry_list_id');
			$this->data['entry_customer_id'] = $this->language->get('entry_customer_id');
    		$this->data['entry_name'] = $this->language->get('entry_name');
        	$this->data['entry_facebook'] = $this->language->get('entry_facebook');
        	$this->data['entry_twitter'] = $this->language->get('entry_twitter');
        	$this->data['entry_msn'] = $this->language->get('entry_msn');
        	$this->data['entry_yahoo'] = $this->language->get('entry_yahoo');
        	$this->data['entry_gmail'] = $this->language->get('entry_gmail');
        	$this->data['entry_skype'] = $this->language->get('entry_skype');
        	$this->data['entry_blog'] = $this->language->get('entry_blog');
    		$this->data['entry_website'] = $this->language->get('entry_website');
        	$this->data['entry_email'] = $this->language->get('entry_email');
        	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
        	$this->data['entry_fax'] = $this->language->get('entry_fax');
			$this->data['entry_notify'] = $this->language->get('entry_notify');	
			$this->data['entry_true'] = $this->language->get('entry_true');	
			$this->data['entry_false'] = $this->language->get('entry_false');
			$this->data['entry_category'] = $this->language->get('entry_category');	
			$this->data['entry_member'] = $this->language->get('entry_member');	
            
			$this->data['button_cancel'] = $this->language->get('button_cancel');
            
			$this->data['token'] = $this->session->data['token'];
			
			$this->document->breadcrumbs = array();
	
			$this->document->breadcrumbs[] = array(
				'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
				'text'      => $this->language->get('text_home'),
				'separator' => false
			);
	
			$this->document->breadcrumbs[] = array(
				'href'      => HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'],
				'text'      => $this->language->get('heading_title'),
				'separator' => ' :: '
			);
            
            if (isset($this->error['warning'])) {
    			$this->data['error_warning'] = $this->error['warning'];
    		} else {
    			$this->data['error_warning'] = '';
    		}
            $this->data['lista'] =  HTTPS_SERVER . 'index.php?route=email/lists/update&token=' . $this->session->data['token']. '&list_id=';
			$this->data['categoria'] =  HTTPS_SERVER . 'index.php?route=catalog/category/update&token=' . $this->session->data['token']. '&category_id=';
			$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=email/member&token=' . $this->session->data['token'];
            
			if (isset($this->request->get['member_id'])) {
      			$member_info = $this->model_email_member->getMember($this->request->get['member_id']);
    		} else {
    			$member_info = array();
			}

			if (isset($customer_info['firstname'])) {
				$this->data['name'] = ucwords($customer_info['firstname']. ' ' .$customer_info['lastname']);
			} else {
				$this->data['name'] = '';
			}

			if (isset($customer_info['email'])) {
				$this->data['email'] = $customer_info['email'];
			} else {
				$this->data['email'] = '';
			}

			 $this->data['customer'] = HTTPS_SERVER . 'index.php?route=sale/customer/update&token=' . $this->session->data['token'] . '&customer_id='.$this->request->get['member_id'];

			if (isset($customer_info['facebook'])) {
				$this->data['facebook'] = $customer_info['facebook'];
			} else {
				$this->data['facebook'] = '';
			}

			if (isset($customer_info['twitter'])) {
				$this->data['twitter'] = $customer_info['twitter'];
			} else {
				$this->data['twitter'] = '';
			}

			if (isset($customer_info['skype'])) {
				$this->data['skype'] = $customer_info['skype'];
			} else {
				$this->data['skype'] = '';
			}

			if (isset($customer_info['blog'])) {
				$this->data['blog'] = $customer_info['blog'];
			} else {
				$this->data['blog'] = '';
			}

			if (isset($customer_info['website'])) {
				$this->data['website'] = $customer_info['website'];
			} else {
				$this->data['website'] = '';
			}

			if (isset($customer_info['gmail'])) {
				$this->data['gmail'] = $customer_info['gmail'];
			} else {
				$this->data['gmail'] = '';
			}

			if (isset($customer_info['yahoo'])) {
				$this->data['yahoo'] = $customer_info['yahoo'];
			} else {
				$this->data['yahoo'] = '';
			}

			if (isset($customer_info['msn'])) {
				$this->data['msn'] = $customer_info['msn'];
			} else {
				$this->data['msn'] = '';
			}

			if (isset($customer_info['telephone'])) {
				$this->data['telephone'] = $customer_info['telephone'];
			} else {
				$this->data['telephone'] = '';
			}

			if (isset($customer_info['fax'])) {
				$this->data['fax'] = $customer_info['fax'];
			} else {
				$this->data['fax'] = '';
			}     
			
			if (isset($this->request->post['date_added'])) {
				$this->data['date_added'] = $this->request->post['date_added'];
			} elseif (isset($list_info['date_added'])) {
				$this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($list_info['date_added'])); 
			} else {
				$this->data['date_added'] = date($this->language->get('date_format_short'), time()); 
			}
            
            $this->load->model('sale/customer');
    				
    		$this->data['customers'] = $this->model_sale_customer->getCustomerBySubscribe();
    		
    		if (isset($this->request->post['customer_id'])) {
    			$this->data['customer_id'] = $this->request->post['customer_id'];
    		} elseif (isset($list_info)) {
    			$this->data['customer_id'] = $this->model_email_lists->getMembers($this->request->get['list_id']);
    		} else {
    			$this->data['customer_id'] = array();
    		}
            
			$this->data['token'] = $this->session->data['token'];
			
			$this->template = 'email/member_form.tpl';
			$this->children = array(
				'common/header',	
				'common/footer'
			);
			
			$this->response->setOutput($this->render(true), $this->config->get('config_compression')); 
		
  	}
	 
  	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'sale/customer')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}    
}
?>