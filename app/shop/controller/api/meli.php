<?php

class ControllerApiMeli extends Controller {

    protected $meli;
    protected $handler;
    protected $oauth_url;

    private function initialize() {
        if (!$this->config->get('social_meli_app_id') || !$this->config->get('social_meli_app_secret')) {
            return false;
        } else {
            $this->load->auto('meli/meli');
            $this->meli = new Meli($this->config->get('social_meli_app_id'), $this->config->get('social_meli_app_secret'));
        }
    }

    public function index() {
        $Url = new Url($this->registry);
        if (!$this->initialize()) {
            $this->load->library('xhttp/xhttp');
            $this->handler = new xhttp;

            if ($this->request->hasQuery('redirect')) {
                $_SESSION['mlaction'] = $this->request->getQuery('redirect');
            }

            $redirect_uri = HTTP_HOME . 'api/meli';
            if (strpos($redirect_uri, 'http') === false) {
                if (strpos($redirect_uri, 'www.') === false) {
                    $redirect_uri = 'www.' . $redirect_uri;
                }
                $redirect_uri = 'http://' . $redirect_uri;
            } elseif (strpos($redirect_uri, 'www.') === false) {
                $protocol = substr($redirect_uri, 0, 7);
                $url = substr($redirect_uri, 7);
                $redirect_uri = $protocol . 'www.' . $url;
            }
            $redirect_uri = str_replace('/web', '', $redirect_uri);

            $this->oauth_url = 'http://auth.mercadolivre.com.br/authorization?client_id=' .
                    $this->config->get('social_meli_app_id') .
                    '&scope=&response_type=code&redirect_uri=' . urlencode($redirect_uri);
            $this->oauth_url = $this->meli->getAuthUrl($redirect_uri);
            if ($this->request->hasQuery('code') && !isset($_SESSION['mlcode'])) {
                $response = $this->meli->authorize($this->request->getQuery('code'), $redirect_uri);
                $_SESSION['mlcode'] = $this->request->getQuery('code');
        		$_SESSION['mltoken'] = $response['body']->access_token;
        		$_SESSION['mlexpire'] = time() + $response['body']->expires_in;
        		$_SESSION['mlrefresh_token'] = $response['body']->refresh_token;
                unset($_GET['code']);
                //$this->redirect($Url::createUrl("api/meli"));
            }
            
            if (!isset($_SESSION['mlcode'])) {
                unset($_SESSION['mltoken']);
                unset($_SESSION['mlexpire']);
                unset($_SESSION['mlrefresh_token']);
                unset($_SESSION['mlcode']);
                $this->redirect($this->oauth_url);
            }
            
            if(isset($_SESSION['mlexpire']) && $_SESSION['mlexpire'] < time()) {
    			try {
    				// Make the refresh proccess
    				$refresh = $this->meli->refreshAccessToken();
    
    				// Now we create the sessions with the new parameters
            		$_SESSION['mltoken'] = $refresh['body']->access_token;
            		$_SESSION['mlexpire'] = time() + $refresh['body']->expires_in;
            		$_SESSION['mlrefresh_token'] = $refresh['body']->refresh_token;
    			} catch (Exception $e) {
    			  	echo "Exception: ".  $e->getMessage() ."\n";
    			}
    		}
            
            if (isset($_SESSION['mltoken'])) {
                echo __LINE__ . '<br>';
                /*
                $requestData['method'] = 'post';
                $requestData['post'] = 'code=' . $_SESSION['mlcode']
                        . '&client_id=' . $this->config->get('social_meli_app_id')
                        . '&client_secret=' . $this->config->get('social_meli_app_secret')
                        . '&redirect_uri=' . urlencode($redirect_uri)
                        . '&grant_type=authorization_code';

                $response = $this->handler->fetch('https://api.mercadolibre.com/oauth/token', $requestData);
                */
                $mlactions = array(
                    'invitefriends', 
                    'import_products', 
                    'login'
                );
    
                if (isset($_SESSION['mlaction']) && in_array($_SESSION['mlaction'], $mlactions)) {
                    $this->{$_SESSION['mlaction']}();
                } else {
                    unset($_SESSION['mltoken']);
                    unset($_SESSION['mlcode']);
                    unset($_SESSION['mlexpire']);
                    unset($_SESSION['mlrefresh_token']);
                }
            } else {
                unset($_SESSION['mltoken']);
                unset($_SESSION['mlcode']);
                //$this->redirect($this->oauth_url);
            }
            echo __LINE__ . '<br>';
            if (isset($_REQUEST['logout'])) {
                unset($_SESSION['mltoken']);
                unset($_SESSION['mlcode']);
            }
        } else {
            echo '<script>history.back()</script>';
        }
    }

