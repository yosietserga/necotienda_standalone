<?php
/*
* ver. 0.2.0
* PayU Payment Modules
*
* @copyright  Copyright 2014 by PayU
* @license    http://opensource.org/licenses/GPL-3.0  Open Software License (GPL 3.0)
* http://www.payu.com
* http://twitter.com/openpayu
*/
class ControllerPaymentPayU extends Controller {
    private $error = array();

    //Config page
    public function index() {
        $this->load->language('payment/payu');
        
        $this->document->title = $this->language->get('heading_title');

        $this->load->auto('setting/setting');

        //new config
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->modelSetting->update('openpayu', $this->request->post);
            $this->session->set('success', $this->language->get('text_success'));
            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('payment/payu'));
            } else {
                $this->redirect(Url::createAdminUrl('extension/payment'));
            }
        }

        //error data
        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }
        if (isset($this->error['accountid'])) {
            $this->data['error_accountid'] = $this->error['accountid'];
        } else {
            $this->data['error_accountid'] = '';
        }
        if (isset($this->error['merchantid'])) {
            $this->data['error_merchantid'] = $this->error['merchantid'];
        } else {
            $this->data['error_merchantid'] = '';
        }
        if (isset($this->error['api_login'])) {
            $this->data['error_api_login'] = $this->error['error_api_login'];
        } else {
            $this->data['error_api_login'] = '';
        }
        if (isset($this->error['api_key'])) {
            $this->data['error_api_key'] = $this->error['error_api_key'];
        } else {
            $this->data['error_api_key'] = '';
        }
        if (isset($this->error['sort_order'])) {
            $this->data['error_sort_order'] = $this->error['sort_order'];
        } else {
            $this->data['error_sort_order'] = '';
        }

        //preloaded config
        $this->setvar('payu_test_mode');
        $this->setvar('payu_newsletter_id');
        $this->setvar('payu_accountid');
        $this->setvar('payu_merchantid');
        $this->setvar('payu_api_key');
        $this->setvar('payu_api_login');
        $this->setvar('payu_status');
        $this->setvar('payu_new_status');
        $this->setvar('payu_reject_status');
        $this->setvar('payu_sent_status');
        $this->setvar('payu_failed_status');
        $this->setvar('payu_returned_status');
        $this->setvar('payu_cancelled_status');
        $this->setvar('payu_pending_status');
        $this->setvar('payu_complete_status');
        $this->setvar('payu_sort_order');

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => Url::createAdminUrl('common/home'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => Url::createAdminUrl('extension/payment'),
            'separator' => ' :: '
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => Url::createAdminUrl('payment/payu'),
            'separator' => ' :: '
        );

        $this->data['action'] = Url::createAdminUrl('payment/payu');
        $this->data['cancel'] = Url::createAdminUrl('extension/payment');

        $this->load->auto('localisation/orderstatus');
        $this->data['order_statuses'] = $this->modelOrderstatus->getAll();

        $this->load->auto('localisation/geozone');
        $this->data['geo_zones'] = $this->modelGeozone->getAll();

        $this->load->model('marketing/newsletter');
        $this->data['newsletters'] = $this->modelNewsletter->getAll();

        $scripts[] = array('id' => 'categoryFunctions', 'method' => 'function', 'script' =>
            "function image_delete(field, preview) {
                $('#' + field).val('');
                $('#' + preview).attr('src','" . HTTP_IMAGE . "cache/no_image-100x100.jpg');
            }

            function image_upload(field, preview) {
                var height = $(window).height() * 0.8;
                var width = $(window).width() * 0.8;

            	$('#dialog').remove();
            	$('.box').prepend('<div id=\"dialog\" style=\"padding: 3px 0px 0px 0px;z-index:10000;\"><iframe src=\"" . Url::createAdminUrl("common/filemanager") . "&field=' + encodeURIComponent(field) + '\" style=\"padding:0; margin: 0; display: block; width: 100%; height: 100%;z-index:10000;\" frameborder=\"no\" scrolling=\"auto\"></iframe></div>');

                $('#dialog').dialog({
            		title: '" . $this->data['text_image_manager'] . "',
            		close: function (event, ui) {
            			if ($('#' + field).attr('value')) {
            				$.ajax({
            					url: '" . Url::createAdminUrl("common/filemanager/image") . "',
            					type: 'POST',
            					data: 'image=' + encodeURIComponent($('#' + field).val()),
            					dataType: 'text',
            					success: function(data) {
            						$('#' + preview).replaceWith('<img src=\"' + data + '\" id=\"' + preview + '\" class=\"image\" onclick=\"image_upload(\'' + field + '\', \'' + preview + '\');\">');
            					}
            				});
            			}
            		},
            		bgiframe: false,
            		width: width,
            		height: height,
            		resizable: false,
            		modal: false
            	});}");

        $this->scripts = array_merge($this->scripts, $scripts);

        $this->template = 'payment/payu.tpl';

        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';

        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    } //index


    //validate
    private function validate()
    {
        //permisions
        if (!$this->user->hasPermission('modify', 'payment/payu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        //check for errors
        if (!$this->request->hasPost('payu_accountid')) {
            $this->error['accountid'] = $this->language->get('error_accountid');
        }
        if (!$this->request->hasPost('payu_merchantid')) {
            $this->error['merchantid'] = $this->language->get('error_merchantid');
        }
        if (!$this->request->hasPost('payu_api_key')) {
            $this->error['api_key'] = $this->language->get('error_api_key');
        }
        if (!$this->request->hasPost('payu_api_login')) {
            $this->error['error_api_login'] = $this->language->get('error_api_login');
        }
        if (!$this->request->post['payu_sort_order']) {
            $this->error['sort_order'] = $this->language->get('error_sort_order');
        }
        //if errors correct them
        if (!$this->error) {
            return true;
        } else {
            return false;
        }

    }

    public function install()
    {
        $this->load->model('payment/payu');
        $this->modelPayu->install();
    }

    public function uninstall()
    {
        $this->load->model('payment/payu');
        $this->modelPayu->uninstall();
    }
}