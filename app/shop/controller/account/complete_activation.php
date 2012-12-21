<?php
//TODO: crear funciones de validación serverside y clientside
//TODO: agregar un tercer paso para capturar información académica, profesional y familiar
//TODO: agregar cuarto paso para acceder a las cuentas de correos de los usuarios, obtener la lista de contactos y enviar invitaciones

class ControllerAccountCompleteActivation extends Controller {
	private $error = array();

	public function index() {
	    if ($this->customer->isLogged() && $this->customer->getComplete()) {  
      		$this->redirect(HTTP_HOME . 'index.php?r=account/account');
    	} elseif (!$this->customer->isLogged()) {  
      		$this->session->set('redirect',HTTP_HOME . 'index.php?r=account/complete_activation');	  
	  		$this->redirect(HTTP_HOME . 'index.php?r=account/login');
    	}
	   
        $this->session->set('rand_k',strtotime(date('Y-m-d H:i:s')));
        
		$this->language->load('account/complete_activation');

		$this->document->title = $this->language->get('heading_title');
		        
      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=account/account',
        	'text'      => $this->language->get('text_account'),
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=account/complete_activation',
        	'text'      => $this->language->get('text_edit'),
        	'separator' => $this->language->get('text_separator')
      	);
		
		$this->data['heading_title'] = $this->language->get('heading_title');    
        
        // scripts
        $scripts = array(
            array('id'=>'step1','method'=>'ready','script'=>"
                jQuery('#formWrapper').load('".HTTP_HOME."index.php?r=account/complete_activation/personal');
            "),
        );
        $this->scripts = array_merge($this->scripts,$scripts);
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/complete_activation.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/complete_activation.tpl';
		} else {
			$this->template = 'default/account/complete_activation.tpl';
		}
		