    public function invitefriends() {
        if (isset($_SESSION['meliAccessToken'])) {
            $token = json_decode($_SESSION['meliAccessToken']);

            $url = 'https://api.mercadolibre.com/users/me?access_token=' . $token->access_token;
            $response = $this->handler->fetch($url);
            $profile = json_decode($response['body'], true);
            if ($profile['error']) {
                $this->redirect($this->oauth_url);
            }

            $list = $this->db->query("SELECT * 
            FROM " . DB_PREFIX . "contact_list 
            WHERE name = 'Amigos de " . $this->db->escape(addslashes($profile['name'])) . " en Hotmail'");

            if ($list->num_rows) {
                $list_id = $list->row['contact_list_id'];
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "contact_list SET 
                name        = 'Amigos de " . $this->db->escape(addslashes($profile['name'])) . " en Hotmail',
                description = 'Amigos de " . $this->db->escape(addslashes($profile['name'])) . " en Hotmail',
                date_added  = NOW()");
                $list_id = $this->db->getLastId();
            }

            $url = 'https://api.mercadolibre.com/users/me?access_token=' . $token->access_token . '&limit=1000';
            $response = $this->handler->fetch($url);
            if ($response['body']) {
                $xml = json_decode($response['body'], true);
                if ($xml['error']) {
                    $this->redirect($this->oauth_url);
                }
                $to = array();
                $control = array();
                foreach ($xml['data'] as $emails) {
                    $contacts[] = array($emails['name'], $emails['emails']['preferred']);
                    $name = addslashes(str_replace("'", '', $emails['name']));
                    $email = $emails['emails']['preferred'];
                    if (empty($email))
                        continue;

                    $customer = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($email) . "'");
                    $contact = $this->db->query("SELECT * FROM " . DB_PREFIX . "contact WHERE email = '" . $this->db->escape($email) . "'");

                    if (!$contact->rows) {
                        $this->db->query("INSERT INTO " . DB_PREFIX . "contact SET 
                              name        = '" . $this->db->escape($name) . "',
                              email       = '" . $this->db->escape($email) . "', 
                              customer_id = '" . (int) $customer->row['customer_id'] . "',
                              date_added  = NOW()");

                        $contact_id = $this->db->getLastId();

                        $this->db->query("INSERT INTO " . DB_PREFIX . "contact_to_list SET 
                            contact_id     = '" . (int) $contact_id . "',
                            contact_list_id= '" . (int) $list_id . "',
                            date_added    = NOW()");
                    }

                    if (!in_array($email, $control) && !empty($email)) {
                        $control[] = $email;
                        $to[] = array(
                            'contact_id' => (int) $contact_id,
                            'name' => $name,
                            'email' => $email
                        );
                    }
                }


                if ($this->config->get('marketing_email_invite_friends')) {
                    $this->load->model('marketing/newsletter');
                    $newsletter = $this->modelNewsletter->getById($this->config->get('marketing_email_invite_friends'));
                    if ($newsletter) {
                        $dom = new DOMDocument;
                        $dom->preserveWhiteSpace = false;
                        $dom->loadHTML(html_entity_decode($newsletter['htmlbody']));

                        $trace_url = Url::createUrl("marketing/campaign/trace");
                        $trackEmail = $dom->createElement('img');
                        $trackEmail->setAttribute('src', $trace_url);
                        $dom->appendChild($trackEmail);

                        $data = array(
                            'newsletter_id' => $newsletter['newsletter_id'],
                            'name' => 'Invitar Amigos de ' . $this->db->escape(addslashes($profile['name'])) . ' en Hotmail',
                            'subject' => 'Hola',
                            'from_name' => $this->db->escape(addslashes($profile['name'])),
                            'from_email' => $this->db->escape($profile['email']),
                            'replyto_email' => $this->db->escape($this->config->get('config_email')),
                            'embed_image' => 0,
                            'trace_email' => 1,
                            'trace_click' => 0,
                            'contacts' => $to,
                            'repeat' => 'no_repeat',
                            'date_start' => date('Y-m-d h:i:s'),
                            'date_end' => date('Y-m-d h:i:s'),
                            'date_added' => date('Y-m-d h:i:s')
                        );

                        $this->load->model('marketing/campaign');
                        $campaign_id = $this->modelCampaign->add($data);

                        $params = array(
                            'job' => 'send_campaign',
                            'campaign_id' => $campaign_id
                        );

                        $this->load->library('task');
                        $task = new Task($this->registry);

                        $task->object_id = (int) $campaign_id;
                        $task->object_type = 'campaign';
                        $task->task = $campaign['name'];
                        $task->type = 'send';
                        $task->time_exec = date('Y-m-d H:i:s');
                        $task->params = $params;
                        $task->time_interval = 'no-repeat';
                        $task->time_last_exec = date('Y-m-d H:i:s');
                        $task->run_once = true;
                        $task->status = 1;
                        $task->date_start_exec = date('Y-m-d H:i:s');
                        $task->date_end_exec = date('Y-m-d H:i:s');
                        $task->addMinute(15);

                        $control = array();
                        foreach ($to as $sort_order => $contact) {
                            if (in_array($contact['email'], $control))
                                continue;
                            $control[] = $contact['email'];
                            $params = array(
                                'contact_id' => $contact['contact_id'],
                                'name' => $contact['name'],
                                'email' => $contact['email'],
                                'campaign_id' => $campaign_id
                            );
                            $queue = array(
                                "params" => $params,
                                "status" => 1,
                                "time_exec" => date('Y-m-d H:i:s')
                            );
                            $task->addQueue($queue);
                        }
                        $task->createSendTask();
                    }

                    $this->session->set('success', $this->language->get('text_friends_invited_success'));

                    if ($this->session->has('redirect')) {
                        $this->redirect($this->session->get('redirect'));
                    } else {
                        $this->redirect(HTTP_HOME);
                    }
                }
            }
        } else {
            $this->redirect($this->oauth_url);
        }
    }

    public function login() {

        if (!$this->customer->isLogged() && (!$this->config->get('social_meli_app_id') || !$this->config->get('social_meli_app_secret'))) {
            $this->redirect(Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Meli, por favor intente con otro servicio")));
        }

        if ($this->customer->isLogged()) {
            $this->redirect(Url::createUrl("account/account"));
        }

        if (isset($_SESSION['mltoken'])) {
            /*
              //TODO: pasar un token temporal para evitar csrf
              if (!isset($_SESSION['state') && $_SESSION['state') != $this->request->getQuery('state')) {
              $this->redirect(Url::createUrl("account/login",array("error"=>"No se pudo iniciar sesion utilizando Meli, por favor intente con otro servicio")));
              }
             */
            $response = $this->meli->get('/users/me/orders', array(
            'access_token' => $_SESSION['mltoken']
            ));
var_dump($response['body']);

            $response = $this->meli->get('/users/me', array('access_token' => $_SESSION['mltoken']));
var_dump($response['body']->nickname);var_dump($response['body']);
              $data = array(
              'oauth_provider'=> 'meli',
              'company'       => $response['body']->nickname,
              'firstname'     => $response['body']->first_name,
              'lastname'      => $response['body']->last_name,
              'email'         => $response['body']->email,
              'meli_oauth_id'     => $response['body']->id,
              'meli_oauth_token'  => $_SESSION['mltoken'],
              'meli_oauth_refresh'=> $_SESSION['mlrefresh_token'],
              'meli_oauth_expire'=> $_SESSION['mlexpire'],
              'meli_code'         => $_SESSION['mlcode']
              );
var_dump($data);
              $this->load->model('account/customer');
              $result = $this->modelCustomer->getCustomerByMeli($data);
              if ($result) {
                if ($this->customer->loginWithMeli($data)) {
                    if ($this->session->has('redirect')) {
                        $this->redirect(str_replace('&amp;', '&', $this->session->get('redirect')));
                    } else {
                        $this->redirect(Url::createUrl("common/home"));
                    }
                } else {
                    $this->redirect(Url::createUrl("account/login",array("error"=>"No se pudo iniciar sesion utilizando Meli, por favor intente con otro servicio")));
                }
              } elseif ($customer = $this->modelCustomer->addCustomerFromMeli($data)) {
              if ($this->config->get('marketing_email_send_password_and_welcome')) {
              $this->load->model('marketing/newsletter');
              $newsletter = $this->modelNewsletter->getById($this->config->get('marketing_email_send_password_and_welcome'));
              if ($newsletter) {
              $message = $this->prepareTemplate(html_entity_decode($newsletter['htmlbody']));
              $message = str_replace('{%password%}',$customer['password'],$message);
              $message = str_replace("{%fullname%}",$profile['name'],$message);
              $message = str_replace("{%rif%}",'',$message);
              $message = str_replace("{%company%}",$profile['name'],$message);
              $message = str_replace("{%email%}",$profile['emails']['preferred'],$message);
              $message = str_replace("{%telephone%}",'',$message);
              $this->load->library('email/mailer');
              $this->mailer = new Mailer;
              if ($this->config->get('config_smtp_method')=='smtp') {
              $this->mailer->IsSMTP();
              $this->mailer->Host = $this->config->get('config_smtp_host');
              $this->mailer->Username = $this->config->get('config_smtp_username');
              $this->mailer->Password = base64_decode($this->config->get('config_smtp_password'));
              $this->mailer->Port     = $this->config->get('config_smtp_port');
              $this->mailer->Timeout  = $this->config->get('config_smtp_timeout');
              $this->mailer->SMTPSecure = $this->config->get('config_smtp_ssl');
              $this->mailer->SMTPAuth = ($this->config->get('config_smtp_auth')) ? true : false;
              } elseif ($this->config->get('config_smtp_method')=='sendmail') {
              $this->mailer->IsSendmail();
              } else {
              $this->mailer->IsMail();
              }

              $this->mailer->AddAddress($profile['emails']['preferred'],$profile['name']);
              $this->mailer->IsHTML();
              $this->mailer->SetFrom($this->config->get('config_email'),$this->config->get('config_name'));
              $this->mailer->Subject = "Bienvenidos - ". $this->config->get('config_name');
              $this->mailer->Body = $message;
              $this->mailer->Send();
              }
              }

              if ($this->customer->loginWithMeli($data)) {
              $this->redirect(Url::createUrl("account/account"));
              } else {
              $this->redirect(Url::createUrl("account/login",array("error"=>"No se pudo iniciar sesion utilizando Meli, por favor intente con otro servicio")));
              }
              }
             
        } else {
            //$this->redirect($this->oauth_url);
        }
    }

    public function import_products() {

        if (!$this->customer->isLogged() && (!$this->config->get('social_meli_app_id') || !$this->config->get('social_meli_app_secret'))) {
            $this->redirect(Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Meli, por favor intente con otro servicio")));
        }
        if (isset($_SESSION['mltoken'])) {
            /*
              //TODO: pasar un token temporal para evitar csrf
              if (!isset($_SESSION['state') && $_SESSION['state') != $this->request->getQuery('state')) {
              $this->redirect(Url::createUrl("account/login",array("error"=>"No se pudo iniciar sesion utilizando Meli, por favor intente con otro servicio")));
              }
             */

            $seller_id = $this->modelCustomer->getProperty($this->customer->getId(), 'meli', 'meli_oauth_id');
            $response = $this->meli->get('/orders/search', array(
            'access_token' => $_SESSION['mltoken'],
            'seller' => $seller_id
            ));
        } else {
            //$this->redirect($this->oauth_url);
        }
    }

    private function prepareTemplate($newsletter) {
        if (!$newsletter)
            return false;
        $this->load->library('url');
        $this->load->library('BarcodeQR');
        $this->load->library('Barcode39');
        $qr = new BarcodeQR;
        $barcode = new Barcode39(C_CODE);

        $qrStore = "cache/" . $this->escape($this->config->get('config_owner')) . '.png';
        $eanStore = "cache/" . $this->escape($this->config->get('config_owner')) . "_barcode_39.gif";

        if (!file_exists(DIR_IMAGE . $qrStore)) {
            $qr->url(HTTP_HOME);
            $qr->draw(150, DIR_IMAGE . $qrStore);
        }

        if (!file_exists(DIR_IMAGE . $eanStore)) {
            $barcode->draw(DIR_IMAGE . $eanStore);
        }

        $newsletter = str_replace("%7B", "{", $newsletter);
        $newsletter = str_replace("%7D", "}", $newsletter);
        $newsletter = str_replace("{%store_logo%}", '<img src="' . HTTP_IMAGE . $this->config->get('config_logo') . '" alt="' . $this->config->get('config_name') . '" />', $newsletter);
        $newsletter = str_replace("{%store_url%}", HTTP_HOME, $newsletter);
        $newsletter = str_replace("{%url_login%}", Url::createUrl("account/login"), $newsletter);
        $newsletter = str_replace("{%store_owner%}", $this->config->get('config_owner'), $newsletter);
        $newsletter = str_replace("{%store_name%}", $this->config->get('config_name'), $newsletter);
        $newsletter = str_replace("{%store_rif%}", $this->config->get('config_rif'), $newsletter);
        $newsletter = str_replace("{%store_email%}", $this->config->get('config_email'), $newsletter);
        $newsletter = str_replace("{%store_telephone%}", $this->config->get('config_telephone'), $newsletter);
        $newsletter = str_replace("{%store_address%}", $this->config->get('config_address'), $newsletter);
        /*
          $newsletter = str_replace("{%products%}",$product_html,$newsletter);
         */
        $newsletter = str_replace("{%date_added%}", date('d-m-Y h:i A'), $newsletter);
        $newsletter = str_replace("{%ip%}", $_SERVER['REMOTE_ADDR'], $newsletter);
        $newsletter = str_replace("{%qr_code_store%}", '<img src="' . HTTP_IMAGE . $qrStore . '" alt="QR Code" />', $newsletter);
        $newsletter = str_replace("{%barcode_39_order_id%}", '<img src="' . HTTP_IMAGE . $eanStore . '" alt="NT Code" />', $newsletter);

        $newsletter .= "<p style=\"text-align:center\">Powered By Necotienda&reg; " . date('Y') . "</p>";

        return html_entity_decode(htmlspecialchars_decode($newsletter));
    }

    public function escape($str) {
        if (isset($str)) {
            if ($str !== mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
                $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
            $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
            $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
            $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
            $str = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $str);
            $str = strtolower(trim($str, '-'));
            return $str;
        } else {
            return false;
        }
    }

}
