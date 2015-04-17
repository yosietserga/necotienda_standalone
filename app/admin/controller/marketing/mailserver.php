<?php

class ControllerMarketingCampaign extends Controller {

    private $error = array();

    public function index() {
        $this->document->title = $this->language->get('heading_title');
        $this->getList();
    }

    public function insert() {
        $this->load->auto('setting/setting');
        $this->document->title = $this->language->get('heading_title');
        if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
            $data['server'] = $this->request->getPost('server');
            $data['port'] = $this->request->getPost('port');
            $data['security'] = $this->request->getPost('security');
            $data['user'] = $this->request->getPost('user');
            $data['password'] = $this->request->getPost('password');
            
            $mail_server_id = md5(mt_rand(10000, 99999).time());
            
            $this->modelSetting->updateProperty('mail_server', $mail_server_id, serialize($data));
            
            if ($this->request->post['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('marketing/mailserver/update', array('mail_server_id' => $mail_server_id)));
            } elseif ($this->request->post['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('marketing/mailserver/insert'));
            } else {
                $this->redirect(Url::createAdminUrl('marketing/mailserver'));
            }
        } else {
            $this->getForm();
        }
    }

    public function update() {
        $this->load->auto('setting/setting');
        $this->document->title = $this->language->get('heading_title');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->modelCampaign->update($this->request->get['campaign_id'], $this->request->post);
            $this->session->set('success', $this->language->get('text_success'));

            $data['server'] = $this->request->getPost('server');
            $data['port'] = $this->request->getPost('port');
            $data['security'] = $this->request->getPost('security');
            $data['user'] = $this->request->getPost('user');
            $data['password'] = $this->request->getPost('password');
            
            $this->modelSetting->updateProperty('mail_server', $this->request->getQuery('mail_server_id'),  serialize($data));
            
            if ($this->request->post['to'] == "saveAndKeep") {
                $this->redirect(Url::createAdminUrl('marketing/mailserver/update', array('mail_server_id' => $this->request->getQuery('mail_server_id'))));
            } elseif ($this->request->post['to'] == "saveAndNew") {
                $this->redirect(Url::createAdminUrl('marketing/mailserver/insert'));
            } else {
                $this->redirect(Url::createAdminUrl('marketing/mailserver'));
            }
        }
        $this->getForm();
    }