		$this->children = array(
			'common/header',
			'common/nav',
			'common/footer'
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));		
	}    
    
    public function savePersonal() {
        
		$this->load->model('account/customer');
        
        if (isset($_POST)) {
            $this->request->post['nacimiento'] = $this->request->post['dia'] ."/".$this->request->post['mes'] ."/".$this->request->post['ano'];
            $result = $this->model_account_customer->addPersonal($this->request->post);
            echo $result;
        }
        
    }
    
    public function saveSocial() {
        
		$this->load->model('account/customer');
        
        if (isset($_POST)) {
            $result = $this->model_account_customer->addSocial($this->request->post);
            echo $result;
        }
        
    }
    
    public function personal() {
        
		$this->language->load('account/complete_activation');
        
        $this->data['entry_firstname'] = $this->language->get("entry_firstname");
        $this->data['entry_lastname'] = $this->language->get("entry_lastname");
        $this->data['entry_telephone'] = $this->language->get("entry_telephone");
        $this->data['entry_sexo'] = $this->language->get("entry_sexo");
        $this->data['entry_nacimiento'] = $this->language->get("entry_nacimiento");
        
        $this->data['entry_address_1'] = $this->language->get("entry_address_1");
        $this->data['entry_city'] = $this->language->get("entry_city");
        $this->data['entry_zone'] = $this->language->get("entry_zone");
        $this->data['entry_country'] = $this->language->get("entry_country");
        
         $this->data[C_CODE.'_tk'] = md5(rand(1000000000,9999999999));
        
        $this->data['next'] = HTTP_HOME."index.php?r=account/complete_activation/social";
        $this->data['prev'] = "";
        $this->data['save'] = HTTP_HOME."index.php?r=account/complete_activation/savepersonal";
        
		$this->load->model('localisation/country');
    	$this->data['countries'] = $this->model_localisation_country->getCountries();
        $this->setvar("country_id");
        $this->setvar("zone_id");
        
		$this->load->model('account/customer');
        $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
        $this->setvar("firstname",$customer_info);
        $this->setvar("lastname",$customer_info);
        $this->setvar("telephone",$customer_info);
        $this->setvar("sexo",$customer_info);
        $this->setvar("nacimiento",$customer_info);
        
		$this->load->model('account/address');
        $address_info = $this->model_account_address->getAddress($customer_info['address_id']);
        $this->setvar("city",$address_info);
        $this->setvar("address_1",$address_info);
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/step1.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/step1.tpl';
		} else {
			$this->template = 'default/account/step1.tpl';
		}
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));	
    }
    
    public function social() {
        
		$this->language->load('account/complete_activation');
        
        $this->data['entry_msn'] = $this->language->get("entry_msn");
        $this->data['entry_yahoo'] = $this->language->get("entry_yahoo");
        $this->data['entry_gmail'] = $this->language->get("entry_gmail");
        $this->data['entry_skype'] = $this->language->get("entry_skype");
        $this->data['entry_facebook'] = $this->language->get("entry_facebook");
        $this->data['entry_twitter'] = $this->language->get("entry_twitter");
        $this->data['entry_blog'] = $this->language->get("entry_blog");
        $this->data['entry_website'] = $this->language->get("entry_website");
        
         $this->data[C_CODE.'_tk'] = md5(rand(1000000000,9999999999));
        
        $this->data['personal'] = HTTP_HOME."index.php?r=account/complete_activation/personal";
        
        $this->data['next'] = HTTP_HOME."index.php?r=account/complete_activation/share";
        $this->data['prev'] = HTTP_HOME."index.php?r=account/complete_activation/personal";
        $this->data['save'] = HTTP_HOME."index.php?r=account/complete_activation/savesocial";
        
		$this->load->model('account/customer');
        $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
        $this->setvar("msn",$customer_info);
        $this->setvar("yahoo",$customer_info);
        $this->setvar("gmail",$customer_info);
        $this->setvar("skype",$customer_info);
        $this->setvar("facebook",$customer_info);
        $this->setvar("twitter",$customer_info);
        $this->setvar("blog",$customer_info);
        $this->setvar("website",$customer_info);
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/step2.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/step2.tpl';
		} else {
			$this->template = 'default/account/step2.tpl';
		}
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));	
    }
    
    public function share() {
        
		$this->language->load('account/complete_activation');
        
        $this->load->library("oinviter/openinviter");
        $inviter=new OpenInviter();
        $oi_services=$inviter->getPlugins();
        
        $this->data['entry_msn'] = $this->language->get("entry_msn");
        $this->data['entry_yahoo'] = $this->language->get("entry_yahoo");
        $this->data['entry_gmail'] = $this->language->get("entry_gmail");
        $this->data['entry_skype'] = $this->language->get("entry_skype");
        $this->data['entry_facebook'] = $this->language->get("entry_facebook");
        $this->data['entry_twitter'] = $this->language->get("entry_twitter");
        $this->data['entry_blog'] = $this->language->get("entry_blog");
        $this->data['entry_website'] = $this->language->get("entry_website");
        
         $this->data[C_CODE.'_tk'] = md5(rand(1000000000,9999999999));
        
        $this->data['personal'] = HTTP_HOME."index.php?r=account/complete_activation/personal";
        $this->data['social'] = HTTP_HOME."index.php?r=account/complete_activation/social";
        
        $this->data['next'] = HTTP_HOME."index.php?r=account/complete_activation/done";
        $this->data['prev'] = HTTP_HOME."index.php?r=account/complete_activation/social";
        
        // scripts
        $scripts = array(
            array('id'=>'step3','method'=>'ready','script'=>"
            "),
        );
        $this->scripts = array_merge($this->scripts,$scripts);
        
        $emails = array(
        "gmail",
        "hotmail",
        "yahoo",
        "msn"
        );
        $socials = array(
        "badoo",
        "facebook",
        "flickr",
        "hi5",
        "twitter"
        );
        
    	$contents = "<style type='text/css'>
    	.crop_image_email { background-image:url('".HTTP_IMAGE."/email_services.png'); border:none; display:block; height:60px; margin:0; padding:0; width:130px; }
    	.crop_image_social { background-image:url('".HTTP_IMAGE."/social_services.png'); border:none; display:block; height:60px; margin:0; padding:0; width:130px; }
    	</style>
    	";
        
    	$c=0;
        
    	$contents .= "<table cellspacing='0' cellpadding='0' style='border: medium none;'><tr>";
        $types = array('email','social');
        $services = array_merge($oi_services['email'],$oi_services['social']);
        $l = count(array_merge($emails,$socials));
        $l = round($l/4);
        //foreach ($types as $type) {
        	foreach($services as $service=>$data) {
        	   
        	   if (!in_array($service,array_merge($emails,$socials))) continue;
               if ($service == "gmail") $height = 1020;
               if ($service == "hotmail") $height = 1200;
               if ($service == "linkedin") $height = 1800;
               if ($service == "msn") $height = 2220;
               if ($service == "yahoo") $height = 3420;
               
               if ($service == "badoo") $height = 0;
               if ($service == "facebook") $height = 360;
               if ($service == "flickr") $height = 600;
               if ($service == "hi5") $height = 900;
               if ($service == "myspace") $height = 1740;
               if ($service == "twitter") $height = 2280;
               
               if (in_array($service,$emails)) 
                    $type = "email";
               else 
                    $type = "social"; 	
        		if ($c % 4 == 0) $contents.="</tr><tr>"; 
        		if ($c % 4 == 0)  $c = 0;
        		$c++;
        		$contents.="
        					<td align='center'>
        						<a style='cursor:pointer' id='{$service}' onclick='shareContainer(\"{$service}\",\"{$height}\",\"{$type}\")'>
        							<div style='background-position: 0px ".(-$height)."px;' class='crop_image_{$type}'></div>
        						</a>
        					</td>		
        					";
       		}
         //}
    	$contents .= "</tr></table>";
        
        $this->data['share'] = $contents;
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/step3.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/step3.tpl';
		} else {
			$this->template = 'default/account/step3.tpl';
		}
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));	
    }
    
    public function profesional() {
    }
    
    public function done() {
        
		$this->language->load('account/complete_activation');
        
        $this->customer->setComplete();
        
        $this->data['personal'] = HTTP_HOME."index.php?r=account/complete_activation/personal";
        $this->data['social'] = HTTP_HOME."index.php?r=account/complete_activation/social";
        $this->data['share'] = HTTP_HOME."index.php?r=account/complete_activation/share";
        
        $this->data['prev'] = HTTP_HOME."index.php?r=account/complete_activation/share";
        $this->data['save'] = HTTP_HOME."index.php?r=account/complete_activation/done";
        
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/account/step4.tpl')) {
			$this->template = $this->config->get('config_template') . '/account/step4.tpl';
		} else {
			$this->template = 'default/account/step4.tpl';
		}
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));	
        
    }
    
    public function sendInvitations() {
        $this->load->library("oinviter/openinviter");
        $inviter=new OpenInviter();
        $oi_services=$inviter->getPlugins();
        
        $inviter->startPlugin($_POST['network']);
        $internal=$inviter->getInternalError();
        if ($internal) { 
                $ers['internal']=$internal;
        } else {
            if (empty($_POST['oi_session_id'])) $ers['session_id']='No active session !';
            
      		$selected_contacts=array();
      		$message=array(
                            'subject'=>' Hola! te invito a NecoTienda',
                            'body'=>"Hola, \n\nRecientemente me he registrado en NecoTienda y quiero comentarte que es un sitio muy bueno para comprar y vender casi cualquier cosa, visitalo y pruebalo tu mismo. \n\nPuedes registrarte y probar todos los servicios GRATIS por 14 dias. \n Haz click en esta direccion http://www.necotienda.com "
                );
                /*
     			   	if ($inviter->showContacts()) {
        					foreach ($_POST as $key=>$val)
        						if (strpos($key,'check_')!==false)
        							$selected_contacts[$_POST['email_'.$val]]=$_POST['name_'.$val];
        						elseif (strpos($key,'email_')!==false) {
        							$temp=explode('_',$key);$counter=$temp[1];
        							if (is_numeric($temp[1])) $contacts[$val]=$_POST['name_'.$temp[1]];
       							}
        					if (count($selected_contacts)==0) $ers['contacts']="You haven't selected any contacts to invite !";
       					}
                        */
                foreach($_POST['contact'] as $key => $value) {
                    $selected_contacts[$value['email']] = $value['name'];
                }
		}
       			
        		if (count($ers)==0) {
        			$sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$selected_contacts);
        			$inviter->logout();
        			if ($sendMessage===-1) {
        				$message_footer="\r\n\r\nThis invite was sent using OpenInviter technology.";
        				$message_subject=$_POST['email_box'].$message['subject'];
        				$message_body=$message['body'].$message['attachment'].$message_footer; 
        				$headers="From: {$_POST['email_box']}";
        				foreach ($selected_contacts as $email=>$name)
        					mail($email,$message_subject,$message_body,$headers);
        				$oks['mails']="Invitaciones enviadas!";
       				} elseif ($sendMessage===false) {
      				$internal=$inviter->getInternalError();
        			$ers['internal']=($internal?$internal:"There were errors while sending your invites.<br>Please try again later!");
                    } else 
                        $oks['internal']="Invites sent successfully!";
                    $done=true;
        		}
    }
    
    public function getContacts() {
        $this->load->library("oinviter/openinviter");
        $inviter=new OpenInviter();
        $oi_services=$inviter->getPlugins();
                
        if (isset($_POST['network'])) {
            $plugType = $_POST['t'];
            
        	if ($plugType) 
                $pluginContent=$this->createPluginContent($_POST['network'],$plugType);
       	} else { 
            $plugType = ''; 
            $_POST['network']=''; 
        }
        
        $ers=array();
        $oks=array();
        $import_ok=false;
        $done=false;
        
        if (empty($_POST['email_box']))
 			$ers['email']="Debe ingresar su nombre de usuario o su email";
  		if (empty($_POST['password_box']))
 			$ers['password']="Debe ingresar su contrase&ntilde;a";
            
        if (!count($ers)) {
 			$inviter->startPlugin($_POST['network']);
 			$internal=$inviter->getInternalError();
 			if ($internal)
				$ers['inviter']=$internal;
 			elseif (!$inviter->login($_POST['email_box'],$_POST['password_box'])) {
				$internal=$inviter->getInternalError();
				$ers['login']=($internal?$internal:"FALLO: El email y/o la contrase&ntilde;a son incorrectos. Por favor verifique e intente de nuevo.");
            } elseif (false===$contacts=$inviter->getMyContacts()) {
        				$ers['contacts']="No se pudo obtener los contactos";
 			} else {
				$import_ok=true;
				$step='send_invites';
				$_POST['oi_session_id']=$inviter->plugin->getSessionID();
				$_POST['message_box']='';
                    foreach ($contacts as $email => $name) {
                        $result = $this->db->query("SELECT * FROM " . DB_PREFIX . "address_book WHERE `email` = '$email'");
                        if ($result->num_rows) continue;
                        $sql = "INSERT INTO " . DB_PREFIX . "address_book (`email`,`name`,`provider`,`date_added`) VALUES ('". $this->db->escape($email) ."','". $this->db->escape($name) ."','".$this->db->escape($_POST['network'])."',NOW())";
                        $this->db->query($sql);
                    }
                
                
            }
		}
        
        $contents.="<script type='text/javascript'>
        	function toggleAll(element) 
        	{
        	var form = document.forms.formInvite, z = 0;
        	for(z=0; z<form.length;z++)
        		{
        		if(form[z].type == 'checkbox')
        			form[z].checked = element.checked;
        	   	}
        	}
        </script>";
        $contents.="<form method='post' name='formInvite' id='formInvite'>".$this->ers($ers).$this->oks($oks);

        $contents.="<center>{$pluginContent}</center>";
        
        if ($inviter->showContacts()) {			
            $contents.="<h1>Tus Contactos</h1>";
            if (!count($contacts)) {
                $contents .= "<h2>No tienes contactos registrados en tu agenda</h2>";
            } else {
                $contents.="<table style='margin:0;padding:2px;border:none;text-align:center'>";
                $contents.="<tr><td colspan='".($plugType=='email'? "3":"2")."' style='padding:3px;'><a class='button' onclick='sendInvitations()'>Enviar Invitaciones</a></td></tr>";
                $contents.="<tr style='background:#CCC;font-weight:bold;'><td><input type='checkbox' onchange='toggleAll(this)' name='toggle_all' title='Seleccionar Todos/Ninguno' checked='checked' />Invitar</td><td>Nombre</td>".($plugType == 'email' ?"<td>E-mail</td>":"")."</tr>";
                $counter=0;
        		foreach ($contacts as $email=>$name) {
                    $counter++;					
        			$contents.="
                    <tr>
                        <td>
                            <input name='contact[{$counter}][check]' value='{$counter}' type='checkbox' checked='checked' />
                            <input type='hidden' name='contact[{$counter}][email]' value='{$email}' />
                            <input type='hidden' name='contact[{$counter}][name]' value='{$name}' />
                        </td>
                        <td>{$name}</td>
                        ".($plugType == 'email' ?"<td>{$email}</td>":"").
                    "</tr>";
     			}
                $contents.="<tr><td colspan='".($plugType=='email'? "3":"2")."' style='padding:3px;'><a class='button' onclick='sendInvitations()'>Enviar Invitaciones</a></td></tr>";
            }
        	$contents.="</table>";
        } else {
            // enviar invitaciones sin mostrar
            // guardar contactos
        }
        $contents.="<input type='hidden' name='network' value='{$_POST['network']}'>
        			<input type='hidden' name='email_box' value='{$_POST['email_box']}'>
        			<input type='hidden' name='oi_session_id' value='{$_POST['oi_session_id']}'>";

        $contents.="<script>function sendInvitations() {
            jQuery.ajax({
                type: 'post',
                dataType: 'html',
                url: 'index.php?r=account/complete_activation/sendinvitations',
                data: jQuery('#formInvite').serialize(),
                beforeSend: function() {
                    jQuery('#formWrapper').html('<img src=\'".HTTP_IMAGE."nt_loader.gif\' alt=\'Cargando...\' />');
                },
                success: function(data){
                    // jQuery('#contacts').html(data);
                    jQuery('#formWrapper').load('".HTTP_HOME."index.php?r=account/complete_activation/done"."');
                }
            });
        }</script>";
        $contents.="</form>";
        echo $contents;
    }
    
    private function ers($ers) {
    	if (!empty($ers)) {
    		$contents="<table cellspacing='0' cellpadding='0' style='border:1px solid red;' align='center'><tr><td valign='middle' style='padding:3px' valign='middle'><img src='imgs/ers.gif'></td><td valign='middle' style='color:red;padding:5px;'>";
    		foreach ($ers as $key=>$error)
    			$contents.="{$error}<br >";
    		$contents.="</td></tr></table><br >";
    		return $contents;
   		}
   	}
    	
    private function oks($oks) {
    	if (!empty($oks)) {
    		$contents="<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;' align='center'><tr><td valign='middle' valign='middle'><img src='imgs/oks.gif' ></td><td valign='middle' style='color:#5897FE;padding:5px;'>	";
    		foreach ($oks as $key=>$msg)
    			$contents.="{$msg}<br >";
    		$contents.="</td></tr></table><br >";
    		return $contents;
   		}
   	}
    
    private function createPluginContent($pr,$plugType) {
        $this->load->library("oinviter/openinviter");
        $inviter=new OpenInviter();
        $oi_services=$inviter->getPlugins();
        
    	$a=array_keys($oi_services[$plugType]);
    	foreach($a as $r=>$sv) if ($sv==$pr) break;
    	return $contentPlugin="<div style='border:none; display:block; height:60px; margin:0; padding:0; width:130px; background-position: 0px ".(-60*$r)."px; background-image:url(\"imgs/{$plugType}_services.png\");'></div>";
   	}
    
  	public function zone() {
		$output = '<option value="">' . $this->language->get('text_select') . '</option>';
		
		$this->load->model('localisation/zone');

    	$results = $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']);
        
      	foreach ($results as $result) {
        	$output .= '<option value="' . $result['zone_id'] . '"';
	
	    	if (isset($this->request->get['zone_id']) && ($this->request->get['zone_id'] == $result['zone_id'])) {
	      		$output .= ' selected="selected"';
	    	}
	
	    	$output .= '>' . $result['name'] . '</option>';
    	} 
		
		if (!$results) {
			if (!$this->request->get['zone_id']) {
		  		$output .= '<option value="0" selected="selected">' . $this->language->get('text_none') . '</option>';
			} else {
				$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
			}
		}
	
		$this->response->setOutput($output, $this->config->get('config_compression'));
  	}  
}
