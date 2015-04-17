<?php

require_once( DIR_SYSTEM . 'library/facebook/autoload.php' );

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;

class ControllerApiFacebook extends Controller {

    protected $fb;
    protected $ftoken;

    public function index() {
        if ($this->config->get('social_facebook_app_id') && $this->config->get('social_facebook_app_secret')) {

            $this->fb = FacebookSession::setDefaultApplication($this->config->get('social_facebook_app_id'), $this->config->get('social_facebook_app_secret'));
            if ($this->request->hasQuery('redirect')) {
                $_SESSION['action'] = $this->request->getQuery('redirect');
            }
            if ($this->request->hasQuery('code')) {
                $_SESSION['fcode'] = $this->request->getQuery('code');
                //$this->redirect(Url::createUrl('api/facebook'));
            }echo __LINE__ . '<br />';

            $redirect_uri = HTTP_HOME . 'api/facebook';
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
            $helper = new FacebookRedirectLoginHelper($redirect_uri);
            $params = array(
                'scope' => 'read_stream, friends_likes, email, user_interests, publish_actions, user_photos, read_insights, read_mailbox, read_page_mailboxes, manage_pages'
            );
            echo __LINE__ . '<br />';
            if (!isset($_SESSION['fcode'])) {
                $this->redirect($helper->getLoginUrl($params));
            }
            echo __LINE__ . '<br />';
            if (isset($_SESSION['ftoken'])) {
                $this->fb = new FacebookSession($_SESSION['ftoken']);
                try {
                    if (!$this->fb->validate()) {
                        $this->fb = null;
                    }
                } catch (Exception $e) {
                    $this->fb = null;
                }
            } else {
                try {
                    $this->fb = $helper->getSessionFromRedirect();
                } catch (FacebookRequestException $ex) {
                    echo $ex . '<br />';
                } catch (Exception $ex) {
                    echo $ex . '<br />';
                }
            }
            echo __LINE__ . '<br />';
            if ($this->fb) {
                if (!isset($_SESSION['ftoken'])) {
                    $_SESSION['ftoken'] = $this->fb->getToken();
                }
                echo __LINE__ . '<br />';
                $actions = array(
                    'invitefriends',
                    'login',
                    'promote',
                    'inboxlist'
                );
                if (in_array($_SESSION['action'], $actions)) {
                    echo __LINE__ . '<br />';
                    if ($_SESSION['action'] === 'login') {

                        try {
                            $request = new FacebookRequest($this->fb, 'GET', '/me');
                            $response = $request->execute();
                            $this->login($response->getGraphObject());
                        } catch (FacebookRequestException $e) {
                            echo __LINE__ . ': ' . $e->getCode() . '<br />';
                            echo __LINE__ . ': ' . $e->getMessage() . '<br />';
                        }
                    }

                    if ($_SESSION['action'] === 'promote') {
                        echo __LINE__ . '<br />';
                        try {
                            $request = new FacebookRequest($this->fb, 'POST', '/me/feed', array(
                                'link' => 'http://www.necoyoad.com',
                                'message' => 'Test: Auto post from NecoTienda ' . date('d-m-Y h:i:s')
                            ));
                            $response = $request->execute();
                            $graphObject = $response->getGraphObject();
                        } catch (FacebookRequestException $e) {
                            echo __LINE__ . ': ' . $e->getCode() . '<br />';
                            echo __LINE__ . ': ' . $e->getMessage() . '<br />';
                        }
                    }

                    if ($_SESSION['action'] === 'invitefriends') {
                        echo __LINE__ . '<br />';

                        try {
                            $request = new FacebookRequest($this->fb, 'GET', '/me/friends');
                            $response = $request->execute();

                            $graphObject = $response->getGraphObject();
                        } catch (FacebookRequestException $e) {
                            echo __LINE__ . ': ' . $e->getCode() . '<br />';
                            echo __LINE__ . ': ' . $e->getMessage() . '<br />';
                        }
                    }

                    echo __LINE__ . '<br />';
                    $this->{$_SESSION['action']}($graphObject);
                } else {
                    unset($_SESSION['ftoken']);
                    unset($_SESSION['fcode']);
                    /*
                      if ($this->session->has('redirect')) {
                      $this->redirect($this->session->get('redirect'));
                      } else {
                      $this->redirect(HTTP_HOME);
                      }
                     */
                }
            } else {
                $this->redirect($helper->getLoginUrl($params));
            }
        }
    }

