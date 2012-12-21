<?php    
class ControllerMarketingContact extends Controller { 
	private $error = array();
  
  	public function index() {		 
		$this->document->title = $this->language->get('heading_title');
		
    	$this->getList();
  	}
    
    public function export() {
		$this->load->language('marketing/contact');
		 
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->auto('marketing/contact');
		
    	$this->getExportList();
  	}
    
    public function import() {
        
        $error = false;
        $errormsg = '';
		$this->load->auto('marketing/contact');
		$member_info = $this->modelemail_member->getContactExport($this->request->get['member_id']);
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
		$this->load->language('marketing/contact');
		 
		$this->document->title = $this->language->get('heading_title');
		
		$this->load->auto('marketing/contact');
		
    	$this->getImportList();
  	}
    
    public function addContactToList() {	
		$this->load->auto('marketing/lists');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelemail_lists->addContactToList($this->request->post);
		}
  	}
    public function addContactToAllLists() {	
		$this->load->auto('marketing/lists');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelemail_lists->addContactToAllLists($this->request->post);
		}
  	}
    
    /**
     * ControllerMarketingContact::delete()
     * elimina un objeto
     * @return boolean
     * */
     public function delete() {
        $this->load->auto('marketing/contact');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['selected'] as $id) {
                $this->modelContact->delete($id);
            }
		} else {
            $this->modelContact->delete($_GET['id']);
		}
     }
    
    public function exportThis() {	
		$this->load->auto('marketing/contact');
        $dir_vcards = opendir($_SERVER['DOCUMENT_ROOT']);
        while ($file_vcf = readdir($dir_vcards) !== false) {
            if (!is_dir($_SERVER['DOCUMENT_ROOT'].$file_vcf)) {
                $path_vcf = pathinfo($_SERVER['DOCUMENT_ROOT'].$file_vcf);
                if ($path_vcf['extension'] === 'vcf') {
                    unlink($path_vcf['dirname'].'/'.$path_vcf['basename'].'.'.$path_vcf['extension']);
                }
            }
        }
		$member_info = $this->modelemail_member->getContactExport($this->request->get['member_id']);
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
		$this->load->language('marketing/contact');

    	$this->document->title = $this->language->get('heading_title');
		
		$this->load->auto('marketing/contact');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->modelCustomer->editContact($this->request->get['member_id'], $this->request->post);
	  		
			$this->session->set('success',$this->language->get('text_success'));
	  
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
			
			$this->redirect(Url::createAdminUrl('marketing/contact') . $url);
		}
    
    	$this->getForm();
  	}    
    
  	private function getList() {
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('marketing/contact') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
        $this->data['insert'] = Url::createAdminUrl('marketing/contact/insert') . $url;
        $this->data['import'] = Url::createAdminUrl('marketing/contact/import');
        $this->data['export'] = Url::createAdminUrl('marketing/contact/export');
		
		$this->data['heading_title'] = $this->document->title = $this->language->get('heading_title');

		$this->data['button_import'] = $this->language->get('button_import');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_export'] = $this->language->get('button_export');

		if ($this->session->has('error')) {
			$this->data['error_warning'] = $this->session->get('error');
			$this->session->clear('error');
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if ($this->session->has('success')) {
			$this->data['success'] = $this->session->get('success');
		
			$this->session->clear('success');
		} else {
			$this->data['success'] = '';
		}
		
        // SCRIPTS
        $scripts[] = array('id'=>'list','method'=>'function','script'=>
            "function editAll() {
                return false;
            } 
            function addToList() {
                return false;
            } 
            function deleteAll() {
                if (confirm('¿Desea eliminar todos los objetos seleccionados?')) {
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                    $.post('". Url::createAdminUrl("marketing/contact/delete") ."',$('#form').serialize(),function(){
                        $('#gridWrapper').load('". Url::createAdminUrl("marketing/contact/grid") ."',function(){
                            $('#gridWrapper').show();
                            $('#gridPreloader').hide();
                        });
                    });
                }
                return false;
            } 
            function eliminar(e) {
                if (confirm('¿Desea eliminar este objeto?')) {
                    $('#tr_' + e).remove();
                	$.getJSON('". Url::createAdminUrl("marketing/contact/delete") ."',{
                        id:e
                    });
                }
                return false;
             }");
        $scripts[] = array('id'=>'sortable','method'=>'ready','script'=>
            "$('#gridWrapper').load('". Url::createAdminUrl("marketing/contact/grid") ."',function(e){
                $('#gridPreloader').hide();
            });
                
            $('#formFilter').ntForm({
                lockButton:false,
                ajax:true,
                type:'get',
                dataType:'html',
                url:'". Url::createAdminUrl("marketing/contact/grid") ."',
                beforeSend:function(){
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                },
                success:function(data){
                    $('#gridPreloader').hide();
                    $('#gridWrapper').html(data).show();
                }
            });");
             
        $this->scripts = array_merge($this->scripts,$scripts);
        
		$this->template = 'marketing/contact_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
  	public function grid() {
        $filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
		$filter_email = isset($this->request->get['filter_email']) ? $this->request->get['filter_email'] : null;
		$filter_status = isset($this->request->get['filter_status']) ? $this->request->get['filter_status'] : null;
		$filter_date_start = isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
		$filter_date_end = isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'name';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');
		
		$url = '';
			
		if (isset($this->request->get['filter_name'])) { $url .= '&filter_name=' . $this->request->get['filter_name']; } 
		if (isset($this->request->get['filter_email'])) { $url .= '&filter_email=' . $this->request->get['filter_email']; } 
		if (isset($this->request->get['filter_status'])) { $url .= '&filter_status=' . $this->request->get['filter_status']; } 
		if (isset($this->request->get['filter_date_start'])) { $url .= '&filter_date_start=' . $this->request->get['filter_date_start']; }
		if (isset($this->request->get['filter_date_end'])) { $url .= '&filter_date_end=' . $this->request->get['filter_date_end']; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (!empty($this->request->get['limit'])) { $url .= '&limit=' . $this->request->get['limit']; } 

		$this->data['members'] = array();

		$data = array(
			'filter_name'              => $filter_name, 
			'filter_email'             => $filter_email,  
			'filter_date_start'        => $filter_date_start, 
			'filter_date_end'          => $filter_date_end,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $limit
		);
		
		$member_total = $this->modelContact->getTotalContacts($data);
	
		$results = $this->modelContact->getContacts($data);
 
    	foreach ($results as $result) {
			$action = array();
		
		    $action['edit'] = array(
                'action'  => 'edit',
                'text'  => $this->language->get('text_edit'),
                'href'  =>Url::createAdminUrl('marketing/contact/update') . '&newsletter_id=' . $result['newsletter_id'] . $url,
                'img'   => 'edit.png'
   			);
            
		    $action['delete'] = array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
   			);
            
			$this->data['contacts'][] = array(
				'contact_id'    => $result['contact_id'],
				'customer_id'    => $result['customer_id'],
				'name'           => $result['name'],
				'firstname'      => $result['firstname'],
				'lastname'       => $result['lastname'],
				'telephone'      => ($result['telephone']) ? $result['telephone'] : 'N/A',
				'email'          => is_numeric($result['mail']) ? '<a href="http://www.facebook.com/'. $result['mail'] .'" tagret="_blank">Perfil Facebook</a>' : '<a href="mailto:'. $result['mail'] .'">'. $result['mail'] .'</a>',
				'date_added'     => date('d-m-Y h:i:s', strtotime($result['created'])),
				'selected'       => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
				'action'         => $action
			);
            /* //TODO: download vcard of each contact
            $this->data['content_vcard'] = 
            "BEGIN:VCARD
            VERSION:2.1
            N;ENCODING=QUOTED-PRINTABLE:".$result['lastname'].";".$result['firstname'].";;
            FN;ENCODING=QUOTED-PRINTABLE:".$result['firstname']."  ".$result['lastname']." 
            NICKNAME;ENCODING=QUOTED-PRINTABLE:".$result['firstname']."_".$result['lastname']."
            ORG;LANGUAGE=es;ENCODING=QUOTED-PRINTABLE:".$result['company'].";".$result['profesion']."
            TITLE;LANGUAGE=es;ENCODING=QUOTED-PRINTABLE:".$result['titulo']."
            TEL;WORK;VOICE:".$result['telephone']."
            TEL;WORK;VOICE:".$result['telephone']."
            TEL;HOME;VOICE:".$result['telephone']."
            TEL;CELL;VOICE:".$result['telephone']."
            TEL;CAR;VOICE:".$result['telephone']."
            TEL;VOICE:".$result['telephone']."
            TEL;PAGER;VOICE:".$result['telephone']."
            TEL;WORK;FAX:".$result['fax']."
            TEL;HOME:".$result['telephone']."
            TEL;PREF:".$result['telephone']."
            ADR;WORK:;".$result['address_1'].", ".$result['city'].";;;;
            LABEL;WORK;ENCODING=QUOTED-PRINTABLE:".$result['company']."=0D=0A".$result['address_1'].", ".$result['city']." =0D=0A,  =0D=0A
            ADR;HOME;;".$result['address_1'].", ".$result['city']." ;;;;
            LABEL;WORK;ENCODING=QUOTED-PRINTABLE:".$result['address_1'].", ".$result['city']." =0D=0A,  =0D=0A
            ADR;POSTAL;;".$result['address_1'].", ".$result['city']." ;;;;
            LABEL;POSTAL;ENCODING=QUOTED-PRINTABLE:".$result['address_1'].", ".$result['city']." =0D=0A,  =0D=0A
            URL;WORK:".$result['website']."
            EMAIL;PREF;INTERNET:".$result['email']."
            EMAIL;TLX:+581234567890
            REV:08102010T103800Z
            END:VCARD";
            */
        }	
					
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_telephone'] = $this->language->get('column_telephone');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');		
		$url = '';

		if (isset($this->request->get['filter_name'])) { $url .= '&filter_name=' . $this->request->get['filter_name']; } 
		if (isset($this->request->get['filter_email'])) { $url .= '&filter_email=' . $this->request->get['filter_email']; } 
		if (isset($this->request->get['filter_status'])) { $url .= '&filter_status=' . $this->request->get['filter_status']; } 
		if (isset($this->request->get['filter_date_start'])) { $url .= '&filter_date_start=' . $this->request->get['filter_date_start']; }
		if (isset($this->request->get['filter_date_end'])) { $url .= '&filter_date_end=' . $this->request->get['filter_date_end']; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
			
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		$this->data['sort_name'] = Url::createAdminUrl('marketing/contact/grid') . '&sort=name' . $url;
		$this->data['sort_email'] = Url::createAdminUrl('marketing/contact/grid') . '&sort=email' . $url;
		$this->data['sort_date_added'] = Url::createAdminUrl('marketing/contact/grid') . '&sort=date_start' . $url;
		$this->data['sort_date_end'] = Url::createAdminUrl('marketing/contact/grid') . '&sort=date_end' . $url;
		
		$url = '';

		if (isset($this->request->get['filter_name'])) { $url .= '&filter_name=' . $this->request->get['filter_name']; } 
		if (isset($this->request->get['filter_email'])) { $url .= '&filter_email=' . $this->request->get['filter_email']; } 
		if (isset($this->request->get['filter_status'])) { $url .= '&filter_status=' . $this->request->get['filter_status']; } 
		if (isset($this->request->get['filter_date_start'])) { $url .= '&filter_date_start=' . $this->request->get['filter_date_start']; }
		if (isset($this->request->get['filter_date_end'])) { $url .= '&filter_date_end=' . $this->request->get['filter_date_end']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
			
		$pagination = new Pagination();
		$pagination->ajax = true;
		$pagination->ajaxTarget = "gridWrapper";
		$pagination->total = $member_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('marketing/contact/grid') . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_date_star'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		$this->template = 'marketing/contact_grid.tpl';
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
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('marketing/contact') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('marketing/contact/export') . $url,
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
		
		$member_total = $this->modelemail_member->getTotalContacts($data);
	
		$results = $this->modelemail_member->getContacts($data);
 
    	foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => $this->language->get('text_export'),
				'href' => Url::createAdminUrl('marketing/contact/exportThis') . '&member_id=' . $result['customer_id'] . $url
			);
			$totalByList = $this->modelemail_member->getTotalContactsByList($result['customer_id']);
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

		$this->data['token'] = $this->session->get('ukey');

		if ($this->session->has('error')) {
			$this->data['error_warning'] = $this->session->get('error');
			
			$this->session->clear('error');
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if ($this->session->has('success')) {
			$this->data['success'] = $this->session->get('success');
		
			$this->session->clear('success');
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
		$this->data['sort_name'] = Url::createAdminUrl('marketing/contact/export') . '&sort=name' . $url;
		$this->data['sort_email'] = Url::createAdminUrl('marketing/contact/export') . '&sort=email' . $url;
		$this->data['sort_newsletter'] = Url::createAdminUrl('marketing/contact/export') . '&sort=newsletter' . $url;
		$this->data['sort_date_added'] = Url::createAdminUrl('marketing/contact/export') . '&sort=date_added' . $url;
		
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
		
		$this->template = 'marketing/contact_export.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
    
    private function getImportList() {
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('marketing/contact') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('marketing/contact/import') . $url,
       		'text'      => $this->language->get('heading_import'),
      		'separator' => ' :: '
   		);
					
		$this->data['heading_title'] = $this->language->get('heading_import');

		$this->data['token'] = $this->session->get('ukey');

		if ($this->session->has('error')) {
			$this->data['error_warning'] = $this->session->get('error');
			
			$this->session->clear('error');
		} elseif (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if ($this->session->has('success')) {
			$this->data['success'] = $this->session->get('success');
		
			$this->session->clear('success');
		} else {
			$this->data['success'] = '';
		}
        
        $this->data['action'] = Url::createAdminUrl('marketing/contact/import');
		
		$this->template = 'marketing/contact_import.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}
  	
  	public function getForm() {
		$this->load->auto('marketing/lists');
        $this->load->auto('marketing/contact');
        $this->load->auto('sale/customer');
		if (isset($this->request->get['member_id'])) {
             $member_info = $this->modelemail_member->getContact($this->request->get['member_id']);
             $this->data['listsByContact'] = $this->modelemail_lists->getListByContact($this->request->get['member_id']);
             $lists = $this->modelemail_lists->getAllLists();
             $customer_info = $this->modelCustomer->getCustomer($this->request->get['member_id']);
        }
        $this->data['lists'] = array();
        foreach ($this->data['listsByContact'] as $list) {
            $this->data['lists'][] = $this->modelemail_lists->getFullLists($list['list_id'],1);
        }
        
        $this->data['other_list_a'] = array();
        $this->data['other_list_b'] = array();
        $this->data['other_lists'] = array();
        foreach($lists as $list) {
            $this->data['other_list_a'][] = $list['list_id'];
        }
        foreach ($this->data['listsByContact'] as $list) {
            $this->data['other_list_b'][] = $list['list_id'];
        }
        $lists = array_diff($this->data['other_list_a'],$this->data['other_list_b']);
        foreach ($lists as $list) {
            $this->data['other_lists'][] = $this->modelemail_lists->getFullLists($list['list_id'],1);
        }
        
			$this->load->language('marketing/contact');
		 
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
            
			$this->data['token'] = $this->session->get('ukey');
			
			$this->document->breadcrumbs = array();
	
			$this->document->breadcrumbs[] = array(
				'href'      => Url::createAdminUrl('common/home'),
				'text'      => $this->language->get('text_home'),
				'separator' => false
			);
	
			$this->document->breadcrumbs[] = array(
				'href'      => Url::createAdminUrl('marketing/contact'),
				'text'      => $this->language->get('heading_title'),
				'separator' => ' :: '
			);
            
            if (isset($this->error['warning'])) {
    			$this->data['error_warning'] = $this->error['warning'];
    		} else {
    			$this->data['error_warning'] = '';
    		}
            $this->data['lista'] =  Url::createAdminUrl('marketing/lists/update'). '&list_id=';
			$this->data['categoria'] =  Url::createAdminUrl('store/category/update'). '&category_id=';
			$this->data['cancel'] = Url::createAdminUrl('marketing/contact');
            
			if (isset($this->request->get['member_id'])) {
      			$member_info = $this->modelemail_member->getContact($this->request->get['member_id']);
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

			 $this->data['customer'] = Url::createAdminUrl('sale/customer/update') . '&customer_id='.$this->request->get['member_id'];

			if (isset($customer_info['telephone'])) {
				$this->data['telephone'] = $customer_info['telephone'];
			} else {
				$this->data['telephone'] = '';
			}

			if (isset($this->request->post['date_added'])) {
				$this->data['date_added'] = $this->request->post['date_added'];
			} elseif (isset($list_info['date_added'])) {
				$this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($list_info['date_added'])); 
			} else {
				$this->data['date_added'] = date($this->language->get('date_format_short'), time()); 
			}
            
            $this->load->auto('sale/customer');
    				
    		$this->data['customers'] = $this->modelCustomer->getCustomerBySubscribe();
    		
    		if (isset($this->request->post['customer_id'])) {
    			$this->data['customer_id'] = $this->request->post['customer_id'];
    		} elseif (isset($list_info)) {
    			$this->data['customer_id'] = $this->modelemail_lists->getContacts($this->request->get['list_id']);
    		} else {
    			$this->data['customer_id'] = array();
    		}
            
			$this->data['token'] = $this->session->get('ukey');
			
			$this->template = 'marketing/contact_form.tpl';
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
