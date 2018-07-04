<?php

class ControllerPaymentPPStandard extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('payment/pp_standard');
        $this->document->title = $this->language->get('heading_title');

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->modelSetting->update('pp_standard', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('payment/pp_standard'));
            } else {
                $this->redirect(Url::createAdminUrl('extension/payment'));
            }
        }

        $this->data['error_warning'] = (isset($this->error['warning'])) ? $this->error['warning'] : '';
        $this->data['error_email'] = (isset($this->error['email'])) ? $this->error['email'] : '';

        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => HTTP_HOME . 'index.php?r=common/home&token=' . $this->session->data['token'],
            'text' => $this->language->get('text_home'),
            'separator' => FALSE
        );
        $this->document->breadcrumbs[] = array(
            'href' => HTTP_HOME . 'index.php?r=extension/payment&token=' . $this->session->data['token'],
            'text' => $this->language->get('text_payment'),
            'separator' => ' :: '
        );
        $this->document->breadcrumbs[] = array(
            'href' => HTTP_HOME . 'index.php?r=payment/pp_standard&token=' . $this->session->data['token'],
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $this->data['action'] = HTTP_HOME . 'index.php?r=payment/pp_standard&token=' . $this->session->data['token'];
        $this->data['cancel'] = HTTP_HOME . 'index.php?r=extension/payment&token=' . $this->session->data['token'];

        $this->setvar('pp_standard_image');
        $this->setvar('pp_standard_order_status_id');
        $this->setvar('pp_standard_newsletter_id');
        $this->setvar('pp_standard_email');
        $this->setvar('pp_standard_test');
        $this->setvar('pp_standard_transaction');
        $this->setvar('pp_standard_app_id');
        $this->setvar('pp_standard_app _secret');
        $this->setvar('pp_standard_geo_zone_id');
        $this->setvar('pp_standard_status');
        $this->setvar('pp_standard_sort_order');

        if ($this->data['pp_standard_image'] && file_exists(DIR_IMAGE . $this->data['pp_standard_image'])) {
            $this->data['preview'] = NTImage::resizeAndSave($this->data['pp_standard_image'], 100, 100);
        } else {
            $this->data['preview'] = NTImage::resizeAndSave('no_image.jpg', 100, 100);
        }

        $this->load->model('localisation/orderstatus');
        $this->data['order_statuses'] = $this->modelOrderstatus->getAll();

        $this->load->model('localisation/geozone');
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

        $this->template = 'payment/pp_standard.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'payment/pp_standard')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['pp_standard_email']) {
            $this->error['email'] = $this->language->get('error_email');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
