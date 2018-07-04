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
use Facebook\GraphUser;

class ControllerApiFacebook extends Controller {

    protected $fb;
    protected $ftoken;

    private function initialize() {
        if ($this->config->get('social_facebook_app_id') && $this->config->get('social_facebook_app_secret')) {

            $this->fb = FacebookSession::setDefaultApplication($this->config->get('social_facebook_app_id'), $this->config->get('social_facebook_app_secret'));
        } else {
            return false;
        }
    }

    public function index() {
        $Url = new Url($this->registry);
        if (!$this->initialize()) {
            if ($this->request->hasQuery('redirect')) {
                $_SESSION['fbaction'] = $this->request->getQuery('redirect');
            }
            if ($this->request->hasQuery('code')) {
                $_SESSION['fcode'] = $this->request->getQuery('code');
                //$this->redirect($Url::createUrl('api/facebook'));
            }

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
                'scope' => 'email,'
                    . 'public_profile,'
                    . 'publish_actions,'
                    . 'publish_pages,'
                    . 'user_managed_groups,'
                    . 'user_posts,'
                    . 'user_groups,'
                    . 'user_photos,'
                /*
                . 'read_page_mailboxes,'
                . 'manage_pages,'
                . 'user_photos,'
                . 'user_posts,'
                . 'read_insights,'
                . 'pages_show_list,'
                . 'pages_manage_instant_articles,'
                . 'pages_manage_cta,'
                . 'pages_messaging,'
                . 'pages_messaging_phone_number,'
                . 'ads_read,'
                . 'ads_management,'
                */
            );

            if (!isset($_SESSION['fcode']) && !$this->request->hasQuery('error_code')) {
                $this->redirect($helper->getLoginUrl($params));
            } elseif ($this->request->hasQuery('error_code')) {
                echo $this->request->getQuery('error_message');
                $this->redirect($Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Facebook, por favor intente con otro servicio")));
            }
            $_GET['code'] = $_SESSION['fcode'];

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
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    // When Graph returns an error
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    // When validation fails or other local issues
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
            }

            if ($this->fb) {
                if (!isset($_SESSION['ftoken'])) {
                    $_SESSION['ftoken'] = $this->fb->getToken();
                }

                $fbactions = array(
                    'login',
                    'promote'
                );
                if (in_array($_SESSION['fbaction'], $fbactions)) {

                    if ($_SESSION['fbaction'] === 'login') {

                        try {
                            $request = new FacebookRequest($this->fb, 'GET', '/me');
                            $response = $request->execute();
                            $this->login($response->getGraphObject(GraphUser::className()));
                        } catch (FacebookRequestException $e) {
                            echo __LINE__ . ': ' . $e->getCode() . '<br />';
                            echo __LINE__ . ': ' . $e->getMessage() . '<br />';
                        }
                    }

                    if ($_SESSION['fbaction'] === 'promote') {
                        try {
                            /*
                            //posting in customer profile
                            $request = new FacebookRequest($this->fb, 'POST', '/me/feed', array(
                                'link' => 'http://www.necoyoad.com',
                                'message' => 'Test: Auto post from NecoTienda ' . date('d-m-Y h:i:s')
                            ));
                            $response = $request->execute();
                            $graphObject = $response->getGraphObject(GraphUser::className());
                            */

                            /*
                            //posting in customer group
                            $request = new FacebookRequest($this->fb, 'POST', '/214832205379700/feed', array(
                                'link' => 'https://www.facebook.com/permalink.php?story_fbid=1852761101623430&id=1375647206001491',
                                'message' => 'auto-post by Necoyoad.com ' . date('d-m-Y h:i:s')
                            ));
                            $response = $request->execute();
                            $graphObject = $response->getGraphObject(GraphUser::className());
                            */

                            /*
                            //posting in customer managed page
                            $request = new FacebookRequest($this->fb, 'POST', '/1375647206001491/feed', array(
                                'link' => 'http://www.necoyoad.com',
                                'message' => 'Test: Auto post from NecoTienda ' . date('d-m-Y h:i:s')
                            ));
                            $response = $request->execute();
                            $graphObject = $response->getGraphObject(GraphUser::className());
                            */


                            $request = new FacebookRequest($this->fb, 'GET', '/1375647206001491/feed');
                            $response = $request->execute();
                            $graphObject = $response->getGraphObject(GraphUser::className());

                        } catch (FacebookRequestException $e) {
                            echo __LINE__ . ': ' . $e->getCode() . '<br />';
                            echo __LINE__ . ': ' . $e->getMessage() . '<br />';
                        }
                    }
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

                unset($_SESSION['ftoken']);
                unset($_SESSION['fcode']);
                if (!$this->request->hasQuery('error_code')) {
                    $this->redirect($helper->getLoginUrl($params));
                } else {
                    echo $this->request->getQuery('error_message');
                    //$this->redirect($Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Facebook, por favor intente con otro servicio")));
                }
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


        if ($fb) {
            $data = array(
                'email' => $fb->getEmail(),
                'company' => $fb->getName(),
                'firstname' => $fb->getFirstName(),
                'lastname' => $fb->getLastName(),
                'oauth_provider' => 'facebook',
                'facebook_oauth_id' => $fb->getId(),
                'facebook_oauth_token' => $_SESSION['ftoken'],
                'facebook_code' => $_SESSION['fcode']
            );
            $this->load->auto('account/customer');

            $result = $this->modelCustomer->getCustomerByEmail($fb->getEmail());

            if ($result) {
                if ($this->customer->loginWithFacebook($data)) {
                    if ($this->session->has('redirect')) {
                        $this->redirect(str_replace('&amp;', '&', $this->session->get('redirect')));
                    } else {
                        $this->redirect(Url::createUrl("common/home"));
                    }
                } else {
                    $this->redirect(Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Facebook, por favor intente con otro servicio")));
                }
            } elseif ($customer = $this->modelCustomer->addCustomerFromFacebook($data)) {
                //TODO: send welcome message
                //TODO: post in facebook wall just once saying
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
            $this->redirect(Url::createUrl("account/login", array("error" => "No se pudo iniciar sesion utilizando Facebook, por favor intente con otro servicio")));
        }
    }

    public function promote($fb) {

        if ($fb) {
            echo "Posted with id: <a href=\"http://www.facebook.com/" . $fb->getId() . '">Ver Publicacion</a>';

            try {
                $request = new FacebookRequest($this->fb, 'POST', '/me/feed', array(
                    'link' => 'http://www.necoyoad.com',
                    'message' => 'Test: Auto post from NecoTienda ' . date()
                ));
                $response = $request->execute();
                // get response
                $graphObject = $response->getGraphObject();
                echo "Posted with id: <a href=\"http://www.facebook.com/" . $graphObject->getProperty('id') . '">Ver Publicacion</a>';
            } catch (FacebookRequestException $e) {
                echo __LINE__ . ': ' . $e->getCode() . '<br />';
                echo __LINE__ . ': ' . $e->getMessage() . '<br />';
            }
        } else {

        }
    }
}