    /**
     * ControllerMarketingList::delete()
     * elimina un objeto
     * @return boolean
     * */
    public function delete() {
        //TODO: indicar que van a quedar las camapañas de marketing sin modo de envío
        $this->load->auto('setting/setting');
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['selected'] as $id) {
                $this->modelSetting->deleteProperty('mail_server', $id);
            }
        } else {
            $this->modelSetting->deleteProperty('mail_server', $id);
        }
    }

    private function getList() {
        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('marketing/mailserver'),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $this->document->title = $this->language->get('heading_title');

        if ($this->session->has('error')) {
            $this->data['error_warning'] = $this->session->get('error');

            $this->session->clear('error');
        } elseif (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if ($this->session->has('success')) {
            $this->data['success'] = $this->session->get('success');

            $this->session->clear('success');
        } else {
            $this->data['success'] = '';
        }

        // SCRIPTS
        $scripts[] = array('id' => 'campaignList', 'method' => 'function', 'script' =>
            "function eliminar(e) {
                if (confirm('\\xbfDesea eliminar este objeto?')) {
                    $('#tr_' + e).remove();
                	$.getJSON('" . Url::createAdminUrl("marketing/mailserver/delete") . "',{
                        id:e
                    });
                }
                return false;
             }
            function deleteAll() {
                if (confirm('\\xbfDesea eliminar todos los objetos seleccionados?')) {
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                    $.post('" . Url::createAdminUrl("marketing/mailserver/delete") . "',$('#form').serialize(),function(){
                        $('#gridWrapper').load('" . Url::createAdminUrl("marketing/mailserver/grid") . "',function(){
                            $('#gridWrapper').show();
                            $('#gridPreloader').hide();
                        });
                    });
                }
                return false;
            }");
        $scripts[] = array('id' => 'sortable', 'method' => 'ready', 'script' =>
            "$('#gridWrapper').load('" . Url::createAdminUrl("marketing/mailserver/grid") . "',function(e){
                $('#gridPreloader').hide();
            });
                
            $('#formFilter').ntForm({
                lockButton:false,
                ajax:true,
                type:'get',
                dataType:'html',
                url:'" . Url::createAdminUrl("marketing/mailserver/grid") . "',
                beforeSend:function(){
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                },
                success:function(data){
                    $('#gridPreloader').hide();
                    $('#gridWrapper').html(data).show();
                }
            });
            $('#formFilter').on('keyup', function(e){
                var code = e.keyCode || e.which;
                if (code == 13){
                    $('#formFilter').ntForm('submit');
                }
            });");

        $this->scripts = array_merge($this->scripts, $scripts);


        $this->template = 'marketing/mailserver_list.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    public function grid() {
        $this->load->auto('setting/setting');
        $results = $this->modelSetting->getSetting('mail_server');
        $this->data['campaigns'] = array();

        if ($results) {
            foreach ($results as $id => $result) {
                $action = array();

                $action['edit'] = array(
                    'action' => 'edit',
                    'text' => $this->language->get('text_edit'),
                    'href' => Url::createAdminUrl('marketing/mailserver/update') . '&mail_server_id=' . $id,
                    'img' => 'edit.png'
                );

                $action['delete'] = array(
                    'action' => 'delete',
                    'text' => $this->language->get('text_delete'),
                    'href' => '',
                    'img' => 'delete.png'
                );
                
                $result['action'] = $action;

                $this->data['servers'][$id] = $result;
            }
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_name'] = Url::createAdminUrl('marketing/mailserver/grid') . '&sort=name' . $url;
        $this->data['sort_subject'] = Url::createAdminUrl('marketing/mailserver/grid') . '&sort=subject' . $url;
        $this->data['sort_active'] = Url::createAdminUrl('marketing/mailserver/grid') . '&sort=active' . $url;
        $this->data['sort_archive'] = Url::createAdminUrl('marketing/mailserver/grid') . '&sort=archive' . $url;
        $this->data['sort_date_added'] = Url::createAdminUrl('marketing/mailserver/grid') . '&sort=date_added' . $url;

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }
        if (isset($this->request->get['filter_subject'])) {
            $url .= '&filter_subject=' . $this->request->get['filter_subject'];
        }
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $campaign_total;
        $pagination->page = $page;
        $pagination->ajax = true;
        $pagination->ajaxTarget = 'gridWrapper';
        $pagination->limit = $limit;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = Url::createAdminUrl('marketing/mailserver/grid') . $url . '&page={page}';

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_name'] = $filter_name;
        $this->data['filter_subject'] = $filter_subject;
        $this->data['filter_status'] = $filter_status;
        $this->data['filter_date_added'] = $filter_date_added;

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'marketing/mailserver_grid.tpl';
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    public function getForm() {
        $this->data['Url'] = new Url;
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['entry_template'] = $this->language->get('entry_template');
        $this->data['entry_text_content'] = $this->language->get('entry_text_content');
        $this->data['entry_html_content'] = $this->language->get('entry_html_content');
        $this->data['entry_category'] = $this->language->get('entry_category');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_save_and_new'] = $this->language->get('button_save_and_new');
        $this->data['button_save_and_exit'] = $this->language->get('button_save_and_exit');
        $this->data['button_save_and_keep'] = $this->language->get('button_save_and_keep');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->document->breadcrumbs = array();
        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('common/home'),
            'text' => $this->language->get('text_home'),
            'separator' => false
        );
        $this->document->breadcrumbs[] = array(
            'href' => Url::createAdminUrl('marketing/mailserver'),
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        if (isset($this->request->get['campaign_id'])) {
            $this->data['action'] = Url::createAdminUrl('marketing/mailserver/update') . "&amp;campaign_id=" . $this->request->get['campaign_id'];
        } else {
            $this->data['action'] = Url::createAdminUrl('marketing/mailserver/insert');
        }

        $this->data['cancel'] = Url::createAdminUrl('marketing/mailserver');

        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';
        $this->data['error_name'] = isset($this->error['name']) ? $this->error['name'] : '';
        $this->data['error_description'] = isset($this->error['description']) ? $this->error['description'] : '';
        $this->data['error_lists'] = isset($this->error['lists']) ? $this->error['lists'] : '';
        $this->data['error_subject'] = isset($this->error['subject']) ? $this->error['subject'] : '';
        $this->data['error_from_name'] = isset($this->error['from_name']) ? $this->error['from_name'] : '';
        $this->data['error_from_email'] = isset($this->error['from_email']) ? $this->error['from_email'] : '';
        $this->data['error_replyto_email'] = isset($this->error['replyto_email']) ? $this->error['replyto_email'] : '';
        $this->data['error_bounce_email'] = isset($this->error['bounce_email']) ? $this->error['bounce_email'] : '';

        if (isset($this->request->get['campaign_id'])) {
            $campaign_info = $this->modelCampaign->getById($this->request->get['campaign_id']);
        } else {
            $campaign_info = null;
        }
        $this->data['lists'] = $this->modelList->getAll();
        $this->data['newsletters'] = $this->modelNewsletter->getAll();

        $this->setvar('name', $campaign_info, '');
        $this->setvar('subject', $campaign_info, '');
        $this->setvar('from_name', $campaign_info, $this->config->get('config_name'));
        $this->setvar('from_email', $campaign_info, $this->config->get('config_email'));
        $this->setvar('replyto_email', $campaign_info, $this->config->get('config_replyto_email'));
        $this->setvar('bounceto_email', $campaign_info, $this->config->get('config_bounce_email'));

        $dt = new DateTime();
        $dt->setTimezone(new DateTimeZone("America/Caracas"));

        $this->data['start_year'] = $dt->format('Y');
        $this->data['start_month'] = $dt->format('m');
        $this->data['start_day'] = $dt->format('d');
        $this->data['start_hour'] = $dt->format('h');
        $this->data['start_minute'] = $dt->format('i');
        $this->data['start_meridium'] = $dt->format('A');

        $this->data['end_year'] = $dt->format('Y') + 1;
        $this->data['end_month'] = $dt->format('m');
        $this->data['end_day'] = $dt->format('d');
        $this->data['end_hour'] = $dt->format('h');
        $this->data['end_minute'] = $dt->format('i');
        $this->data['end_meridium'] = $dt->format('A');

        $this->data['minutes'] = array('00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');

        $scripts[] = array('id' => 'form', 'method' => 'ready', 'script' =>
            "$('#q').on('keyup',function(e){
                var that = this;
                var valor = $(that).val().toLowerCase();
                if (valor.length <= 0) {
                    $('#listsWrapper li').show();
                } else {
                    $('#listsWrapper li b').each(function(){
                        var texto = $(this).text().toLowerCase();
                        if (texto.indexOf( valor ) != -1) {
                            $(this).closest('li').show();
                        } else {
                            $(this).closest('li').hide();
                        }
                    });
                }
            });");

        $this->scripts = array_merge($this->scripts, $scripts);

        $this->template = 'marketing/mailserver_form.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    private function validateForm() {
        if (empty($this->request->post['name'])) {
            return false;
        }

        if (empty($this->request->post['subject'])) {
            return false;
        }

        if (!$this->user->hasPermission('modify', 'marketing/mailserver')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function products() {
        $category_id = $this->request->get['category_id'];
        $this->load->auto('store/product');
        $strProducts = '';
        $products = $this->modelProduct->getAllByCategoryId($category_id);
        if ($products) {
            foreach ($products as $product) {
                $strProducts .= "<div id='pid" . $product['product_id'] . "' style='margin:5px;padding:3px;background:#FFF;float:left;border:solid 3px #666;width:150px;height:200px;display:block;text-align:center'>\n";
                $strProducts .= "<p>" . $product['name'] . "</p>";
                if (empty($product['pimage'])) {
                    $strProducts .= "<img src='" . HTTP_IMAGE . "no_image.jpg' width='100' alt='" . $product['name'] . "'>\n";
                } else {
                    $strProducts .= "<img src='" . HTTP_IMAGE . $product['pimage'] . "' width='110' alt='" . $product['name'] . "'>\n";
                }
                $strProducts .= "<input type='hidden' name='" . $product['product_id'] . "' value='" . $product['product_id'] . "'>\n";
                $strProducts .= "<hr><div class='button'><span><b>Arrastrar</b></span></div>";
                $strProducts .= "</div>";
                $strProducts .=
                        "<script>
                $(function() { 
                    $('#pid" . $product['product_id'] . "').draggable({
                        scroll: true,
                        revert: true,
                        start: function() { 
                            $('#pid" . $product['product_id'] . "').after('<input type=\"hidden\" name=\"pid\" id=\"pid\" value=\"" . $product['product_id'] . "\">');
                        },
        				drag: function() {},
        				stop: function() {}
                    });
                });
                </script>";
            }
            echo $strProducts;
        } else {
            echo 'No hay productos en esta categor&iacute;a. <a href="' . HTTP_HOME . 'index.php?r=store/product&token=' . $this->request->get['token'] . '">Le gustar&iacute;a agregar algunos</a>';
        }
    }

    public function send() {
        $htmlbody = html_entity_decode($this->cache->get("campaign.html.temp"));
        $htmlbody = str_replace('%7B', '{', $htmlbody);
        $htmlbody = str_replace('%7D', '}', $htmlbody);
        $data = unserialize($this->cache->get("campaign.data.temp"));

        $to = $data['to'];
        $campaign = $data['post'];
        $links = $data['links'];

        $campaign['contacts'] = $to;

        $campaign_id = $this->modelCampaign->add($campaign);

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
        $task->time_exec = date('Y-m-d H:i:s', strtotime($campaign['date_start']));
        $task->params = $params;
        $task->time_interval = $campaign['repeat'];
        $task->time_last_exec = $row['time_last_exec'];
        $task->run_once = !(bool) $campaign['repeat'];
        $task->status = 1;
        $task->date_start_exec = date('Y-m-d H:i:s', strtotime($campaign['date_start']));
        $task->date_end_exec = date('Y-m-d H:i:s', strtotime($campaign['date_end']));

        foreach ($to as $sort_order => $contact) {
            foreach ($links as $link) {
                if (empty($link['url']) || empty($link['redirect']))
                    continue;
                $link['url'] = str_replace('%7B', '{', $link['url']);
                $link['url'] = str_replace('%7D', '}', $link['url']);
                $link['url'] = str_replace('{%contact_id%}', $contact['contact_id'], $link['url']);
                $link['url'] = str_replace('{%campaign_id%}', $campaign_id, $link['url']);
                $this->modelCampaign->addLink($link, $campaign_id);
            }
            $params = array(
                'contact_id' => $contact['contact_id'],
                'name' => $contact['name'],
                'email' => $contact['email'],
                'campaign_id' => $campaign_id
            );
            $queue = array(
                "params" => $params,
                "status" => 1,
                "time_exec" => date('Y-m-d H:i:s', strtotime($campaign['date_start']))
            );

            $htmlbody = str_replace('{%contact_id%}', $contact['contact_id'], $htmlbody);
            $htmlbody = str_replace('{%campaign_id%}', $campaign_id, $htmlbody);
            $this->cache->set("campaign.html.$campaign_id." . $contact['contact_id'], $htmlbody);

            $task->addQueue($queue);
        }
        $task->createSendTask();
        $this->cache->set("campaign.html.$campaign_id", $htmlbody);

        $this->session->set('success', $this->language->get('text_success'));

        $this->redirect(Url::createAdminUrl("marketing/mailserver"));
    }

}
