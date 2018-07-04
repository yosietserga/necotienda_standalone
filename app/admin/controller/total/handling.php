<?php

class ControllerTotalHandling extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('total/handling');

        $this->document->title = $this->language->get('heading_title');

        $this->load->auto('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->modelSetting->update('handling', $this->request->post);

            $this->session->set('success', $this->language->get('text_success'));

            if ($_POST['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('total/handling'));
            } else {
                $this->redirect(Url::createAdminUrl('extension/total'));
            }
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_none'] = $this->language->get('text_none');

        $this->data['entry_total'] = $this->language->get('entry_total');
        $this->data['entry_fee'] = $this->language->get('entry_fee');
        $this->data['entry_tax'] = $this->language->get('entry_tax');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_save_and_keep'] = $this->language->get('button_save_and_keep');
        $this->data['button_save_and_exit'] = $this->language->get('button_save_and_exit');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['tab_general'] = $this->language->get('tab_general');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('extension/total'),
            'text' => $this->language->get('text_total'),
            'separator' => ' :: '
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('total/handling'),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $this->data['action'] = Url::createAdminUrl('total/handling');

        $this->data['cancel'] = Url::createAdminUrl('extension/total');

        if (isset($this->request->post['handling_total'])) {
            $this->data['handling_total'] = $this->request->post['handling_total'];
        } else {
            $this->data['handling_total'] = $this->config->get('handling_total');
        }

        if (isset($this->request->post['handling_fee'])) {
            $this->data['handling_fee'] = $this->request->post['handling_fee'];
        } else {
            $this->data['handling_fee'] = $this->config->get('handling_fee');
        }

        if (isset($this->request->post['handling_tax_class_id'])) {
            $this->data['handling_tax_class_id'] = $this->request->post['handling_tax_class_id'];
        } else {
            $this->data['handling_tax_class_id'] = $this->config->get('handling_tax_class_id');
        }

        if (isset($this->request->post['handling_status'])) {
            $this->data['handling_status'] = $this->request->post['handling_status'];
        } else {
            $this->data['handling_status'] = $this->config->get('handling_status');
        }

        if (isset($this->request->post['handling_sort_order'])) {
            $this->data['handling_sort_order'] = $this->request->post['handling_sort_order'];
        } else {
            $this->data['handling_sort_order'] = $this->config->get('handling_sort_order');
        }

        $this->load->auto('localisation/taxclass');

        $this->data['tax_classes'] = $this->modelTaxclass->getAll();

        $this->data['Url'] = new Url;

        $scripts[] = array('id' => 'scriptForm', 'method' => 'ready', 'script' =>
            "$('#form').ntForm({
                submitButton:false,
                cancelButton:false,
                lockButton:false
            });
            $('textarea').ntTextArea();
            
            var form_clean = $('#form').serialize();  
            
            window.onbeforeunload = function (e) {
                var form_dirty = $('#form').serialize();
                if(form_clean != form_dirty) {
                    return 'There is unsaved form data.';
                }
            };
            
            $('.sidebar .tab').on('click',function(){
                $(this).closest('.sidebar').addClass('show').removeClass('hide').animate({'right':'0px'});
            });
            $('.sidebar').mouseenter(function(){
                clearTimeout($(this).data('timeoutId'));
            }).mouseleave(function(){
                var e = this;
                var timeoutId = setTimeout(function(){
                    if ($(e).hasClass('show')) {
                        $(e).removeClass('show').addClass('hide').animate({'right':'-400px'});
                    }
                }, 600);
                $(this).data('timeoutId', timeoutId); 
            });");

        $scripts[] = array('id' => 'scriptFunctions', 'method' => 'function', 'script' =>
            "function saveAndExit() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndExit'>\").submit(); 
            }
            
            function saveAndKeep() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndKeep'>\").submit(); 
            }");

        $this->scripts = array_merge($this->scripts, $scripts);

        $template = ($this->config->get('default_admin_view_total_handling')) ? $this->config->get('default_admin_view_total_handling') : 'total/handling.tpl';
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_admin_template') . '/'. $template)) {
            $this->template = $this->config->get('config_admin_template') . '/' . $template;
        } else {
            $this->template = 'default/' . $template;
        }


        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'total/handling')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
