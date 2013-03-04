<?php 
class ControllerContentPage extends Controller {
	public function index() {  
    	$this->language->load('content/page');
		
		$this->load->model('content/page');
		
		$this->document->breadcrumbs = array();
		
      	$this->document->breadcrumbs[] = array(
        	'href'      => HTTP_HOME . 'index.php?r=common/home',
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	);
		
		if (isset($this->request->get['page_id'])) {
			$page_id = $this->request->get['page_id'];
		} else {
			$page_id = 0;
		}
		
		$page_info = $this->modelPage->getById($page_id);
   		
		if ($page_info) {
	  		$this->document->title = $page_info['title']; 

      		$this->document->breadcrumbs[] = array(
        		'href'      => HTTP_HOME . 'index.php?r=content/page&page_id=' . $this->request->get['page_id'],
        		'text'      => $page_info['title'],
        		'separator' => $this->language->get('text_separator')
      		);		
						
      		$this->data['heading_title'] = $page_info['title'];
      		
			$this->data['description'] = html_entity_decode($page_info['description']);
      		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/content/page.tpl')) {
				$this->template = $this->config->get('config_template') . '/content/page.tpl';
			} else {
				$this->template = 'default/content/page.tpl';
			}
			
			$this->children = array(
			'common/nav',
			'common/column_left',
			'common/footer',
			'common/header'
		);	
			
	  		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    	} else {
      		$this->document->breadcrumbs[] = array(
        		'href'      => HTTP_HOME . 'index.php?r=content/page&page_id=' . $this->request->get['page_id'],
        		'text'      => $this->language->get('text_error'),
        		'separator' => $this->language->get('text_separator')
      		);
				
	  		$this->document->title = $this->language->get('text_error');
			
      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/error/not_found.tpl';
			} else {
				$this->template = 'default/error/not_found.tpl';
			}
			
			$this->children = array(
			'common/nav',
			'common/column_left',
			'common/footer',
			'common/header'
		);
		
	  		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    	}
  	}
}
