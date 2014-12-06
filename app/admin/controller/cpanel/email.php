<?php

/**
 * ControllerCpanelEmail
 * 
 * @package NecoTienda
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerCpanelEmail extends Controller {

    private $error = array();

    /**
     * ControllerCpanelEmail::index()
     * 
     * @see Load
     * @see Document
     * @see Language
     * @see getList
     * @return void 
     */
    public function index() {
        $this->load->language('cpanel/email');
echo __LINE__.__FILE__;
        $this->document->title = $this->language->get('heading_title');

        $this->load->library('cpxmlapi');echo __LINE__.__FILE__;
        $cp = new xmlapi(CPANEL_HOST);echo __LINE__.__FILE__;
        $cp->set_port(CPANEL_PORT); echo __LINE__.__FILE__; //set port number. cpanel client class allow you to access WHM as well using WHM port.echo __LINE__.__FILE__;
        $cp->password_auth(CPANEL_USER, CPANEL_PWD);echo __LINE__.__FILE__;   // authorization with password. not as secure as hash.
        // cpanel email addpop function Parameters
        $call = array('domain' => CPANEL_DOMAIN, 'email' => $this->request->post['email'], 'password' => $this->request->post['password'], 'quota' => CPANEL_EMAIL_QUOTA);
        $cp->set_debug(1);      //output to error file  set to 1 to see error_log.
echo __LINE__.__FILE__;
        $result = $cp->api2_query(CPANEL_USER, "Email", "listpopswithdisk"); // making call to cpanel api
        //$result2 = $cp->api2_query(CPANEL_USER, "StatsBar", "stat", array('display' => 'bandwidthusage|ftpaccounts|operatingsystem|diskusage|mysqldiskusage'));
echo __LINE__.__FILE__;
        $this->data['accounts'] = $result;
        $this->getList();
    }

    /**
     * ControllerCpanelEmail::insert()
     * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
     * @see getForm
     * @return void 
     */
    public function insert() {
        $this->load->language('cpanel/email');
        $this->document->title = $this->language->get('heading_title');
        $this->load->library('cpxmlapi');
        $cp = new xmlapi(CPANEL_HOST);
        if (($this->request->server['REQUEST_METHOD'] == 'POST') /* && $this->validateForm() */) {
            $cp->set_port(CPANEL_PORT);  //set port number. cpanel client class allow you to access WHM as well using WHM port.
            $cp->password_auth(CPANEL_USER, CPANEL_PWD);   // authorization with password. not as secure as hash.
            // cpanel email addpop function Parameters
            $call = array('domain' => CPANEL_DOMAIN, 'email' => $this->request->post['email'], 'password' => $this->request->post['password'], 'quota' => CPANEL_EMAIL_QUOTA);
            $cp->set_debug(0);      //output to error file  set to 1 to see error_log.
            $result = $cp->api2_query(CPANEL_USER, "Email", "addpop", $call); // making call to cpanel api
            if ($result->data->result == 1) {
                $this->session->data['success'] = " La cuenta " . $this->request->post['email'] . '@' . CPANEL_DOMAIN . ' ha sido creada con &eacute;xito';
            } else {
                $this->session->data['error'] = "No se pudo crear la cuenta de correo: " . $result->data->reason;
            }
            $this->redirect(Url::createAdminUrl('cpanel/email') . $url);
        }
        $this->getForm();
    }

    /**
     * ControllerCpanelEmail::delete()
     * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Redirect
     * @see getList
     * @return void 
     */
    public function delete() {
        $this->load->library('cpxmlapi');
        $cp = new xmlapi(CPANEL_HOST);
        if (isset($this->request->post['selected']) /* && $this->validateDelete() */) {
            $cp->set_port(CPANEL_PORT);  //set port number. cpanel client class allow you to access WHM as well using WHM port.
            $cp->password_auth(CPANEL_USER, CPANEL_PWD);   // authorization with password. not as secure as hash.
            $cp->set_debug(0);      //output to error file  set to 1 to see error_log.
            foreach ($this->request->post['selected'] as $user) {
                // cpanel email addpop function Parameters
                $call = array('domain' => CPANEL_DOMAIN, 'email' => $user);
                $result = $cp->api2_query(CPANEL_USER, "Email", "delpop", $call); // making call to cpanel api
            }

            if ($result->data->result == 1) {
                $this->session->data['success'] = " La(s) cuenta(s) han sido eliminada(s) con &eacute;xito";
            } else {
                $this->session->data['error'] = "No se pudo eliminar la cuenta de correo: " . $result->data->reason;
            }
        }
        $this->redirect(Url::createAdminUrl('cpanel/email') . $url);
    }

    /**
     * ControllerCpanelEmail::getById()
     * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Response
     * @see Request     
     * @return void 
     */
    private function getList() {
        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => FALSE
        );
        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('cpanel/email'),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

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

        $this->template = 'cpanel/email_list.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    /**
     * ControllerCpanelEmail::getForm()
     * 
     * @see Load
     * @see Document
     * @see Language
     * @see Session
     * @see Response
     * @see Request     
     * @return void 
     */
    private function getForm() {
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['email'])) {
            $this->data['error_email'] = $this->error['email'];
        } else {
            $this->data['error_email'] = '';
        }

        if (isset($this->error['password'])) {
            $this->data['error_password'] = $this->error['password'];
        } else {
            $this->data['error_password'] = '';
        }

        if (isset($this->error['confirm'])) {
            $this->data['error_confirm'] = $this->error['confirm'];
        } else {
            $this->data['error_confirm'] = '';
        }

        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => FALSE
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('cpanel/email') . $url,
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $this->data['action'] = Url::createAdminUrl('cpanel/email/insert') . $url;
        $this->data['cancel'] = Url::createAdminUrl('cpanel/email') . $url;

        if (isset($this->request->post['email'])) {
            $this->data['email'] = $this->request->post['email'];
        } else {
            $this->data['email'] = '';
        }

        $this->template = 'cpanel/email_form.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    /**
     * ControllerCpanelEmail::validateForm()
     * 
     * @return
     */
    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'cpanel/email')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $pattern = '/^[A-Z0-9._%-]$/i';

        if ((strlen(utf8_decode($this->request->post['email'])) > 96) || (!preg_match($pattern, $this->request->post['email']))) {
            $this->error['email'] = $this->language->get('error_email');
        }

        if (($this->request->post['password']) || (!isset($this->request->get['customer_id']))) {
            if ((strlen(utf8_decode($this->request->post['password'])) < 4) || (strlen(utf8_decode($this->request->post['password'])) > 20)) {
                $this->error['password'] = $this->language->get('error_password');
            }

            if ($this->request->post['password'] != $this->request->post['confirm']) {
                $this->error['confirm'] = $this->language->get('error_confirm');
            }
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * ControllerCpanelEmail::validateDelete()
     * 
     * @return
     */
    private function validateDelete() {
        if (!$this->user->hasPermission('modify', 'cpanel/email')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
