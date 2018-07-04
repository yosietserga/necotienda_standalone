<?php

require_once( DIR_SYSTEM . 'library/google/autoload.php' );

class ControllerApiGoogle extends Controller {

    protected $google;
    protected $plus;
    protected $gtoken;

    private function initialize() {
        if ($this->config->get('social_google_client_id') && $this->config->get('social_google_client_secret')) {
            $this->google = new Google_Client();
            $this->google->setApplicationName($this->config->get('config_name'));
            $this->google->setScopes(array(
                'http://www.google.com/m8/feeds/',
                'https://www.googleapis.com/auth/latitude.all.city',
                'https://www.googleapis.com/auth/plus.me',
                'https://www.googleapis.com/auth/userinfo.profile',
                'https://www.googleapis.com/auth/userinfo.email'));
            
            $this->google->setClientId($this->config->get('social_google_client_id'));
            $this->google->setClientSecret($this->config->get('social_google_client_secret'));
        } else {
            return false;
        }
    }

    public function index() {
        if (!$this->initialize()) {
            if ($this->request->hasQuery('redirect')) {
                $_SESSION[gaction] = $this->request->getQuery('redirect');
            }

            $redirect_uri = HTTP_HOME . 'api/google';
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

            $this->google->setRedirectUri($redirect_uri);

            if ($this->request->hasQuery('code') && !isset($_SESSION['gtoken'])) {
                $this->google->authenticate($this->request->getQuery('code'));
                $_SESSION[gtoken] = $this->google->getAccessToken();
                $_SESSION[gcode] = $this->request->getQuery('code');
                $this->redirect(Url::createUrl("api/google"));
            }

            if (isset($_SESSION['gtoken'])) {
                $this->google->setAccessToken($_SESSION['gtoken']);
            } else {
                $this->redirect($this->google->createAuthUrl());
            }

            if (isset($_REQUEST['logout'])) {
                unset($_SESSION['gtoken']);
                $this->google->revokeToken();
            }

            $this->plus = new Google_Service_Plus($this->google);

            $gactions = array('invitefriends', 'login', 'promote');

            if (isset($_SESSION['gaction']) && in_array($_SESSION['gaction'], $gactions)) {
                $this->{$_SESSION['gaction']}();
            } else {
                unset($_SESSION['gtoken']);
                unset($_SESSION['gcode']);
                if ($this->session->has('redirect')) {
                    $this->redirect($this->session->get('redirect'));
                } else {
                    $this->redirect(HTTP_HOME);
                }
            }
        } else {
            echo '<script>history.back()</script>';
        }
    }

