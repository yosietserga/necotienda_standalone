<?php

class ControllerEmailNewsletter extends Controller {

    private $error = array();

    public function index() {
        $this->load->language('email/newsletter');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('email/newsletter');

        $this->getList();
    }

    public function create() {
        $this->load->language('email/newsletter');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('email/newsletter');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateCreateForm()) {
            $newsletter_id = $this->model_email_newsletter->create($this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }

            if (isset($this->request->get['filter_subject'])) {
                $url .= '&filter_subject=' . $this->request->get['filter_subject'];
            }

            if (isset($this->request->get['filter_active'])) {
                $url .= '&filter_active=' . $this->request->get['filter_active'];
            }

            if (isset($this->request->get['filter_archive'])) {
                $url .= '&filter_archive=' . $this->request->get['filter_archive'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            $this->redirect(HTTPS_SERVER . 'index.php?route=email/newsletter/update&newsletter_id=' . $newsletter_id . '&token=' . $this->session->data['token'] . $url);
        }

        $this->getForm();
    }

    public function copy() {
        $this->load->language('email/newsletter');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('email/newsletter');

        $this->model_email_newsletter->copy($this->request->get['newsletter_id']);
        $this->session->data['success'] = $this->language->get('text_success');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_subject'])) {
            $url .= '&filter_subject=' . $this->request->get['filter_subject'];
        }

        if (isset($this->request->get['filter_active'])) {
            $url .= '&filter_active=' . $this->request->get['filter_active'];
        }

        if (isset($this->request->get['filter_archive'])) {
            $url .= '&filter_archive=' . $this->request->get['filter_archive'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $this->redirect(HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . $url);

        $this->getList();
    }

    public function delete() {
        $this->load->language('email/newsletter');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('email/newsletter');

        $this->model_email_newsletter->delete($this->request->get['newsletter_id']);
        $this->session->data['success'] = $this->language->get('text_success');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_subject'])) {
            $url .= '&filter_subject=' . $this->request->get['filter_subject'];
        }

        if (isset($this->request->get['filter_active'])) {
            $url .= '&filter_active=' . $this->request->get['filter_active'];
        }

        if (isset($this->request->get['filter_archive'])) {
            $url .= '&filter_archive=' . $this->request->get['filter_archive'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $this->redirect(HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . $url);

        $this->getList();
    }

    public function activate() {
        $this->load->language('email/newsletter');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('email/newsletter');
        $isActive = $this->model_email_newsletter->getActive($this->request->get['newsletter_id']);
        if ($isActive) {
            $this->model_email_newsletter->setActive($this->request->get['newsletter_id'], 0);
        } else {
            $this->model_email_newsletter->setActive($this->request->get['newsletter_id'], 1);
        }
        $this->session->data['success'] = $this->language->get('text_success');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_subject'])) {
            $url .= '&filter_subject=' . $this->request->get['filter_subject'];
        }

        if (isset($this->request->get['filter_active'])) {
            $url .= '&filter_active=' . $this->request->get['filter_active'];
        }

        if (isset($this->request->get['filter_archive'])) {
            $url .= '&filter_archive=' . $this->request->get['filter_archive'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $this->redirect(HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . $url);

        $this->getList();
    }

    public function update() {
        $this->load->language('email/newsletter');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('email/newsletter');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_email_newsletter->update($this->request->get['newsletter_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }

            if (isset($this->request->get['filter_subject'])) {
                $url .= '&filter_subject=' . $this->request->get['filter_subject'];
            }

            if (isset($this->request->get['filter_active'])) {
                $url .= '&filter_active=' . $this->request->get['filter_active'];
            }

            if (isset($this->request->get['filter_archive'])) {
                $url .= '&filter_archive=' . $this->request->get['filter_archive'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            //$this->redirect(HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . $url);
        }

        $this->getForm();
    }

    public function updateAndExit() {
        $this->load->language('email/newsletter');

        $this->document->title = $this->language->get('heading_title');

        $this->load->model('email/newsletter');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_email_newsletter->update($this->request->get['newsletter_id'], $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }

            if (isset($this->request->get['filter_subject'])) {
                $url .= '&filter_subject=' . $this->request->get['filter_subject'];
            }

            if (isset($this->request->get['filter_active'])) {
                $url .= '&filter_active=' . $this->request->get['filter_active'];
            }

            if (isset($this->request->get['filter_archive'])) {
                $url .= '&filter_archive=' . $this->request->get['filter_archive'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            $this->redirect(HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . $url);
        }

        $this->getForm();
    }

    private function getList() {
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = NULL;
        }

        if (isset($this->request->get['filter_subject'])) {
            $filter_subject = $this->request->get['filter_subject'];
        } else {
            $filter_subject = NULL;
        }

        if (isset($this->request->get['filter_active'])) {
            $filter_active = $this->request->get['filter_active'];
        } else {
            $filter_active = NULL;
        }

        if (isset($this->request->get['filter_archive'])) {
            $filter_archive = $this->request->get['filter_archive'];
        } else {
            $filter_archive = NULL;
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = NULL;
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_subject'])) {
            $url .= '&filter_subject=' . $this->request->get['filter_subject'];
        }

        if (isset($this->request->get['filter_active'])) {
            $url .= '&filter_active=' . $this->request->get['filter_active'];
        }

        if (isset($this->request->get['filter_archive'])) {
            $url .= '&filter_archive=' . $this->request->get['filter_archive'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href' => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href' => HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . $url,
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        $this->data['create'] = HTTPS_SERVER . 'index.php?route=email/newsletter/create&token=' . $this->session->data['token'] . $url;

        $this->data['newsletters'] = array();

        $data = array(
            'filter_name' => $filter_name,
            'filter_subject' => $filter_subject,
            'filter_active' => $filter_active,
            'filter_archive' => $filter_archive,
            'filter_date_added' => $filter_date_added,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $newsletter_total = $this->model_email_newsletter->getTotalNewsletters($data);

        $results = $this->model_email_newsletter->getNewsletters($data);

        foreach ($results as $result) {
            $action = array();

            if ($this->model_email_newsletter->getActive($result['newsletter_id'])) {
                $action[] = array(
                    'text' => $this->language->get('text_desactivate'),
                    'href' => HTTPS_SERVER . 'index.php?route=email/newsletter/activate&token=' . $this->session->data['token'] . '&newsletter_id=' . $result['newsletter_id'] . $url
                );
            } else {
                $action[] = array(
                    'text' => $this->language->get('text_activate'),
                    'href' => HTTPS_SERVER . 'index.php?route=email/newsletter/activate&token=' . $this->session->data['token'] . '&newsletter_id=' . $result['newsletter_id'] . $url
                );
            }
            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'href' => HTTPS_SERVER . 'index.php?route=email/newsletter/update&token=' . $this->session->data['token'] . '&newsletter_id=' . $result['newsletter_id'] . $url
            );
            $action[] = array(
                'text' => $this->language->get('text_copy'),
                'href' => HTTPS_SERVER . 'index.php?route=email/newsletter/copy&token=' . $this->session->data['token'] . '&newsletter_id=' . $result['newsletter_id'] . $url
            );
            $action[] = array(
                'text' => $this->language->get('text_delete'),
                'href' => HTTPS_SERVER . 'index.php?route=email/newsletter/delete&token=' . $this->session->data['token'] . '&newsletter_id=' . $result['newsletter_id'] . $url
            );

            //$totalByList = $this->model_email_member->getTotalMembersByList($result['newsletter_id']);
            $this->data['newsletters'][] = array(
                'newsletter_id' => $result['newsletter_id'],
                'name' => $result['name'],
                'description' => $result['description'],
                'subject' => $result['subject'],
                'format' => $result['format'],
                'textbody' => $result['textbody'],
                'htmlbody' => $result['htmlbody'],
                'archive' => ($result['archive'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
                'active' => ($result['active'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
                'date_modified' => !is_null($result['date_modified']) ? date($this->language->get('date_format_short'), strtotime($result['date_modified'])) : null,
                'selected' => isset($this->request->post['selected']) && in_array($result['newsletter_id'], $this->request->post['selected']),
                'action' => $action
            );
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_subject'] = $this->language->get('column_subject');
        $this->data['column_active'] = $this->language->get('column_active');
        $this->data['column_archive'] = $this->language->get('column_archive');
        $this->data['column_date_added'] = $this->language->get('column_date_added');
        $this->data['column_action'] = $this->language->get('column_action');

        $this->data['button_approve'] = $this->language->get('button_approve');
        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['button_filter'] = $this->language->get('button_filter');

        $this->data['token'] = $this->session->data['token'];

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

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_subject'])) {
            $url .= '&filter_subject=' . $this->request->get['filter_subject'];
        }

        if (isset($this->request->get['filter_active'])) {
            $url .= '&filter_active=' . $this->request->get['filter_active'];
        }

        if (isset($this->request->get['filter_archive'])) {
            $url .= '&filter_archive=' . $this->request->get['filter_archive'];
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

        $this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . '&sort=name' . $url;
        $this->data['sort_subject'] = HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . '&sort=subject' . $url;
        $this->data['sort_active'] = HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . '&sort=active' . $url;
        $this->data['sort_archive'] = HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . '&sort=archive' . $url;
        $this->data['sort_date_added'] = HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . '&sort=date_added' . $url;

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }

        if (isset($this->request->get['filter_subject'])) {
            $url .= '&filter_subject=' . $this->request->get['filter_subject'];
        }

        if (isset($this->request->get['filter_active'])) {
            $url .= '&filter_active=' . $this->request->get['filter_active'];
        }

        if (isset($this->request->get['filter_archive'])) {
            $url .= '&filter_archive=' . $this->request->get['filter_archive'];
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
        $pagination->total = $newsletter_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'] . $url . '&page={page}';

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_name'] = $filter_name;
        $this->data['filter_subject'] = $filter_subject;
        $this->data['filter_active'] = $filter_active;
        $this->data['filter_archive'] = $filter_archive;
        $this->data['filter_date_added'] = $filter_date_added;


        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'email/newsletter_list.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    public function getForm() {
        $this->load->model('email/newsletter');

        $this->load->language('email/newsletter');

        $this->document->title = $this->language->get('heading_title');

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['entry_template'] = $this->language->get('entry_template');
        $this->data['entry_subject'] = $this->language->get('entry_subject');
        $this->data['entry_text_content'] = $this->language->get('entry_text_content');
        $this->data['entry_html_content'] = $this->language->get('entry_html_content');
        $this->data['entry_format'] = $this->language->get('entry_format');
        $this->data['entry_category'] = $this->language->get('entry_category');
        $this->data['entry_lists'] = $this->language->get('entry_lists');
        $this->data['entry_true'] = $this->language->get('entry_true');
        $this->data['entry_false'] = $this->language->get('entry_false');
        $this->data['entry_category'] = $this->language->get('entry_category');
        $this->data['entry_member'] = $this->language->get('entry_member');
        $this->data['entry_from_name'] = $this->language->get('entry_from_name');
        $this->data['entry_from_email'] = $this->language->get('entry_from_email');
        $this->data['entry_replyto_email'] = $this->language->get('entry_replyto_email');
        $this->data['entry_bounce_email'] = $this->language->get('entry_bounce_email');
        $this->data['entry_multipart'] = $this->language->get('entry_multipart');
        $this->data['entry_trace_open'] = $this->language->get('entry_trace_open');
        $this->data['entry_trace_click'] = $this->language->get('entry_trace_click');

        $this->data['tab_general'] = $this->language->get('tab_general');
        $this->data['tab_send'] = $this->language->get('tab_send');
        $this->data['tab_check'] = $this->language->get('tab_check');
        $this->data['tab_content'] = $this->language->get('tab_content');

        $this->data['button_generate'] = $this->language->get('button_generate');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_save_and_send'] = $this->language->get('button_save_and_send');
        $this->data['button_exit'] = $this->language->get('button_exit');

        $this->data['token'] = $this->session->data['token'];

        $this->document->breadcrumbs = array();

        $this->document->breadcrumbs[] = array(
            'href' => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
            'text' => $this->language->get('text_home'),
            'separator' => false
        );

        $this->document->breadcrumbs[] = array(
            'href' => HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'],
            'text' => $this->language->get('heading_title'),
            'separator' => ' :: '
        );

        if (isset($this->request->get['newsletter_id'])) {
            $this->data['action'] = HTTPS_SERVER . 'index.php?route=email/newsletter/update&token=' . $this->session->data['token'] . "&newsletter_id=" . $this->request->get['newsletter_id'];
        } else {
            $this->data['action'] = HTTPS_SERVER . 'index.php?route=email/newsletter/create&token=' . $this->session->data['token'];
        }

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $this->data['error_name'] = $this->error['name'];
        } else {
            $this->data['error_name'] = '';
        }

        if (isset($this->error['description'])) {
            $this->data['error_description'] = $this->error['description'];
        } else {
            $this->data['error_description'] = '';
        }

        if (isset($this->error['lists'])) {
            $this->data['error_lists'] = $this->error['lists'];
        } else {
            $this->data['error_lists'] = '';
        }

        if (isset($this->error['subject'])) {
            $this->data['error_subject'] = $this->error['subject'];
        } else {
            $this->data['error_subject'] = '';
        }

        if (isset($this->error['from_name'])) {
            $this->data['error_from_name'] = $this->error['from_name'];
        } else {
            $this->data['error_from_name'] = '';
        }

        if (isset($this->error['from_email'])) {
            $this->data['error_from_email'] = $this->error['from_email'];
        } else {
            $this->data['error_from_email'] = '';
        }

        if (isset($this->error['replyto_email'])) {
            $this->data['error_replyto_email'] = $this->error['replyto_email'];
        } else {
            $this->data['error_replyto_email'] = '';
        }

        if (isset($this->error['bounce_email'])) {
            $this->data['error_bounce_email'] = $this->error['bounce_email'];
        } else {
            $this->data['error_bounce_email'] = '';
        }

        $this->data['cancel'] = HTTPS_SERVER . 'index.php?route=email/newsletter&token=' . $this->session->data['token'];

        if (isset($this->request->get['newsletter_id'])) {
            $newsletter_info = $this->model_email_newsletter->getNewsletter($this->request->get['newsletter_id']);
        } else {
            $newsletter_info = array();
        }

        if (isset($this->request->post['name'])) {
            $this->data['name'] = $this->request->post['name'];
        } elseif (isset($newsletter_info['name'])) {
            $this->data['name'] = ucwords($newsletter_info['name']);
        } else {
            $this->data['name'] = '';
        }

        if (isset($this->request->post['from_name'])) {
            $this->data['from_name'] = $this->request->post['from_name'];
        } elseif (isset($newsletter_info['from_name'])) {
            $this->data['from_name'] = $newsletter_info['from_name'];
        } else {
            $this->data['from_name'] = $this->config->get('from_name');
        }

        if (isset($this->request->post['from_email'])) {
            $this->data['from_email'] = $this->request->post['from_email'];
        } elseif (isset($newsletter_info['from_email'])) {
            $this->data['from_email'] = $newsletter_info['from_email'];
        } else {
            $this->data['from_email'] = $this->config->get('from_email');
        }

        if (isset($this->request->post['bounce_email'])) {
            $this->data['bounce_email'] = $this->request->post['bounce_email'];
        } elseif (isset($newsletter_info['bounce_email'])) {
            $this->data['bounce_email'] = $newsletter_info['bounce_email'];
        } else {
            $this->data['bounce_email'] = $this->config->get('config_email');
        }

        if (isset($this->request->post['replyto_email'])) {
            $this->data['replyto_email'] = $this->request->post['replyto_email'];
        } elseif (isset($newsletter_info['replyto_email'])) {
            $this->data['replyto_email'] = $newsletter_info['replyto_email'];
        } else {
            $this->data['replyto_email'] = $this->config->get('config_email');
        }

        if (isset($this->request->post['description'])) {
            $this->data['description'] = $this->request->post['description'];
        } elseif (isset($newsletter_info['description'])) {
            $this->data['description'] = $newsletter_info['description'];
        } else {
            $this->data['description'] = '';
        }

        if (isset($this->request->post['subject'])) {
            $this->data['subject'] = $this->request->post['subject'];
        } elseif (isset($newsletter_info['subject'])) {
            $this->data['subject'] = $newsletter_info['subject'];
        } else {
            $this->data['subject'] = '';
        }

        if (isset($this->request->post['htmlbody'])) {
            $this->data['htmlbody'] = $this->request->post['htmlbody'];
        } elseif (isset($newsletter_info['htmlbody'])) {
            $this->data['htmlbody'] = $newsletter_info['htmlbody'];
        } else {
            $this->data['htmlbody'] = '';
        }

        if (isset($this->request->post['textbody'])) {
            $this->data['textbody'] = $this->request->post['textbody'];
        } elseif (isset($newsletter_info['textbody'])) {
            $this->data['textbody'] = $newsletter_info['textbody'];
        } else {
            $this->data['textbody'] = '';
        }

        if (isset($this->request->post['format'])) {
            $this->data['format'] = $this->request->post['format'];
        } elseif (isset($newsletter_info['format'])) {
            $this->data['format'] = $newsletter_info['format'];
        } else {
            $this->data['format'] = '';
        }

        if (isset($this->request->post['trace_email'])) {
            $this->data['trace_email'] = $this->request->post['trace_email'];
        } elseif (isset($newsletter_info['trace_email'])) {
            $this->data['trace_email'] = $newsletter_info['trace_email'];
        } else {
            $this->data['trace_email'] = '';
        }

        if (isset($this->request->post['trace_click'])) {
            $this->data['trace_click'] = $this->request->post['trace_click'];
        } elseif (isset($newsletter_info['trace_click'])) {
            $this->data['trace_click'] = $newsletter_info['trace_click'];
        } else {
            $this->data['trace_click'] = '';
        }

        if (isset($newsletter_info['format'])) {
            $this->data['format_list'] = $this->newsletter->getFormatList($newsletter_info['format']);
        } else {
            $this->data['format_list'] = $this->newsletter->getFormatList();
        }

        if (isset($this->request->post['date_added'])) {
            $this->data['date_added'] = $this->request->post['date_added'];
        } elseif (isset($list_info['date_added'])) {
            $this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($list_info['date_added']));
        } else {
            $this->data['date_added'] = date($this->language->get('date_format_short'), time());
        }

        $this->data['token'] = $this->session->data['token'];
        $this->data['templates'] = $this->email_template->getPremadeTemplateList(DIR_EMAIL_TEMPLATE . 'html/', true);
        $this->data['my_templates'] = $this->email_template->getCustomTemplateList();

        $this->load->model('catalog/category');

        $this->data['categories'] = $this->model_catalog_category->getCategories(0);

        $this->load->model('email/lists');
        $this->data['lists'] = array();
        $lists = $this->model_email_lists->getAllLists();
        foreach ($lists as $list) {
            $this->data['lists'][] = $this->model_email_lists->getNewsletterLists($list['list_id']);
        }
        if (isset($this->request->get['newsletter_id'])) {
            $this->data['list_id'] = $this->model_email_newsletter->getListByNewsletter($this->request->get['newsletter_id']);
        }

        $this->template = 'email/newsletter_form.tpl';
        
        $this->children[] = 'common/header';
        $this->children[] = 'common/nav';
        $this->children[] = 'common/footer';
        
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'email/newsletter')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->validate->longitudMinMax($this->request->post['name'], 3, 25, $this->language->get('entry_name'))) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if (!$this->validate->longitudMinMax($this->request->post['description'], 10, 140, $this->language->get('entry_description'))) {
            $this->error['description'] = $this->language->get('error_description');
        }

        if (!$this->validate->longitudMinMax($this->request->post['subject'], 3, 35, $this->language->get('entry_subject'))) {
            $this->error['subject'] = $this->language->get('error_subject');
        }

        if (!$this->validate->longitudMin($this->request->post['from_name'], 3, $this->language->get('entry_from_name'))) {
            $this->error['from_name'] = $this->language->get('error_from_name');
        }

        if (!$this->validate->validEmail($this->request->post['from_email'])) {
            $this->error['from_email'] = $this->language->get('error_from_email');
        }

        if (!$this->validate->validEmail($this->request->post['replyto_email'])) {
            $this->error['replyto_email'] = $this->language->get('error_replyto_email');
        }

        if (!$this->validate->validEmail($this->request->post['bounce_email'])) {
            $this->error['bounce_email'] = $this->language->get('error_bounce_email');
        }

        if (!is_array($this->request->post['list_id']) || empty($this->request->post['list_id'])) {
            $this->error['lists'] = $this->language->get('error_lists');
        }

        $this->data['mostrarError'] = $this->validate->mostrarError();

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function validateCreateForm() {
        if (!$this->user->hasPermission('modify', 'email/newsletter')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->validate->longitudMinMax($this->request->post['name'], 3, 25, $this->language->get('entry_name'))) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if (!$this->validate->longitudMinMax($this->request->post['description'], 10, 140, $this->language->get('entry_description'))) {
            $this->error['description'] = $this->language->get('error_description');
        }

        $this->data['mostrarError'] = $this->validate->mostrarError();

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function products() {
        $category_id = $this->request->get['category_id'];
        $this->load->model('catalog/product');
        $strProducts = '';
        $products = $this->model_catalog_product->getProductsByCategoryId($category_id);
        if ($category_id) {
            if ($products) {
                foreach ($products as $product) {
                    $strProducts .= "<div id='pid" . $product['product_id'] . "' style='margin:5px;padding:3px;background:#FFF;float:left;border:solid 3px #666;width:150px;height:200px;display:block;text-align:center' onMouseOut='jQuery(this).css({\"border-color\":\"#666\",\"cursor\":\"normal\"})' onMouseOver='jQuery(this).css({\"border-color\":\"#F9F9F9\",\"cursor\":\"move\"})'>\n";
                    $strProducts .= "<p><a href='" . HTTPS_SERVER . "index.php?route=catalog/product/update&token=" . $this->request->get['token'] . "&product_id=" . $product['product_id'] . "'>" . $product['name'] . "</a></p>";
                    if (empty($product['image'])) {
                        $strProducts .= "<img src='" . HTTPS_IMAGE . "no_image.jpg' width='100' alt='" . $product['name'] . "'>\n";
                    } else {
                        $strProducts .= "<img src='" . HTTPS_IMAGE . $product['image'] . "' width='110' alt='" . $product['name'] . "'>\n";
                    }
                    $strProducts .= "<input type='hidden' name='" . $product['product_id'] . "' value='" . $product['product_id'] . "'>\n";
                    $strProducts .= "<hr><div class='button'><span><b>Arrastrar</b></span></div>";
                    $strProducts .= "</div>";
                    $strProducts .= "<script>jQuery(function() {jQuery('#pid" . $product['product_id'] . "').draggable({
                scroll: true,
                revert: true,
                start: function() { 
                    jQuery('#pid').remove();
                    jQuery('#pid" . $product['product_id'] . "').after('<input type=\'hidden\' name=\'pid\' id=\'pid\' value=\'" . $product['product_id'] . "\'>');	
                },
				drag: function() {
					
				},
				stop: function() {
					
				}
            });});</script>";
                }
                echo $strProducts;
            } else {
                echo 'No hay productos en esta categor&iacute;a. <a href="' . HTTPS_SERVER . 'index.php?route=catalog/product&token=' . $this->request->get['token'] . '">Le gustar&iacute;a agregar algunos</a>';
            }
        } else {
            echo '';
        }
    }

    public function template() {
        $template = basename($this->request->get['template']);
        $template = str_replace('-', '/', $template);
        $template = str_replace('&amp;', '&', $template);
        if (file_exists(DIR_EMAIL_TEMPLATE . 'html/' . $template . '/preview.gif')) {
            $image = HTTPS_EMAIL_TPL_IMAGE . $template . '/preview.gif';
        } else {
            $image = HTTPS_IMAGE . 'no_image.jpg';
        }$image2 = HTTPS_EMAIL_TPL_IMAGE . 'html/' . $template . '/preview.gif';
        $this->response->setOutput('<img src="' . $image . '" style="border: 2px solid #EEEEEE;" />');
    }

    public function getProduct() {
        $product_id = $this->request->get['product_id'];
        $this->load->model('catalog/product');
        $strProducts = '';
        $product = $this->model_catalog_product->getProduct($product_id);
        $tags = $this->model_catalog_product->getProductTags($product_id);
        if (isset($this->request->get['format']) && !empty($this->request->get['format'])) {
            $strProducts .= "Producto: " . ucwords($product['name']) . "\n";
            $strProducts .= "Precio: Bs. " . str_replace('.', ',', floatval($product['price'])) . "\n";
            $strProducts .= "URL: " . HTTP_CATALOG . "index.php?route=product/product&product_id=" . $product['product_id'] . "\n";
            if ($tags) {
                foreach ($tags as $key => $tag) {
                    $ntag = $key + 1;
                    $strProducts .= "Tag " . $ntag . ": " . HTTP_CATALOG . "index.php?route=product/search&keyword=" . $tag['tag'] . "\n";
                }
            }
            $strProducts .= "\n";
            echo $strProducts;
        } else {
            $strProducts .= "<div style='margin:5px;padding:3px;background:#FFF;float:left;border:dotted 1px #666;width:150px;display:block;text-align:center'>";
            $strProducts .= "<br><p><a href='" . HTTP_CATALOG . "index.php?route=product/product&product_id=" . $product['product_id'] . "'>" . $product['name'] . "</a></p>";
            if (empty($product['image'])) {
                $strProducts .= "<a href='" . HTTP_CATALOG . "index.php?route=product/product&product_id=" . $product['product_id'] . "'><img src='" . HTTPS_IMAGE . "no_image.jpg' width='100' alt='" . $product['name'] . "'></a>";
            } else {
                $strProducts .= "<a href='" . HTTP_CATALOG . "index.php?route=product/product&product_id=" . $product['product_id'] . "'><img src='" . HTTPS_IMAGE . $product['image'] . "' width='110' alt='" . $product['name'] . "'></a>";
            }
            $strProducts .= "<input type='hidden' name='" . $product['product_id'] . "' value='" . $product['product_id'] . "'>";
            $strProducts .= "<br><b>Bs. " . str_replace('.', ',', floatval($product['price'])) . "</b><br>";
            if ($tags) {
                foreach ($tags as $key => $tag) {
                    $strProducts .= "&nbsp;&nbsp;<a href='" . HTTP_CATALOG . "index.php?route=product/search&keyword=" . $tag['tag'] . "' style='font:normal 9px verdana'>" . $tag['tag'] . "</a>&nbsp;&nbsp;";
                }
            }
            $strProducts .= "<br></div>";
            echo $strProducts;
        }
    }

    public function readPremadeTemplate() {
        $templaname = basename($this->request->get['template']);
        $templaname = str_replace('-', '/', $templaname);
        $templaname = str_replace('&amp;', '&', $templaname);
        $templaname = str_replace('%20', ' ', $templaname);
        $templaname = str_replace('%2F', '/', $templaname);
        $tpl_content = $this->email_template->readPremadeTemplate($templaname);
        echo "$tpl_content";
    }

    public function membersByList() {
        if (!empty($this->request->post['list_id']) && is_array($this->request->post['list_id'])) {
            $lists = $this->request->post['list_id'];
            $this->load->model('email/member');
            $this->load->model('email/newsletter');
            $members = array();
            $member_id = $this->model_email_newsletter->getMemberByNewsletter($this->request->post['newsletter_id']);
            foreach ($lists as $list) {
                $members[] = $this->model_email_member->getMembersByList($list);
            }
            foreach ($members as $member) {
                foreach ($member as $value) {
                    $mbr[] = $value;
                }
            }
            $this->data['members'] = $mbr;
            $strOutput = '';
            $strOutput .= "<div class='scrollbox'>";
            $class = 'odd';
            foreach ($mbr as $member) {
                if (isset($customer_id)) {
                    if (in_array($member['customer_id'], $customer_id)) {
                        continue;
                    }
                }
                $customer_id[] = $member['customer_id'];
                $class = ($class == 'even' ? 'odd' : 'even');
                $strOutput .= "<div class='" . $class . "'>";
                if (in_array($member['customer_id'], $member_id)) {
                    $strOutput .= "<input title='Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores' type='checkbox' name='member_id[]' value='" . $member['customer_id'] . "' checked='checked'>";
                    $strOutput .= "<input type='hidden' name='email[]' value='" . $member['email'] . "'>";
                    $strOutput .= $member['firstname'] . ' ' . $member['lastname'] . '&nbsp;&nbsp;[ ' . $member['email'] . ' ]';
                } else {
                    $strOutput .= "<input title='Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores' type='checkbox' name='member_id[]' value='" . $member['customer_id'] . "'>";
                    $strOutput .= "<input type='hidden' name='email[]' value='" . $member['email'] . "'>";
                    $strOutput .= $member['firstname'] . ' ' . $member['lastname'] . '&nbsp;&nbsp;[ ' . $member['email'] . ' ]';
                }
                $strOutput .= "</div>";
            }
            $strOutput .= "</div>";
            echo $strOutput;
        } else {
            echo 1;
        }
    }

    public function saveMembers() {
        $a = explode('&amp;', $this->request->post['members']);
        $this->load->model('email/newsletter');
        foreach ($a as $b) {
            $c = strpos($b, '=');
            $name[] = substr($b, 0, $c);
            $value[] = substr($b, $c);
        }
        foreach ($name as $k => $v) {
            if ($e = strpos($v, 'ember_id')) {
                $members[] = substr($value[$k], 1);
            }
            if ($e = strpos($v, 'ist_id')) {
                $lists[] = substr($value[$k], 1);
            }
        }
        if (empty($members) || !is_array($members)) {
            echo "1";
        } else {
            $this->model_email_newsletter->updateListsNewsletter($this->request->post['newsletter_id'], $lists);
            $this->model_email_newsletter->updateMembersNewsletter($this->request->post['newsletter_id'], $members);
        }
    }

    public function checkEmail() {
        $errormsg = array();
        $error = false;
        $html_output = "<div id='checkEmailResult' style='font:normal 11px verdana'><h2>Detalles del email</h2><ul>\n";
        $email_size = 0;
        $this->load->model('email/newsletter');
        if ($this->request->post) {
            $htmlbody = ($this->request->post['htmlbody']) ? $this->request->post['htmlbody'] : '';
            $textbody = ($this->request->post['textbody']) ? $this->request->post['textbody'] : '';
            $format = ($this->request->post['format']) ? $this->request->post['format'] : '';
            $newsletter_id = ($this->request->post['newsletter_id']) ? $this->request->post['newsletter_id'] : '';
            $newsletter_info = isset($newsletter_id) ? $this->model_email_newsletter->getNewsletter($newsletter_id) : '';
        } elseif ($this->request->get) {
            $htmlbody = ($this->request->get['htmlbody']) ? $this->request->get['htmlbody'] : '';
            $textbody = ($this->request->get['textbody']) ? $this->request->get['textbody'] : '';
            $format = ($this->request->get['format']) ? $this->request->get['format'] : '';
            $newsletter_id = ($this->request->get['newsletter_id']) ? $this->request->get['newsletter_id'] : '';
            $newsletter_info = isset($newsletter_id) ? $this->model_email_newsletter->getNewsletter($newsletter_id) : '';
        }
        if (empty($format)) {
            $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>Formato de campa&ntilde;a inv&aacute;lido</li>\n";
            $error = true;
        } else {
            if ($format == 'a') {
                if (empty($htmlbody)) {
                    $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>Debe ingresar el contenido en formato HTML</li>\n";
                    $error = true;
                }
                if (empty($textbody)) {
                    $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>Debe ingresar el contenido en formato Texto Plano</li>\n";
                    $error = true;
                }
            } elseif ($format == 'h' && empty($htmlbody)) {
                $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>Debe ingresar el contenido en formato HTML</li>\n";
                $error = true;
            } elseif ($format == 't' && empty($textbody)) {
                $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>Debe ingresar el contenido en formato Texto Plano</li>\n";
                $error = true;
            }
        }
        if ($this->utf8->utf8_isvalid($htmlbody)) {
            $html_size = isset($htmlbody) ? strlen($htmlbody) : 0;
        } else {
            $html_size = isset($htmlbody) ? $this->utf8->utf8_strlen($htmlbody) : 0;
        }
        $text_size = isset($textbody) ? strlen($textbody) : 0;
        if (isset($format) && $format == 'h')
            $email_size += $html_size;
        if (isset($format) && $format == 't')
            $email_size += $text_size;
        if (isset($format) && $format == 'a')
            $email_size = $html_size + $text_size;
        $email_size += 3000;
        $max_size = $this->config->get('config_smtp_maxsize');
        if ($this->config->get('config_smtp_maxsize') > 0) {
            if ($max_size < $email_size) {
                $email_size_diff = $email_size - $max_size;
                $max_size = $this->general->EasySize($max_size, 2);
                $email_size = $this->general->EasySize($email_size, 2);
                $email_size_diff = $this->general->EasySize($email_size_diff, 2);
                $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>El tama&ntilde;o del email es mayor a lo permitido, <b style='font: bold 26px arial'>$email_size</b></li>\n";
                $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>El email se excede por <b>$email_size_diff</b></li>\n";
                $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>El tama&ntilde;o m&aacute;ximo permitido es de <b>$max_size</b></li>\n";
                $error = true;
            } else {
                $email_size = $this->general->EasySize($email_size, '2');
                $max_size = $this->general->EasySize($max_size, 2);
                $html_output .= "<li>El tama&ntilde;o aproximado del email es de <b>$email_size</b></li>\n";
                $html_output .= "<li>El tama&ntilde;o m&aacute;ximo permitido es de <b>$max_size</b></li>\n";
            }
        }
        if (isset($newsletter_id)) {
            $members = $this->model_email_newsletter->getMemberByNewsletter($newsletter_id);
            $total_members = sizeof($members);
            if ($total_members > 50) {
                $total_members_diff = $total_members - 50;
                $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>La lista de destinatarios es de <b style='font: bold 26px arial;color:red'>$total_members</b> miembros y ha excedido su l&iacute;mite por <b style='font: bold 26px arial;color:red'>$total_members_diff</b> destinatario(s)</li>\n";
                $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'><span><b>NOTA</b></span>: Si desea enviar una campa&ntilde;a a m&aacute;s de 50 destinatarios, cree varias con el mismo nombre (puede utilizar la opci&oacute;n \"Copiar\" para duplicar una campa&ntilde;a) y agregue un correlativo como sufijo, luego progr&aacute;melas para que se env&iacute;en autom&aacute;ticamente. Tambi&eacute;n puede crear listas de miembros donde se agrupen por sexo, por direcci&oacute;n, por edad, por profesi&oacute;n u otros criterios para una mayor facilidad de selecci&oacute;n</li>\n";
                $error = true;
            } elseif ($total_members <= 0 || !is_numeric($total_members)) {
                $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>El tipo de dato de la lista de destinatarios es inv&aacute;lido</li>\n";
                $error = true;
            } else {
                $html_output .= "<li>El email ser&aacute; enviado a <b>$total_members destinatario(s)</b></li>\n";
            }
        }
        $smtpconnect = @fsockopen($this->config->get('config_smtp_host'), $this->config->get('config_smtp_port'), $errno, $errstr, $this->config->get('config_smtp_timeout'));
        if (!$smtpconnect) {
            $errormsg[] = "<li style='font-weight:bold;list-style:square;color:red'>Error $errno: No hay conexi&oacute;n con el servidor de email</li>";
            $errormsg[] = "<li style='font-weight:bold;list-style:none;color:red'>Error $errno: $errstr</li>";
            $errormsg[] = "<li style='font-weight:bold;list-style:none'>NOTA: Por favor revise los par&aacute;metros de configuraci&oacute;n de los servidores de correo para confirmar que est&aacute;n bien configurados</li>";
            $errormsg[] = "<a href='index.php?route=setting/setting&token=" . $_GET['token'] . "' style='font-weight:bold;list-style:none;color:blue'>Confiuraci&oacute;n</a>";
            $error = true;
        } else {
            $html_output .= "<li>Conexi&oacute;n &eacute;xitosa con el servidor de email</li>";
        }
        if ($error) {
            $html_output .= "<h2 style='hegiht:24px;display:block;background:#F33'>Hay Errores en la campa&ntilde;a</h2>";
            foreach ($errormsg as $msg) {
                $html_output .= $msg;
            }
        }
        $html_output .= "</ul>";
        if ($format == 'a' || $format == 'h') {
            $arrCheckSpam = $this->email_f->processEmailForSpam($textbody, $htmlbody);
        } elseif ($format == 't') {
            $arrCheckSpam = $this->email_f->processEmailForSpam($textbody);
        }
        $html_output .= "<h2>Posibles frases de Spam en el email</h2>";
        $html_output .= "<p>A conontinuaci&oacute;n se muestran las posibles palabras y frases que pueden ser catalogadas como spam por los diferentes servidores de correo y colocar este email en la bandeja de correos no deseados.<br>
                        Los criterios de categorizaci&oacute;n de Spam de un email difieren por cada servidor, los resultados mostrados debajo son apr&oacute;ximados y pretenden dar una gu&iacute;a para la edici&oacute;n del contenido del mensaje</p>";
        if (is_array($arrCheckSpam) && !empty($arrCheckSpam)) {
            foreach ($arrCheckSpam as $key => $spamrules) {
                if ($format == 'a' || $format == 'h') {
                    if ($key == 'html') {
                        $html_output .= "<h3 style='font:bold 14px verdana;hegiht:24px;display:block;background:#E0ECFF'>HTML</h3>";
                        $html_output .= "<b>Promedio: " . $spamrules['rating'] . "</b><br>";
                        $html_output .= "<b>Puntaje: " . $spamrules['score'] . "</b><br>";
                        if ($spamrules['score'] == 0)
                            $html_output .= "<h3>No hay frases consideradas como Spam</h3>";
                        $html_output .= "<table style='font:normal 11px verdana'>";
                        foreach ($spamrules['broken_rules'] as $spamrule) {
                            $html_output .= "<tr><td style='width:250px'>" . $spamrule[0] . "</td><td style='font:bold 11px verdana'>" . $spamrule[1] . "</td></tr>";
                        }
                        $html_output .= "</table>";
                    }
                }
                if ($format == 'a' || $format == 't') {
                    if ($key == 'text') {
                        $html_output .= "<h3 style='font:bold 14px verdana;hegiht:24px;display:block;background:#E0ECFF'>Texto</h3>";
                        $html_output .= "<b>Promedio: " . $spamrules['rating'] . "</b><br>";
                        $html_output .= "<b>Puntaje: " . $spamrules['score'] . "</b><br>";
                        if ($spamrules['score'] == 0)
                            $html_output .= "<h3>No hay frases consideradas como Spam</h3>";
                        $html_output .= "<table style='font:normal 11px verdana'>";
                        foreach ($spamrules['broken_rules'] as $spamrule) {
                            $html_output .= "<tr><td style='width:250px'>" . $spamrule[0] . "</td><td style='font:bold 11px verdana'>" . $spamrule[1] . "</td></tr>";
                        }
                        $html_output .= "</table>";
                    }
                }
            }
        }
        if (!$error) {
            $html_output .= "<div id='buttons' class='buttons'><a class='button' id='btn_only_send'><span>Solo Enviar</span></a><a class='button' id='btn_save_and_send'><span>Guardar y Enviar</span></a>"; //<a class='button' id='btn_schedule_send'><span>Programar Env&iacute;o</span></a>
            $html_output .= "<script>
                    jQuery(\"#btn_only_send\").click(function(){
                            var htmlbody = CKEDITOR.instances.htmlbody.getData();
                            var textbody = jQuery('#textbody').val();
                            var format = jQuery('#format').val();
                            var subject = jQuery('#subject').val();
                            var from_email = jQuery('#from_email').val();
                            var from_name = jQuery('#from_name').val();
                            var replyto_email = jQuery('#replyto_email').val();
                            var bounce_email = jQuery('#bounce_email').val();

                        	jQuery.ajax({
                        		type: 'POST',
                        		url: 'index.php?route=email/newsletter/send&token=" . $_GET["token"] . "',
                        		dataType: 'html',
                        		data: 'format='+format+'&textbody='+encodeURIComponent(textbody)+'&htmlbody='+encodeURIComponent(htmlbody)+'&subject='+encodeURIComponent(subject)+'&from_email='+encodeURIComponent(from_email)+'&from_name='+encodeURIComponent(from_name)+'&replyto_email='+encodeURIComponent(replyto_email)+'&bounce_email='+encodeURIComponent(bounce_email)+'&newsletter_id=" . $newsletter_id . "',
                        		beforeSend: function() {
                        			jQuery(\"#buttons\").fadeOut();
                                    jQuery(\"#send_error\").remove();
                        			jQuery(\"#btn_check_email\").after(\"<p style='background:#BBFFC0;font:normal 11px verdana' id='enviando'>Enviando...</p>\");
                        		},
                        		success: function(data){    
                        			jQuery(\"#enviando\").remove();  
                        			jQuery(\"#buttons\").fadeIn();
                        			jQuery(\"#btn_check_email\").after(\"<div style='background:#F66;font:normal 11px verdana' id='send_error'>\"+data+\"</div>\");
                                 }
                            });
                        });
                        
                        jQuery(\"#btn_save_and_send\").click(function(){                    
                            var htmlbody = CKEDITOR.instances.htmlbody.getData();
                            var textbody = jQuery('#textbody').val();
                            var name = jQuery('input[name=\"name\"]').val();
                            var description = jQuery('input[name=\"description\"]').val();
                            var format = jQuery('#format').val();
                            var subject = jQuery('#subject').val();
                            var from_email = jQuery('#from_email').val();
                            var from_name = jQuery('#from_name').val();
                            var replyto_email = jQuery('#replyto_email').val();
                            var bounce_email = jQuery('#bounce_email').val();
                            var errormsg = '';

                        	jQuery.ajax({
                        		type: 'POST',
                        		url: 'index.php?route=email/newsletter/saveAndSend&token=" . $_GET["token"] . "',
                        		dataType: 'html',
                        		data: 'format='+format+'&textbody='+encodeURIComponent(textbody)+'&htmlbody='+encodeURIComponent(htmlbody)+'&name='+encodeURIComponent(name)+'&description='+encodeURIComponent(description)+'&subject='+encodeURIComponent(subject)+'&from_email='+encodeURIComponent(from_email)+'&from_name='+encodeURIComponent(from_name)+'&replyto_email='+encodeURIComponent(replyto_email)+'&bounce_email='+encodeURIComponent(bounce_email)+'&newsletter_id=" . $newsletter_id . "',
                        		beforeSend: function() {
                        		  if (name.length < 1) { errormsg += 'El nombre de la campa&ntilde;a no puede estar vac&iacute;o\\n';}
                                  if (description.length < 1) {errormsg += 'Debe ingresar una descripci&oacute;n para la campa�a\\n';}
                                  if (subject.length < 1) { errormsg +='El asunto del mensaje no puede estar vac&iacute;o\\n';}
                                  if (format == 'a' && textbody.length < 1 && htmlbody.length < 1) {errormsg +='Debe ingresar el contenido para los dos formatos\\n';} 
                                  else {
                                      if (format == 'b' && htmlbody.length < 1) {errormsg +='El cuerpo del mensaje no puede estar vac&iacute;o\\n';}
                                      else {                                         
                                          if (format == 't' && textbody.length < 1) {
                                		      errormsg +='El cuerpo del mensaje no puede estar vac&iacute;o\\n';
                                		  }
                                      }                        		      
                        		  }
                                  if (errormsg.length > 0) {
                                    alert(errormsg);
                                  }
                        			jQuery(\"#buttons\").fadeOut();
                                    jQuery(\"#send_error\").remove();
                        			jQuery(\"#btn_check_email\").after(\"<p style='background:#BBFFC0;font:normal 11px verdana' id='enviando'>Guradando y Enviando...</p>\");
                        		},
                        		success: function(data){    
                        			jQuery(\"#enviando\").remove();  
                        			jQuery(\"#buttons\").fadeIn();
                        			jQuery(\"#btn_check_email\").after(\"<div style='background:#F66;font:normal 11px verdana' id='send_error'>\"+data+\"</div>\");
                                 }
                            });
                        });
            </script>";
        }
        $html_output .= "</div>";
        echo $html_output;
    }

    public function send() {
        $this->load->model('email/newsletter');
        if ($this->request->post) {
            $htmlbody = ($this->request->post['htmlbody']) ? $this->request->post['htmlbody'] : '';
            $textbody = ($this->request->post['textbody']) ? $this->request->post['textbody'] : '';
            $format = ($this->request->post['format']) ? $this->request->post['format'] : '';
            $subject = ($this->request->post['subject']) ? $this->request->post['subject'] : '';
            $from_email = ($this->request->post['from_email']) ? $this->request->post['from_email'] : '';
            $from_name = ($this->request->post['from_name']) ? $this->request->post['from_name'] : '';
            $replyto_email = ($this->request->post['replyto_email']) ? $this->request->post['replyto_email'] : '';
            $bounce_email = ($this->request->post['bounce_email']) ? $this->request->post['bounce_email'] : '';
            $newsletter_id = ($this->request->post['newsletter_id']) ? $this->request->post['newsletter_id'] : '';
        } /* elseif ($this->request->get) {           
          $htmlbody = ($this->request->get['htmlbody']) ? $this->request->get['htmlbody'] : '';
          $textbody = ($this->request->get['textbody']) ? $this->request->get['textbody'] : '';
          $format = ($this->request->get['format']) ? $this->request->get['format'] : '';
          $subject = ($this->request->get['subject']) ? $this->request->get['subject'] : '';
          $from_email = ($this->request->get['from_email']) ? $this->request->get['from_email'] : '';
          $from_name = ($this->request->get['from_name']) ? $this->request->get['from_name'] : '';
          $replyto_email = ($this->request->get['replyto_email']) ? $this->request->get['replyto_email'] : '';
          $bounce_email = ($this->request->get['bounce_email']) ? $this->request->get['bounce_email'] : '';
          $newsletter_id = ($this->request->get['newsletter_id']) ? $this->request->get['newsletter_id'] : '';
          } */
        $newsletter_id = 2;
        $newsletter_info = isset($newsletter_id) ? $this->model_email_newsletter->getNewsletter($newsletter_id) : '';
        $members = isset($newsletter_id) ? $this->model_email_newsletter->getMemberByNewsletter($newsletter_id) : '';
        if (is_array($members) && sizeof($members) > 0) {
            foreach ($members as $k => $member) {
                $member_info[] = $this->model_email_newsletter->getMember((int) $member);
                if (sizeof($member_info[$k]) > 0) {
                    $address[] = array(
                        'email' => $member_info[$k]['email'],
                        'name' => $member_info[$k]['firstname'] . ' ' . $member_info[$k]['lastname']
                    );
                }
            }
        }
        $send_data = array();
        $send_data['subject'] = $subject;
        $send_data['from_email'] = $from_email;
        $send_data['from_name'] = $from_name;
        $send_data['to'] = $address;
        if ($format == 'a') {
            $send_data['body'] = $htmlbody;
            $send_data['alt_body'] = $textbody;
        } elseif ($format == 'h') {
            $send_data['body'] = $htmlbody;
            $send_data['alt_body'] = 'Para poder ver este mensaje, debe utilizar un cliente de correo que soporte HTML';
        } else {
            $send_data['body'] = $textbody;
        }
        $this->vcard->deleteOldFiles();
        $this->vcard->getOwnerVCard();
        $this->mailer->AddAttachment(DIR_DOWNLOAD . 'vcard.vcf');
        $result = $this->email_f->_send($send_data);
        if ($result !== 1) {
            echo $result;
            return $result;
        } else {
            echo "Enviado con &eacute;xito";
        }
    }

    public function saveAndSend() {
        $result = "<h3>Hay Errores</h3>";
        $result .= $this->send();
        if ($result !== false) {
            $this->load->model('email/newsletter');
            $result .= $this->model_email_newsletter->update($this->request->post['newsletter_id'], $this->request->post);
        }
        if ($result !== 1) {
            echo $result;
            return $result;
        } else {
            echo "Enviado con &eacute;xito";
        }
    }

}

?>