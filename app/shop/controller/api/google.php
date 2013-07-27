<?php
class ControllerApiFacebook extends Controller {
	public function index() {
	    if ($this->customer->isLogged()) {  
      		$this->redirect(Url::createUrl("account/account"));
    	}
        
	    if (!$this->customer->isLogged() && (!$this->config->get('social_google_client_id') || !$this->config->get('social_google_client_secret'))) {  
      		$this->redirect(Url::createUrl("account/login",array("error"=>"No se pudo iniciar sesion utilizando Facebook, por favor intente con otro servicio")));
    	}
        
        $this->load->library('google_sdk/Google_Client');
        $this->load->library('google_sdk/contrib/Google_PlusService');
        
        $google = new Google_Client();
        $google->setApplicationName($this->config->get('config_name'));
        $google->setClientId($this->config->get('social_google_client_id'));
        $google->setClientSecret($this->config->get('social_google_client_secret'));
        $google->setRedirectUri('postmessage');
        
        $plus = new Google_PlusService($google);
        
        if ($_SERVER['REQUEST'] == 'POST' && !$this->session->has('gtoken')) {
            if (!$this->session->has('state') && $this->session->get('state') != $this->request->getQuery('state')) {
                $this->redirect(Url::createUrl("account/login",array("error"=>"No se pudo iniciar sesion utilizando Google, por favor intente con otro servicio")));
            }
            
            $code = $this->request->post['code'];
            $gPlusId = $this->request->getQuery('gplus_id');
            
            $google->authenticate($code);
            $token = json_decode($google->getAccessToken());
            
            $reqUrl = 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=' . $token->access_token;
            $req = new Google_HttpRequest($reqUrl);
            $tokenInfo = json_decode($google::getIo()->authenticatedRequest($req)->getResponseBody());
            if ($tokenInfo->error || $tokenInfo->userid != $gPlusId || $tokenInfo->audience != $this->config->get('social_google_client_id')) {
                $this->redirect(Url::createUrl("account/login",array("error"=>"No se pudo iniciar sesion utilizando Google, por favor intente con otro servicio")));
            }
            
            if ($this->session->has('gtoken')) {
                $google->setAccessToken($this->session->get('gtoken'));
            }
            
            if ($google->getAccessToken()) {
                $me = $plus->people->get('me');
                $optParams = array('maxResults' => 100);
                $activities = $plus->activities->listActivities('me', 'public',$optParams);
                
                $this->session->set('gtoken',$google->getAccessToken());
            } else {
                $authUrl = $google->createAuthUrl();
            }
            
            $data = array(
                'company'       => $user_profile['displayName'],
                'firstname'     => $user_profile['displayName'],
                'oauth_provider'=> 'google',
                'oauth_id'      => $user_profile['id']
            );
            
            $result = $this->modelCustomer->getCustomerByGoogle($data);
            if ($result) {
                if ($this->customer->loginWithGoogle($data)) {
                    if ($this->session->has('redirect')) {
                        $this->redirect(str_replace('&amp;', '&', $this->session->get('redirect')));
         			} else {
                        $this->redirect(Url::createUrl("common/home"));
         			} 
                } else {
                    $this->redirect(Url::createUrl("account/login",array("error"=>"No se pudo iniciar sesion utilizando Google, por favor intente con otro servicio")));
                }
            } elseif ($this->modelCustomer->addCustomerFromGoogle($data)) {
                if ($this->customer->loginWithGoogle($data)) {
                    $this->redirect(Url::createUrl("account/complete_profile"));
                } else {
                    $this->redirect(Url::createUrl("account/login",array("error"=>"No se pudo iniciar sesion utilizando Google, por favor intente con otro servicio")));
                }
            }
            
            $this->load->library('json');
            $this->session->set("gtoken",Json::encode($token));
        }
    }
}