    public function invitefriends() {
        if ($this->google->getAccessToken()) {
            if ($this->google->isAccessTokenExpired()) {
                $this->google->revokeToken($_SESSION['gtoken']);
                unset($_SESSION['gtoken']);
                unset($_SESSION['gcode']);
                unset($_SESSION['gaction']);
            }

            $reqUrl = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=1000';
            $req = new Google_HttpRequest($reqUrl);
            $googleAuth = $this->google->getAuth()->authenticatedRequest($req);
            $xml = simplexml_load_string($googleAuth->getResponseBody());
            $response = json_encode($xml);

            $reqUrl = 'https://www.googleapis.com/oauth2/v2/userinfo';
            $req = new Google_HttpRequest($reqUrl);
            $userInfo = json_decode($this->google->getAuth()->authenticatedRequest($req)->getResponseBody());

            $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');

            $list = $this->db->query("SELECT * 
            FROM " . DB_PREFIX . "contact_list 
            WHERE name = \"Amigos de " . $this->db->escape(addslashes($userInfo->name)) . " en Google\"");

            if ($list->num_rows) {
                $list_id = $list->row['contact_list_id'];
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "contact_list SET 
                name        = \"Amigos de " . $this->db->escape(addslashes($userInfo->name)) . " en Google\",
                description = \"Amigos de " . $this->db->escape(addslashes($userInfo->name)) . " en Google\",
                date_added  = NOW()");
                $list_id = $this->db->getLastId();
            }

            $to = array();
            $control = array();
            foreach ($xml->entry as $entry) {
                foreach ($entry->xpath('gd:email') as $value) {
                    $name = str_replace("'", '', (string) $entry->title);
                    $email = (string) $value->attributes()->address;
                    if (empty($email))
                        continue;

                    $customer = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($email) . "'");
                    $contact = $this->db->query("SELECT * FROM " . DB_PREFIX . "contact WHERE email = '" . $this->db->escape($email) . "'");

                    if (!$contact->row) {
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
                    } else {
                        $contact_id = $contact->row['contact_id'];
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

                    $fullname = ($userInfo->name) ? addslashes($userInfo->name) : $this->config->get('config_title');
                    $data = array(
                        'newsletter_id' => $newsletter['newsletter_id'],
                        'name' => "Invitar Amigos de " . $this->db->escape(addslashes($fullname)) . " ({$userInfo->email}) en Google",
                        'subject' => 'Hola',
                        'from_name' => $this->db->escape($fullname),
                        'from_email' => $this->db->escape($this->config->get('config_email')),
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
                    $task->task = $data['name'];
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
        } else {
            $this->redirect($this->google->createAuthUrl());
        }
    }

    public function promote() {
        if ($this->google->getAccessToken()) {
            $reqUrl = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=1000';
            $req = new Google_HttpRequest($reqUrl);
            $googleAuth = $this->google->getAuth()->authenticatedRequest($req);
            $xml = simplexml_load_string($googleAuth->getResponseBody());
            $response = json_encode($xml);

            $reqUrl = 'https://www.googleapis.com/oauth2/v2/userinfo';
            $req = new Google_HttpRequest($reqUrl);
            $userInfo = json_decode($this->google->getAuth()->authenticatedRequest($req)->getResponseBody());

            $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
            $fullname = ($userInfo->name) ? addslashes($userInfo->name) : $this->config->get('config_title');
            $list = $this->db->query("SELECT * 
            FROM " . DB_PREFIX . "contact_list 
            WHERE name = \"Amigos de " . $this->db->escape(addslashes($fullname)) . " (" . $this->db->escape(addslashes($userInfo->email)) . ") en Google\"");

            if ($list->num_rows) {
                $list_id = $list->row['contact_list_id'];
            } else {
                $this->db->query("INSERT INTO " . DB_PREFIX . "contact_list SET 
                name        = \"Amigos de " . $this->db->escape(addslashes($userInfo->name)) . " (" . $this->db->escape(addslashes($userInfo->email)) . ") en Google\",
                description = \"Amigos de " . $this->db->escape(addslashes($userInfo->name)) . " (" . $this->db->escape(addslashes($userInfo->email)) . ") en Google\",
                date_added  = NOW()");
                $list_id = $this->db->getLastId();
            }

            $to = array();
            $control = array();
            foreach ($xml->entry as $entry) {
                foreach ($entry->xpath('gd:email') as $value) {
                    $name = str_replace("'", '', (string) $entry->title);
                    $email = (string) $value->attributes()->address;
                    if (empty($email))
                        continue;

                    $customer = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE email = '" . $this->db->escape($email) . "'");
                    $contact = $this->db->query("SELECT * FROM " . DB_PREFIX . "contact WHERE email = '" . $this->db->escape($email) . "'");

                    if (!$contact->row) {
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
                    } else {
                        $contact_id = $contact->row['contact_id'];
                    }

                    if (!in_array($email, $control) && !empty($email)) {
                        $control[] = $email;
                        $to[] = array(
                            'contact_id' => $contact_id,
                            'name' => $name,
                            'email' => $email
                        );
                    }
                }
            }

            if ($this->config->get('marketing_email_promote_product')) {
                $this->load->model('marketing/newsletter');

                $product = array();
                $_SESSION['promote_product_id'] = $product_id = ($this->request->hasQuery('product_id')) ? $this->request->getQuery('product_id') : $_SESSION['promote_product_id'];
                if ($product_id) {
                    $this->load->model('store/product');
                    $product = $this->modelProduct->getProduct($product_id);
                    if ($product) {

                        $this->load->model('store/product');
                        $Url = new Url($this->registry);
                        //Libs
                        $this->load->auto('image');
                        $this->load->auto('currency');
                        $this->load->auto('tax');

                        $product['url'] = $Url::createUrl('store/product', array('product_id' => $product['product_id']));

                        $image = isset($product['image']) ? $product['image'] : 'no_image.jpg';
                        $product['image'] = NTImage::resizeAndSave($image, $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));

                        $discount = $this->modelProduct->getProductDiscount($product['product_id']);
                        if ($discount) {
                            $product['price'] = $this->currency->format($this->tax->calculate($discount, $product['tax_class_id'], $this->config->get('config_tax')));
                        } else {
                            $product['price'] = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
                            $special = $this->modelProduct->getProductSpecial($product['product_id']);
                            if ($special) {
                                $product['special'] = $this->currency->format($this->tax->calculate($special, $product['tax_class_id'], $this->config->get('config_tax')));
                            }
                        }

                        $discounts = $this->modelProduct->getProductDiscounts($product['product_id']);
                        foreach ($discounts as $k => $discount) {
                            $product['discounts'][$k] = array(
                                'quantity' => $discount['quantity'],
                                'price' => $this->currency->format($this->tax->calculate($discount['price'], $product['tax_class_id'], $this->config->get('config_tax')))
                            );
                        }

                        $results = $this->modelProduct->getProductImages($product['product_id']);
                        foreach ($results as $k => $result) {
                            $product['images'][$k] = array(
                                'thumb' => NTImage::resizeAndSave($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
                            );
                        }

                        $results = $this->modelProduct->getProductTags($product['product_id']);
                        foreach ($results as $k => $result) {
                            if ($result['tag']) {
                                $product['tags'][$k] = array(
                                    'tag' => $result['tag'],
                                    'href' => $Url::createUrl('store/search', array('q' => $result['tag']))
                                );
                            }
                        }

                        $fullname = ($userInfo->name) ? addslashes($userInfo->name) : $this->config->get('config_title');
                        $newsletter = $this->modelNewsletter->getById($this->config->get('marketing_email_promote_product'));
                        if ($newsletter) {
                            $data = array(
                                'newsletter_id' => $newsletter['newsletter_id'],
                                'name' => "Invitar Amigos de " . $this->db->escape($fullname) . " (" . $this->db->escape(addslashes($userInfo->email)) . ") en Google",
                                'subject' => 'Hola',
                                'from_name' => $this->db->escape($fullname),
                                'from_email' => $this->db->escape($this->config->get('config_email')),
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
                                'product_id' => $product_id,
                                'campaign_id' => $campaign_id
                            );

                            $this->load->library('task');
                            $task = new Task($this->registry);

                            $task->object_id = (int) $campaign_id;
                            $task->object_type = 'campaign';
                            $task->task = $data['name'];
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
                                    'product' => $product,
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
                    }
                }
                $this->session->set('success', $this->language->get('text_promote_product_success'));
            }
            $this->redirect($Url::createUrl('store/product', array('product_id' => $product['product_id'])));
        } else {
            $this->redirect($this->oauth_url);
        }
    }

    public function login() {
        if ($this->customer->isLogged()) {
            $this->redirect(Url::createUrl("account/account"));
        }

        if (!$this->config->get('social_google_client_id') || !$this->config->get('social_google_client_secret')) {
            $this->redirect(Url::createUrl("account/login", array("error" => urlencode("No se pudo iniciar sesion utilizando Google, por favor intente con otro servicio"))));
        }

        if ($this->google->getAccessToken()) {
            /*
              //TODO: pasar un token temporal para evitar csrf
              if (!$this->session->has('state') && $this->session->get('state') != $this->request->getQuery('state')) {
              $this->redirect(Url::createUrl("account/login",array("error"=>"No se pudo iniciar sesion utilizando Google, por favor intente con otro servicio")));
              }
             */

            if ($this->google->isAccessTokenExpired()) {
                $this->google->revokeToken($_SESSION['gtoken']);
                unset($_SESSION['gtoken']);
                unset($_SESSION['gcode']);
                unset($_SESSION['gaction']);
            }

            $reqUrl = 'https://www.googleapis.com/oauth2/v2/userinfo';
            $req = new Google_Http_Request($reqUrl);
            $userInfo = json_decode($this->google->getAuth()->authenticatedRequest($req)->getResponseBody());
            $token = json_decode($this->google->getAccessToken());

            $photo = str_replace(' ', '_', strtolower($userInfo->name)) . '_' . md5(uniqid() . time()) . '.jpg';
            file_put_contents(DIR_IMAGE . $photo, file_get_contents($userInfo->picture));

            $data = array(
                'oauth_provider' => 'google',
                'company' => $userInfo->name,
                'firstname' => $userInfo->given_name,
                'lastname' => $userInfo->family_name,
                'sex' => substr($userInfo->gender, 0, 1),
                'email' => $userInfo->email,
                'photo' => $photo,
                'google_oauth_id' => $userInfo->id,
                'google_oauth_token' => $token->access_token,
                'google_oauth_refresh' => $token->refresh_token,
                'google_code' => $_SESSION['gcode']
            );

            $this->load->model('account/customer');
            $result = $this->modelCustomer->getCustomerByGoogle($data);
            if ($result) {
                if ($this->customer->loginWithGoogle($data)) {
                    if ($this->session->has('redirect')) {
                        $this->redirect(str_replace('&amp;', '&', $this->session->get('redirect')));
                    } else {
                        $this->redirect(Url::createUrl("common/home"));
                    }
                } else {
                    $this->redirect(Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Google, por favor intente con otro servicio")));
                }
            } elseif ($customer = $this->modelCustomer->addCustomerFromGoogle($data)) {
                if ($this->config->get('marketing_email_send_password_and_welcome')) {
                    $this->load->model('marketing/newsletter');
                    $newsletter = $this->modelNewsletter->getById($this->config->get('marketing_email_send_password_and_welcome'));
                    if ($newsletter) {
                        $message = $this->prepareTemplate(html_entity_decode($newsletter['htmlbody']));
                        $message = str_replace('{%password%}', $customer['password'], $message);
                        $message = str_replace("{%fullname%}", $userInfo->name, $message);
                        $message = str_replace("{%rif%}", '', $message);
                        $message = str_replace("{%company%}", $userInfo->name, $message);
                        $message = str_replace("{%email%}", $userInfo->email, $message);
                        $message = str_replace("{%telephone%}", '', $message);
                        $this->load->library('email/mailer');
                        $this->mailer = new Mailer;
                        if ($this->config->get('config_smtp_method') == 'smtp') {
                            $this->mailer->IsSMTP();
                            $this->mailer->Hostname = $this->config->get('config_smtp_host');
                            $this->mailer->Username = $this->config->get('config_smtp_username');
                            $this->mailer->Password = base64_decode($this->config->get('config_smtp_password'));
                            $this->mailer->Port = $this->config->get('config_smtp_port');
                            $this->mailer->Timeout = $this->config->get('config_smtp_timeout');
                            $this->mailer->SMTPSecure = $this->config->get('config_smtp_ssl');
                            $this->mailer->SMTPAuth = ($this->config->get('config_smtp_auth')) ? true : false;
                        } elseif ($this->config->get('config_smtp_method') == 'sendmail') {
                            $this->mailer->IsSendmail();
                        } else {
                            $this->mailer->IsMail();
                        }

                        $this->mailer->AddAddress($userInfo->email, $userInfo->name);
                        $this->mailer->IsHTML();
                        $this->mailer->SetFrom($this->config->get('config_email'), $this->config->get('config_name'));
                        $this->mailer->Subject = "Bienvenidos - " . $this->config->get('config_name');
                        $this->mailer->Body = $message;
                        $this->mailer->Send();
                    }
                }

                if ($this->customer->loginWithGoogle($data)) {
                    $this->redirect(Url::createUrl("account/complete_profile"));
                } else {
                    $this->redirect(Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Google, por favor intente con otro servicio")));
                }
            }
        } else {
            $this->redirect($this->google->createAuthUrl());
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