    public function login($fb) {

        if ($this->customer->isLogged()) {
            $this->redirect(Url::createUrl("account/account"));
        }

        if (!$this->customer->isLogged() && (!$this->config->get('social_facebook_app_id') || !$this->config->get('social_facebook_app_secret'))) {
            $this->redirect(Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Facebook, por favor intente con otro servicio")));
        }
        echo __LINE__ . '<br />';
        if ($fb) {
            /**
              $graphObject = object(Facebook\GraphObject) {
              ["backingData":protected] => array(12) {
              ["id"]=> string(10) "1518317082"
              ["birthday"]=> string(10) "12/20/1985"
              ["email"]=> string(23) "yosietserga@hotmail.com"
              ["first_name"]=> string(6) "Yosiet"
              ["gender"]=> string(4) "male"
              ["last_name"]=> string(5) "Serga"
              ["link"]=> string(34) "http://www.facebook.com/1518317082"
              ["locale"]=> string(5) "es_ES"
              ["name"]=> string(12) "Yosiet Serga"
              ["timezone"]=> float(-4.5)
              ["updated_time"]=> string(24) "2013-11-08T00:36:26+0000"
              ["verified"]=> bool(true)
              }
              }
             * */
            echo __LINE__ . '<br />';
            $data = array(
                'email' => $fb->getEmail(),
                'company' => $fb->getName(),
                'firstname' => $fb->getFirstName(),
                'lastname' => $fb->getLastName(),
                'oauth_provider' => 'facebook',
                'oauth_id' => $fb->getId()
            );
            $this->load->auto('account/customer');
            echo __LINE__ . '<br />';
            $result = $this->modelCustomer->getCustomerByEmail($fb->getEmail());
            echo __LINE__ . '<br />';
            if ($result) {
                echo __LINE__ . '<br />';
                if ($this->customer->loginWithFacebook($data)) {
                    echo __LINE__ . '<br />';
                    if ($this->session->has('redirect')) {
                        $this->redirect(str_replace('&amp;', '&', $this->session->get('redirect')));
                    } else {
                        $this->redirect(Url::createUrl("common/home"));
                    }
                } else {
                    $this->redirect(Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Facebook, por favor intente con otro servicio")));
                }
            } elseif ($this->modelCustomer->addCustomer($data)) {
                if ($this->customer->loginWithFacebook($data)) {
                    if ($this->session->has('redirect')) {
                        $this->redirect(str_replace('&amp;', '&', $this->session->get('redirect')));
                    } else {
                        $this->redirect(Url::createUrl("common/home"));
                    }
                } else {
                    $this->redirect(Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Facebook, por favor intente con otro servicio")));
                }
            }
        } else {
            
        }
    }

    public function promote($fb) {

        if ($fb) {
            echo "Posted with id: <a href=\"http://www.facebook.com/" . $fb->getProperty('id') . '">Ver Publicacion</a>';

            try {
                $request = new FacebookRequest($this->fb, 'POST', '/me/feed', array(
                    'link' => 'http://www.necoyoad.com',
                    'message' => 'Test: Auto post from NecoTienda ' . date()
                ));
                $response = $request->execute();
                // get response
                $graphObject = $response->getGraphObject();
                echo "Posted with id: <a href=\"http://www.facebook.com/" . $response->getProperty('id') . '">Ver Publicacion</a>';
            } catch (FacebookRequestException $e) {
                echo __LINE__ . ': ' . $e->getCode() . '<br />';
                echo __LINE__ . ': ' . $e->getMessage() . '<br />';
            }
        } else {
            
        }
    }

    public function inviteFriends() {
        
    }

}
