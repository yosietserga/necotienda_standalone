<?php 
/**
 * ControllerStoreProduct
 * 
 * @package NecoTienda powered by opencart
 * @author Yosiet Serga
 * @copyright Inversiones Necoyoad, C.A.
 * @version 1.0.0
 * @access public
 * @see Controller
 */
class ControllerStoreProduct extends Controller {
	private $error = array(); 
     
  	/**
  	 * ControllerStoreProduct::index()
     * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see getList
  	 * @return void
  	 */
  	public function index() {
		$this->document->title = $this->language->get('heading_title'); 
		$this->getList();
  	}
  
  	/**
  	 * ControllerStoreProduct::insert()
  	 * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see Redirect
  	 * @see getForm
  	 * @return void
  	 */
  	public function insert() {
    	$this->document->title = $this->language->get('heading_title'); 
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            
            foreach ($this->request->post['product_description'] as $language_id => $description) {
                $dom = new DOMDocument;
                $dom->preserveWhiteSpace = false;
                $dom->loadHTML(html_entity_decode($description['description']));
                $images = $dom->getElementsByTagName('img');
                foreach ($images as $image) {
                    $src = $image->getAttribute('src');
                    
                    if (preg_match('/data:([^;]*);base64,(.*)/',$src)) {
                        list($type,$img) = explode(",",$src);
                        $type = trim(substr($type,strpos($type,"/")+1,3));
                        
                        //TODO: validar imagenes
                        
                        $str = $this->config->get('config_name');
                        if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
                        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
                        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
                        $str = strtolower( trim($str, '-') );
                                
                        $filename = uniqid($str."-") . "_" . time() . "." . $type;
                        $fp = fopen( DIR_IMAGE . "data/" . $filename, 'wb' );
                        fwrite( $fp, base64_decode($img));
                        fclose( $fp );
                        $image->setAttribute('src', HTTP_IMAGE . "data/" . $filename);
                    }
                }
                $description['description'] = htmlentities($dom->saveHTML());
                $this->request->post['product_description'][$language_id] = $description;
            }
              
			$product_id = $this->modelProduct->addProduct($this->request->post);
            if ($product_id===false) {
                $this->error['warning'] = "No puede crear m&aacute;s productos, ha llegado al l&iacute;mite permitido para su cuenta.\nSi desea agregar m&aacute;s productos a su tienda debe comprar una nueva licencia.";
            } else {            
    			$this->session->set('success',$this->language->get('text_success'));
    	  
                if ($_POST['to'] == "saveAndKeep") {
                    $this->redirect(Url::createAdminUrl('store/product/update',array('product_id'=>$product_id))); 
                } elseif ($_POST['to'] == "saveAndNew") {
                    $this->redirect(Url::createAdminUrl('store/product/insert')); 
                } else {
                    $this->redirect(Url::createAdminUrl('store/product')); 
                }
            }
	  		
    	}
	
    	$this->getForm();
  	}

  	/**
  	 * ControllerStoreProduct::update()
  	 * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see Redirect
  	 * @see getForm
  	 * @return void
  	 */
  	public function update() {
    	$this->document->title = $this->language->get('heading_title');
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            
            foreach ($this->request->post['product_description'] as $language_id => $description) {
                $dom = new DOMDocument;
                $dom->preserveWhiteSpace = false;
                $dom->loadHTML(html_entity_decode($description['description']));
                $images = $dom->getElementsByTagName('img');
                foreach ($images as $image) {
                    $src = $image->getAttribute('src');
                    
                    if (preg_match('/data:([^;]*);base64,(.*)/',$src)) {
                        list($type,$img) = explode(",",$src);
                        $type = trim(substr($type,strpos($type,"/")+1,3));
                        
                        //TODO: validar imagenes
                        
                        $str = $this->config->get('config_name');
                        if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
                            $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
                        $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
                        $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
                        $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
                        $str = strtolower( trim($str, '-') );
                                
                        $filename = uniqid($str."-") . "_" . time() . "." . $type;
                        $fp = fopen( DIR_IMAGE . "data/" . $filename, 'wb' );
                        fwrite( $fp, base64_decode($img));
                        fclose( $fp );
                        $image->setAttribute('src', HTTP_IMAGE . "data/" . $filename);
                    }
                }
                $description['description'] = htmlentities($dom->saveHTML());
                $this->request->post['product_description'][$language_id] = $description;
            }
              
			$this->modelProduct->editProduct($this->request->get['product_id'], $this->request->post);
			
			$this->session->set('success',$this->language->get('text_success'));
			
                if ($_POST['to'] == "saveAndKeep") {
                    $this->redirect(Url::createAdminUrl('store/product/update',array('product_id'=>$this->request->get['product_id']))); 
                } elseif ($_POST['to'] == "saveAndNew") {
                    $this->redirect(Url::createAdminUrl('store/product/insert')); 
                } else {
                    $this->redirect(Url::createAdminUrl('store/product')); 
                }
		}

    	$this->getForm();
  	}

  	/**
  	 * ControllerStoreProduct::getList()
  	 * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see Redirect
  	 * @see Session
  	 * @see Response
  	 * @return void
  	 */
  	private function getList() {
  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('store/product') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = Url::createAdminUrl('store/product/insert') . $url;
		$this->data['import'] = Url::createAdminUrl('store/product/import') . $url;
		$this->data['export'] = Url::createAdminUrl('store/product/export') . $url;
		$this->data['copy'] = Url::createAdminUrl('store/product/copy') . $url;	
		$this->data['delete'] = Url::createAdminUrl('store/product/delete') . $url;

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_export'] = $this->language->get('button_export');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_import'] = $this->language->get('button_import');
		$this->data['button_filter'] = $this->language->get('button_filter');
 
 		if (isset($this->error['warning'])) {
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
        $scripts[] = array('id'=>'productList','method'=>'function','script'=>
            "function activate(e) {    
            	$.ajax({
            	   'type':'get',
                   'dataType':'json',
                   'url':'".Url::createAdminUrl("store/product/activate")."&id=' + e,
                   'success': function(data) {
                        if (data > 0) {
                            $(\"#img_\" + e).attr('src','image/good.png');
                        } else {
                            $(\"#img_\" + e).attr('src','image/minus.png');
                        }
                   }
            	});
             }
            function copy(e) {
                $('#gridWrapper').hide();
                $('#gridPreloader').show();
                $.getJSON('".Url::createAdminUrl("store/product/copy")."&id=' + e, function(data) {
                    $('#gridWrapper').load('". Url::createAdminUrl("store/product/grid") ."',function(response){
                        $('#gridPreloader').hide();
                        $('#gridWrapper').show();
                    });
                });
            }
            function eliminar(e) {
                if (confirm('¿Desea eliminar este objeto?')) {
                    $('#tr_' + e).remove();
                	$.getJSON('". Url::createAdminUrl("store/product/delete") ."',{
                        id:e
                    });
                }
                return false;
             }
            function editAll() {
                return false;
            } 
            function addToList() {
                return false;
            } 
            function copyAll() {
                $('#gridWrapper').hide();
                $('#gridPreloader').show();
                $.post('". Url::createAdminUrl("store/product/copy") ."',$('#form').serialize(),function(){
                    $('#gridWrapper').load('". Url::createAdminUrl("store/product/grid") ."',function(){
                        $('#gridWrapper').show();
                        $('#gridPreloader').hide();
                    });
                });
                return false;
            } 
            function deleteAll() {
                if (confirm('¿Desea eliminar todos los objetos seleccionados?')) {
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                    $.post('". Url::createAdminUrl("store/product/delete") ."',$('#form').serialize(),function(){
                        $('#gridWrapper').load('". Url::createAdminUrl("store/product/grid") ."',function(){
                            $('#gridWrapper').show();
                            $('#gridPreloader').hide();
                        });
                    });
                }
                return false;
            }");
        $scripts[] = array('id'=>'sortable','method'=>'ready','script'=>
            "$('#gridWrapper').load('". Url::createAdminUrl("store/product/grid") ."',function(){
                $('#gridPreloader').hide();
                $('#list tbody').sortable({
                    opacity: 0.6, 
                    handle: '.move',
                    update: function() {
                        $.ajax({
                            type:'post',
                            dateType:'json',
                            url:'". Url::createAdminUrl("store/product/sortable") ."',
                            data: $(this).sortable(\"serialize\"),
                            success: function(data) {
                                if (data > 0) {
                                    var msj = \"<div class='success'>Se han ordenado los objetos correctamente</div>\";
                                } else {
                                    var msj = \"<div class='warning'>Hubo un error al intentar ordenar los objetos, por favor intente más tarde</div>\";
                                }
                                $(\"#msg\").append(msj).delay(3600).fadeOut();
                            }
                        });
                    }
                }).disableSelection();
                $('#list .move').css('cursor','move');
            });
            $('#formFilter').ntForm({
                lockButton:false,
                ajax:true,
                type:'get',
                dataType:'html',
                url:'". Url::createAdminUrl("store/product/grid") ."',
                beforeSend:function(){
                    $('#gridWrapper').hide();
                    $('#gridPreloader').show();
                },
                success:function(data){
                    $('#gridPreloader').hide();
                    $('#gridWrapper').html(data).show();
                }
            });");
             
        $this->scripts = array_merge($this->scripts,$scripts);
        
		$this->template = 'store/product_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}

  	/**
  	 * ControllerStoreProduct::grid()
  	 * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see Redirect
  	 * @see Session
  	 * @see Response
  	 * @return void
  	 */
  	public function grid() {
  	     //TODO: mantener y capturar los filtros en todos los enlaces
		$filter_name = isset($this->request->get['filter_name']) ? $this->request->get['filter_name'] : null;
		$filter_model = isset($this->request->get['filter_model']) ? $this->request->get['filter_model'] : null;
		$filter_quantity = isset($this->request->get['filter_quantity']) ? $this->request->get['filter_quantity'] : null;
		$filter_status = isset($this->request->get['filter_status']) ? $this->request->get['filter_status'] : null;
		$filter_date_start = isset($this->request->get['filter_date_start']) ? $this->request->get['filter_date_start'] : null;
		$filter_date_end = isset($this->request->get['filter_date_end']) ? $this->request->get['filter_date_end'] : null;
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : 1;
		$sort = isset($this->request->get['sort']) ? $this->request->get['sort'] : 'pd.name';
		$order = isset($this->request->get['order']) ? $this->request->get['order'] : 'ASC';
		$limit = !empty($this->request->get['limit']) ? $this->request->get['limit'] : $this->config->get('config_admin_limit');

		$url = '';
			
		if (isset($this->request->get['filter_name'])) { $url .= '&filter_name=' . $this->request->get['filter_name']; } 
		if (isset($this->request->get['filter_model'])) { $url .= '&filter_model=' . $this->request->get['filter_model']; } 
		if (isset($this->request->get['filter_quantity'])) { $url .= '&filter_quantity=' . $this->request->get['filter_quantity']; } 
		if (isset($this->request->get['filter_status'])) { $url .= '&filter_status=' . $this->request->get['filter_status']; } 
		if (isset($this->request->get['filter_date_start'])) { $url .= '&filter_date_start=' . $this->request->get['filter_date_start']; }
		if (isset($this->request->get['filter_date_end'])) { $url .= '&filter_date_end=' . $this->request->get['filter_date_end']; }
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }
		if (!empty($this->request->get['limit'])) { $url .= '&limit=' . $this->request->get['limit']; }
		

		$this->data['products'] = array();

		$data = array(
			'filter_name'	  => $filter_name, 
			'filter_model'	  => $filter_model,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'filter_date_start'=> $filter_date_start,
			'filter_date_end' => $filter_date_end,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $limit,
			'limit'           => $limit
		);
        
		$product_total = $this->modelProduct->getTotalProducts($data);
			
		$results = $this->modelProduct->getProducts($data);
				    	
		foreach ($results as $result) {
			$action = array(
                'activate'  => array(
                        'action'  => 'activate',
                        'text'  => $this->language->get('text_activate'),
                        'href'  =>'',
                        'img'   => 'good.png'
                ),
                'edit'      => array(
                        'action'  => 'edit',
                        'text'  => $this->language->get('text_edit'),
                        'href'  =>Url::createAdminUrl('store/product/update') . '&product_id=' . $result['product_id'] . $url,
                        'img'   => 'edit.png'
                ),
                'duplicate' => array(
                        'action'  => 'duplicate',
                        'text'  => $this->language->get('text_copy'),
                        'href'  =>'',
                        'img'   => 'copy.png'
                ),
                'delete'    => array(
                        'action'  => 'delete',
                        'text'  => $this->language->get('text_delete'),
                        'href'  =>'',
                        'img'   => 'delete.png'
                )
            );
			
			if ($result['pimage'] && file_exists(DIR_IMAGE . $result['pimage'])) {
				$image = NTImage::resizeAndSave($result['pimage'], 40, 40);
			} else {
				$image = NTImage::resizeAndSave('no_image.jpg', 40, 40);
			}
			
      		$this->data['products'][] = array(
				'product_id' => $result['product_id'],
				'name'       => $result['pname'],
				'model'      => $result['model'],                
				'meta_keywords' => $result['meta_keywords'],
				'meta_description'       => $result['meta_description'],
				'description'      => $result['pdescription'],
				'sku' => $result['sku'],
				'ssname'       => $result['ssname'],
				'mname'      => $result['mname'],
				'shipping' => $result['shipping'],
				'price'       => $result['price'],
				'tctitle'      => $result['tctitle'],
				'date_available' => $result['date_available'],
				'weight'       => $result['weight'],
				'wctitle'      => $result['wctitle'],
				'length' => $result['length'],
				'width'       => $result['width'],
				'height'      => $result['height'],
				'lctitle' => $result['lctitle'],
				'date_added'      => $result['date_added'],                
				'date_modified'      => $result['date_modified'],
				'viewed' => $result['viewed'],
				'subtract'       => $result['subtract'],
				'minimum'      => $result['minimum'],
				'cost'      => $result['cost'],              
				'sort_order'  => $result['sort_order'],  
				'image'      => $image,
				'quantity'   => $result['quantity'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
        
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');

		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
    	$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');

$url = '';
								
		if (isset($this->request->get['page'])) {$url .= '&page=' . $this->request->get['page'];}
		if (isset($this->request->get['sort'])) {$url .= '&sort=' . $this->request->get['sort'];}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['filter_name'])) {$url .= '&filter_name=' . $this->request->get['filter_name'];}
		if (isset($this->request->get['filter_model'])) {$url .= '&filter_model=' . $this->request->get['filter_model'];}
		if (isset($this->request->get['filter_quantity'])) {$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];}
		if (isset($this->request->get['filter_status'])) {$url .= '&filter_status=' . $this->request->get['filter_status'];}
		
		$this->data['sort_name']      = Url::createAdminUrl('store/product/grid') . '&sort=pd.name' . $url;
		$this->data['sort_model']     = Url::createAdminUrl('store/product/grid') . '&sort=p.model' . $url;
		$this->data['sort_quantity']  = Url::createAdminUrl('store/product/grid') . '&sort=p.quantity' . $url;
		$this->data['sort_status']    = Url::createAdminUrl('store/product/grid') . '&sort=p.status' . $url;
		$this->data['sort_order']     = Url::createAdminUrl('store/product/grid') . '&sort=p.sort_order' . $url;

		$pagination = new Pagination();
		$pagination->ajax = true;
		$pagination->ajaxTarget = "gridWrapper";
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createAdminUrl('store/product/grid') . $url . '&page={page}';
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_name'] = $filter_name;
		$this->data['filter_model'] = $filter_model;
		$this->data['filter_quantity'] = $filter_quantity;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'store/product_grid.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	}

  	/**
  	 * ControllerStoreProduct::getForm()
  	 * 
  	 * @see Load
  	 * @see Language
  	 * @see Document
  	 * @see Model
  	 * @see Redirect
  	 * @see Session
  	 * @see Response
  	 * @return void
  	 */
  	private function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_none'] = $this->language->get('text_none');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_plus'] = $this->language->get('text_plus');
		$this->data['text_minus'] = $this->language->get('text_minus');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_option'] = $this->language->get('text_option');
		$this->data['text_option_value'] = $this->language->get('text_option_value');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['tab_shipping'] = $this->language->get('tab_shipping');
		$this->data['tab_links'] = $this->language->get('tab_links');
		
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_meta_keywords'] = $this->language->get('entry_meta_keywords');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
    	$this->data['entry_model'] = $this->language->get('entry_model');
		$this->data['entry_sku'] = $this->language->get('entry_sku');
		$this->data['entry_location'] = $this->language->get('entry_location');
		$this->data['entry_minimum'] = $this->language->get('entry_minimum');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
    	$this->data['entry_shipping'] = $this->language->get('entry_shipping');
    	$this->data['entry_date_available'] = $this->language->get('entry_date_available');
    	$this->data['entry_quantity'] = $this->language->get('entry_quantity');
		$this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
    	$this->data['entry_status'] = $this->language->get('entry_status');
    	$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
    	$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_cost'] = $this->language->get('entry_cost');
		$this->data['entry_subtract'] = $this->language->get('entry_subtract');
    	$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
    	$this->data['entry_weight'] = $this->language->get('entry_weight');
		$this->data['entry_dimension'] = $this->language->get('entry_dimension');
		$this->data['entry_length'] = $this->language->get('entry_length');
    	$this->data['entry_image'] = $this->language->get('entry_image');
    	$this->data['entry_download'] = $this->language->get('entry_download');
    	$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_related'] = $this->language->get('entry_related');
		$this->data['entry_option'] = $this->language->get('entry_option');
		$this->data['entry_option_value'] = $this->language->get('entry_option_value');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_prefix'] = $this->language->get('entry_prefix');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_priority'] = $this->language->get('entry_priority');
		$this->data['entry_tags'] = $this->language->get('entry_tags');
		
		$this->data['help_name'] = $this->language->get('help_name');
		$this->data['help_meta_keywords'] = $this->language->get('help_meta_keywords');
		$this->data['help_meta_description'] = $this->language->get('help_meta_description');
		$this->data['help_description'] = $this->language->get('help_description');
		$this->data['help_keyword'] = $this->language->get('help_keyword');
    	$this->data['help_model'] = $this->language->get('help_model');
		$this->data['help_sku'] = $this->language->get('help_sku');
		$this->data['help_location'] = $this->language->get('help_location');
		$this->data['help_minimum'] = $this->language->get('help_minimum');
		$this->data['help_manufacturer'] = $this->language->get('help_manufacturer');
    	$this->data['help_shipping'] = $this->language->get('help_shipping');
    	$this->data['help_date_available'] = $this->language->get('help_date_available');
    	$this->data['help_quantity'] = $this->language->get('help_quantity');
		$this->data['help_stock_status'] = $this->language->get('help_stock_status');
    	$this->data['help_status'] = $this->language->get('help_status');
    	$this->data['help_tax_class'] = $this->language->get('help_tax_class');
    	$this->data['help_price'] = $this->language->get('help_price');
		$this->data['help_cost'] = $this->language->get('help_cost');
		$this->data['help_subtract'] = $this->language->get('help_subtract');
    	$this->data['help_weight_class'] = $this->language->get('help_weight_class');
    	$this->data['help_weight'] = $this->language->get('help_weight');
		$this->data['help_dimension'] = $this->language->get('help_dimension');
		$this->data['help_length'] = $this->language->get('help_length');
    	$this->data['help_image'] = $this->language->get('help_image');
    	$this->data['help_download'] = $this->language->get('help_download');
    	$this->data['help_category'] = $this->language->get('help_category');
		$this->data['help_related'] = $this->language->get('help_related');
		$this->data['help_option'] = $this->language->get('help_option');
		$this->data['help_option_value'] = $this->language->get('help_option_value');
		$this->data['help_sort_order'] = $this->language->get('help_sort_order');
		$this->data['help_prefix'] = $this->language->get('help_prefix');
		$this->data['help_customer_group'] = $this->language->get('help_customer_group');
		$this->data['help_date_start'] = $this->language->get('help_date_start');
		$this->data['help_date_end'] = $this->language->get('help_date_end');
		$this->data['help_priority'] = $this->language->get('help_priority');
		$this->data['help_tags'] = $this->language->get('help_tags');
		
		$this->data['button_save_and_new']= $this->language->get('button_save_and_new');
		$this->data['button_save_and_exit']= $this->language->get('button_save_and_exit');
		$this->data['button_save_and_keep']= $this->language->get('button_save_and_keep');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_option'] = $this->language->get('button_add_option');
		$this->data['button_add_option_value'] = $this->language->get('button_add_option_value');
		$this->data['button_add_discount'] = $this->language->get('button_add_discount');
		$this->data['button_add_special'] = $this->language->get('button_add_special');
		$this->data['button_add_image'] = $this->language->get('button_add_image');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
    	$this->data['tab_links'] = $this->language->get('tab_links');
		$this->data['tab_discount'] = $this->language->get('tab_discount');
		$this->data['tab_special'] = $this->language->get('tab_special');
		$this->data['tab_option'] = $this->language->get('tab_option');
    	$this->data['tab_image'] = $this->language->get('tab_image');
 
 		$this->data['error_warning'] = ($this->error['warning']) ? $this->error['warning'] : '';
 		$this->data['error_name'] = ($this->error['name']) ? $this->error['name'] : '';
 		$this->data['error_meta_description'] = ($this->error['meta_description']) ? $this->error['meta_description'] : '';
 		$this->data['error_description'] = ($this->error['description']) ? $this->error['description'] : '';
 		$this->data['error_model'] = ($this->error['model']) ? $this->error['model'] : '';
 		$this->data['error_date_available'] = ($this->error['date_available']) ? $this->error['date_available'] : '';


		$url = '';
		if (isset($this->request->get['filter_name'])) { $url .= '&filter_name=' . $this->request->get['filter_name']; }
		if (isset($this->request->get['filter_model'])) { $url .= '&filter_model=' . $this->request->get['filter_model']; }
		if (isset($this->request->get['filter_quantity'])) { $url .= '&filter_quantity=' . $this->request->get['filter_quantity']; }
		if (isset($this->request->get['filter_status'])) { $url .= '&filter_status=' . $this->request->get['filter_status']; }					
		if (isset($this->request->get['page'])) { $url .= '&page=' . $this->request->get['page']; }
		if (isset($this->request->get['sort'])) { $url .= '&sort=' . $this->request->get['sort']; }
		if (isset($this->request->get['order'])) { $url .= '&order=' . $this->request->get['order']; }

  		$this->document->breadcrumbs = array();
   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('common/home'),
       		'text'      => $this->language->get('text_home'),
			'separator' => false
   		);
   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl('store/product') . $url,
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['product_id'])) {
			$this->data['action'] = Url::createAdminUrl('store/product/insert') . $url;
		} else {
			$this->data['action'] = Url::createAdminUrl('store/product/update') . '&product_id=' . $this->request->get['product_id'] . $url;
		}
		
		$this->data['cancel'] = Url::createAdminUrl('store/product') . $url;

		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$product_info = $this->modelProduct->getProduct($this->request->get['product_id']);
    	}

        $this->setvar('model',$product_info,'');
        $this->setvar('sku',$product_info,'');
        $this->setvar('location',$product_info,'');
        $this->setvar('keyword',$product_info,'');
        $this->setvar('image',$product_info,'');
        $this->setvar('manufacturer_id',$product_info,0);
        $this->setvar('shipping',$product_info,1);
        $this->setvar('quantity',$product_info,1);
        $this->setvar('minimum',$product_info,1);
        $this->setvar('subtract',$product_info,1);
        $this->setvar('sort_order',$product_info,0);
        $this->setvar('stock_status_id',$product_info,$this->config->get('config_stock_status_id'));
        $this->setvar('tax_class_id',$product_info,0);
        $this->setvar('weight',$product_info,0);
        $this->setvar('price',$product_info,'');
        $this->setvar('cost',$product_info,'');
        $this->setvar('status',$product_info,1);
        $this->setvar('length',$product_info,'');
        $this->setvar('width',$product_info,'');
        $this->setvar('height',$product_info,'');
        
		$this->data['languages'] = $this->modelLanguage->getLanguages();
    	$this->data['manufacturers'] = $this->modelManufacturer->getManufacturers();
		$this->data['stock_statuses'] = $this->modelStockstatus->getStockStatuses();
		$this->data['tax_classes'] = $this->modelTaxclass->getTaxClasses();
		$this->data['weight_classes'] = $this->modelWeightclass->getWeightClasses();
		$this->data['length_classes'] = $this->modelLengthclass->getLengthClasses();
		$this->data['customer_groups'] = $this->modelCustomergroup->getCustomerGroups();
		$this->data['downloads'] = $this->modelDownload->getDownloads();
		$this->data['categories'] = $this->modelCategory->getCategories(0);
        
		if (isset($this->request->post['product_description'])) {
			$this->data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($product_info)) {
			$this->data['product_description'] = $this->modelProduct->getProductDescriptions($this->request->get['product_id']);
		} else {
			$this->data['product_description'] = array();
		}
		
		if (isset($this->request->post['product_tags'])) {
			$this->data['product_tags'] = $this->request->post['product_tags'];
		} elseif (isset($product_info)) {
			$this->data['product_tags'] = $this->modelProduct->getProductTags($this->request->get['product_id']);
		} else {
			$this->data['product_tags'] = array();
		}
		
		if (file_exists(DIR_IMAGE . $product_info['image'])) {
			$this->data['preview'] = NTImage::resizeAndSave($product_info['image'], 100, 100);
		} else {
			$this->data['preview'] = NTImage::resizeAndSave('no_image.jpg', 100, 100);
		}
	
		if (isset($this->request->post['date_available'])) {
       		$this->data['date_available'] = $this->request->post['date_available'];
		} elseif (isset($product_info)) {
			$this->data['date_available'] = date('Y-m-d', strtotime($product_info['date_available']));
		} else {
			$this->data['date_available'] = date('Y-m-d', time()-86400);
		}
		
    	
    	$weight_info = $this->modelWeightclass->getWeightClassDescriptionByUnit($this->config->get('config_weight_class'));
		if (isset($this->request->post['weight_class_id'])) {
      		$this->data['weight_class_id'] = $this->request->post['weight_class_id'];
    	} elseif (isset($product_info)) {
      		$this->data['weight_class_id'] = $product_info['weight_class_id'];
    	} elseif (isset($weight_info)) {
      		$this->data['weight_class_id'] = $weight_info['weight_class_id'];
		} else {
      		$this->data['weight_class_id'] = '';
    	}
		
    	$length_info = $this->modelLengthclass->getLengthClassDescriptionByUnit($this->config->get('config_length_class'));
		if (isset($this->request->post['length_class_id'])) {
      		$this->data['length_class_id'] = $this->request->post['length_class_id'];
    	} elseif (isset($product_info)) {
      		$this->data['length_class_id'] = $product_info['length_class_id'];
    	} elseif (isset($length_info)) {
      		$this->data['length_class_id'] = $length_info['length_class_id'];
    	} else {
    		$this->data['length_class_id'] = '';
		}
		
		$this->data['language_id'] = $this->config->get('config_language_id');
		
		if (isset($this->request->post['product_option'])) {
			$this->data['product_options'] = $this->request->post['product_option'];
		} elseif (isset($product_info)) {
			$this->data['product_options'] = $this->modelProduct->getProductOptions($this->request->get['product_id']);
		} else {
			$this->data['product_options'] = array();
		}
		
		
		if (isset($this->request->post['product_discount'])) {
			$this->data['product_discounts'] = $this->request->post['product_discount'];
		} elseif (isset($product_info)) {
			$this->data['product_discounts'] = $this->modelProduct->getProductDiscounts($this->request->get['product_id']);
		} else {
			$this->data['product_discounts'] = array();
		}

		if (isset($this->request->post['product_special'])) {
			$this->data['product_specials'] = $this->request->post['product_special'];
		} elseif (isset($product_info)) {
			$this->data['product_specials'] = $this->modelProduct->getProductSpecials($this->request->get['product_id']);
		} else {
			$this->data['product_specials'] = array();
		}
		
		if (isset($this->request->post['product_download'])) {
			$this->data['product_download'] = $this->request->post['product_download'];
		} elseif (isset($product_info)) {
			$this->data['product_download'] = $this->modelProduct->getProductDownloads($this->request->get['product_id']);
		} else {
			$this->data['product_download'] = array();
		}		
		
		
		if (isset($this->request->post['product_category'])) {
			$this->data['product_category'] = $this->request->post['product_category'];
		} elseif (isset($product_info)) {
			$this->data['product_category'] = $this->modelProduct->getProductCategories($this->request->get['product_id']);
		} else {
			$this->data['product_category'] = array();
		}		
		
 		if (isset($this->request->post['product_related'])) {
			$this->data['product_related'] = $this->request->post['product_related'];
		} elseif (isset($product_info)) {
			$this->data['product_related'] = $this->modelProduct->getProductRelated($this->request->get['product_id']);
		} else {
			$this->data['product_related'] = array();
		}
				
		$this->data['no_image'] = NTImage::resizeAndSave('no_image.jpg', 100, 100);
		$this->data['product_images'] = array();
		if (isset($product_info)) {
			$results = $this->modelProduct->getProductImages($this->request->get['product_id']);
			foreach ($results as $result) {
				if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
					$this->data['product_images'][] = array(
						'preview' => NTImage::resizeAndSave($result['image'], 100, 100),
						'file'    => $result['image']
					);
				} else {
					$this->data['product_images'][] = array(
						'preview' => NTImage::resizeAndSave('no_image.jpg', 100, 100),
						'file'    => $result['image']
					);
				}
			}
		}		

        $this->data['Url'] = new Url;
        
        $scripts[] = array('id'=>'form','method'=>'ready','script'=>
            "$('#product_description1_name').blur(function(e){
                $.getJSON('". Url::createAdminUrl('common/home/slug') ."',{ slug : $(this).val() },function(data){
                        $('#slug').val(data.slug);
                });
            });
            
            $('#accordion').accordion({
                collapsible: true
            });
            
            $('#relatedTrash').droppable({
                accept: '#relatedTarget > li',
                activeClass: 'ui-state-highlight',
                drop: function( event, ui ) {
                    deleteImage( ui.draggable );
                }
            });
            
            $('#relatedTarget').droppable({
                accept: '#relatedSourge > li',
                activeClass: 'ui-state-highlight',
                drop: function( event, ui ) {
                    var item = ui.draggable.clone();
                    $('#relatedTarget')
                        .preppend(item)
                        .append('<input type=\"hidden\" name=\"\" value=\"\" />');
                }
            });
            
            $('#relatedTarget li').draggable({
                cancel: 'a.ui-icon',
                revert: 'invalid', 
                containment: 'document',
                helper: 'clone'
            });
            
            $('#related li').draggable({
                cancel: 'a.ui-icon',
                revert: 'invalid',
                containment: 'document',
                helper: 'clone'
            });
            
            $('.trends').fancybox({
        		maxWidth	: 640,
        		maxHeight	: 600,
        		fitToView	: false,
        		width		: '70%',
        		height		: '70%',
        		autoSize	: false,
        		closeClick	: false,
        		openEffect	: 'none',
        		closeEffect	: 'none'
        	});
            
            $('#q').on('change',function(e){
                var that = this;
                var valor = $(that).val().toLowerCase();
                if (valor.length <= 0) {
                    $('#categoriesWrapper li').show();
                } else {
                    $('#categoriesWrapper li b').each(function(){
                        if ($(this).text().toLowerCase().indexOf( valor ) != -1) {
                            $(this).closest('li').show();
                        } else {
                            $(this).closest('li').hide();
                        }
                    });
                }
            }); 
                            
            $('#form').ntForm({
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
            
            $('.tabs li').on('click',function() {
                $('.tabs li').each(function(){
                   $('#' + this.id + '_content').hide();
                   $(this).removeClass('active'); 
                });
                $(this).addClass('active');
                $('#' + this.id + '_content').show(); 
           }); 
           
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
            
        foreach ($this->data['languages'] as $language) {
            $scripts[] = array('id'=>'Language$language["language_id"]','method'=>'ready','script'=>
                "CKEDITOR.replace('description". $language["language_id"] ."', {
                	filebrowserBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserImageBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserFlashBrowseUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserUploadUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserImageUploadUrl: '". Url::createAdminUrl("common/filemanager") ."',
                	filebrowserFlashUploadUrl: '". Url::createAdminUrl("common/filemanager") ."'
                });");
        }
        
        $scripts[] = array('id'=>'Functions','method'=>'function','script'=>
            "function saveAndExit() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndExit'>\").submit(); 
            }
            
            function saveAndKeep() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndKeep'>\").submit(); 
            }
            
            function saveAndNew() { 
                window.onbeforeunload = null;
                $('#form').append(\"<input type='hidden' name='to' value='saveAndNew'>\").submit(); 
            }
            
            function deleteImage( item ) {
                item.animate({
                    'position':'absolute',
                    'top':$('#relatedTrash').offset().top,
                    'left':$('#relatedTrash').offset().left,
                    'opacity':0
                },500,function() {
                    item.remove();     
                });
            }
            
            function image_delete(field, preview) {
                $('#' + field).val('');
                $('#' + preview).attr('src','". HTTP_IMAGE ."cache/no_image-100x100.jpg');
            }
            
            function image_upload(field, preview) {
                var height = $(window).height() * 0.8;
                var width = $(window).width() * 0.8;
            	$('#dialog').remove();
            	$('.box').prepend('<div id=\"dialog\" style=\"padding: 3px 0px 0px 0px;\"><iframe src=\"". Url::createAdminUrl("common/filemanager") ."&field=' + encodeURIComponent(field) + '\" style=\"padding:0; margin: 0; display: block; width: 100%; height: 100%;\" frameborder=\"no\" scrolling=\"auto\"></iframe></div>');
                
                $('#dialog').dialog({
            		title: '".$this->data['text_image_manager']."',
            		close: function (event, ui) {
            			if ($('#' + field).attr('value')) {
            				$.ajax({
            					url: '". Url::createAdminUrl("common/filemanager/image") ."',
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
            
        $this->scripts = array_merge($this->scripts,$scripts);
        
        // javascript files
        $jspath = defined("CDN_JS") ? CDN_JS : HTTP_JS;
        
        $javascripts[] = "js/vendor/ckeditor/ckeditor.js";
        
        $this->javascripts = array_merge($javascripts,$this->javascripts);
        
                
                
		$this->template = 'store/product_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
  	} 
	
  	/**
  	 * ControllerStoreProduct::validateForm()
  	 * 
     * @see User
     * @see Language
     * @see Request
  	 * @return bool
  	 */
  	private function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'store/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
        //TODO: colocar validaciones propias

    	foreach ($this->request->post['product_description'] as $language_id => $value) {
      		if ((strlen(utf8_decode($value['name'])) < 1) || (strlen(utf8_decode($value['name']))> 255)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
    	}
		
    	if ((strlen(utf8_decode($this->request->post['model'])) < 1) || (strlen(utf8_decode($this->request->post['model']))> 64)) {
      		$this->error['model'] = $this->language->get('error_model');
    	}
		
    	if (!$this->error) {
			return true;
    	} else {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_required_data');
			}
      		return false;
    	}
  	}
	
  	/**
  	 * ControllerStoreProduct::validateDelete()
  	 * 
     * @see User
     * @see Language
     * @see Request
  	 * @return bool
  	 */
  	private function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'store/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
        //TODO: colocar validaciones propias
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
  	
  	/**
  	 * ControllerStoreProduct::validateCopy()
  	 * 
     * @see User
     * @see Language
     * @see Request
  	 * @return bool
  	 */
  	private function validateCopy() {
    	if (!$this->user->hasPermission('modify', 'store/product')) {
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
        
        if (!$this->modelProduct->checkPlan()) {
            $this->error['warning'] = "No puede crear m&aacute;s productos, ha llegado al l&iacute;mite permitido para su cuenta.\nSi desea agregar m&aacute;s productos a su tienda debe comprar un plan superior";
        }
        //TODO: colocar validaciones propias
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
	
	/**
	 * ControllerStoreProduct::category()
	 * 
     * @see Load
     * @see Model
     * @see Response
     * @see Request
     * @see Language
	 * @return void
	 */
	public function category() {
		$this->load->auto('store/product');
		
		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}
		
		$product_data = array();
		
		$results = $this->modelProduct->getProductsByCategoryId($category_id);
		
		foreach ($results as $result) {
			$product_data[] = array(
				'product_id' => $result['product_id'],
				'name'       => $result['name'],
				'model'      => $result['model']
			);
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($product_data));
	}
	
	/**
	 * ControllerStoreProduct::related()
	 * 
     * @see Load
     * @see Model
     * @see Response
     * @see Request
     * @see Language
	 * @return void
	 */
	public function related() {
		$this->load->auto('store/product');
		
		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} else {
			$products = array();
		}
	
		$product_data = array();
		
		foreach ($products as $product_id) {
			$product_info = $this->modelProduct->getProduct($product_id);
			
			if ($product_info) {
				$product_data[] = array(
					'product_id' => $product_info['product_id'],
					'name'       => $product_info['name'],
					'model'      => $product_info['model']
				);
			}
		}
		
		$this->load->library('json');
		
		$this->response->setOutput(Json::encode($product_data));
	}
    
    
    /**
     * ControllerStoreCategory::activate()
     * activar o desactivar un objeto accedido por ajax
     * @return boolean
     * */
     public function activate() {
        if (!isset($_GET['id'])) return false;
        $this->load->auto('store/product');
        $status = $this->modelProduct->getProduct($_GET['id']);
        if ($status) {
            if ($status['status'] == 0) {
                $this->modelProduct->activate($_GET['id']);
                echo 1;
            } else {
                $this->modelProduct->desactivate($_GET['id']);
                echo -1;
            }
            
        } else {
            echo 0;
        }
     }
    
    /**
     * ControllerMarketingNewsletter::delete()
     * elimina un objeto
     * @return boolean
     * */
     public function delete() {
        $this->load->auto('store/product');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['selected'] as $id) {
                $this->modelProduct->delete($id);
            }
		} else {
            $this->modelProduct->delete($_GET['id']);
		}
     }
    
    /**
     * ControllerStoreCategory::sortable()
     * ordenar el listado actualizando la posición de cada objeto
     * @return boolean
     * */
     public function sortable() {
        if (!isset($this->request->post['tr'])) return false;
        $this->load->auto('store/product');
        $result = $this->modelProduct->sortProduct($this->request->post['tr']);
        if ($result) {
            echo 1;
        } else {
            echo 0;
        }
     }
     
  	/**
  	 * ControllerMarketingNewsletter::copy()
     * duplicar un objeto
  	 * @return boolean
  	 */
  	public function copy() {
        $this->load->auto('store/product');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            foreach ($this->request->post['selected'] as $id) {
                $this->modelProduct->copy($id);
            }
		} else {
            $this->modelProduct->copy($_GET['id']);
		}
        echo 1;
  	}
      
    public function import() {
         $this->document->title = $this->data['heading_title'] = "Importar Productos";
         
   		$this->document->breadcrumbs = array();
   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl("common/home"),
       		'text'      => $this->language->get('text_home'),
      		'separator' => false
   		);
   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl("store/product"),
       		'text'      => "Productos",
      		'separator' => ' :: '
   		);
   		$this->document->breadcrumbs[] = array(
       		'href'      => Url::createAdminUrl("store/product/import"),
       		'text'      => "Importar Productos",
      		'separator' => ' :: '
   		);
        
         $scripts[] = array('id'=>'form','method'=>'ready','script'=>
            "$('#gridWrapper').load('". Url::createAdminUrl("store/product/importwizard",array('step'=>1)) ."',function(e){
                $('#gridPreloader').hide();
                $('#q').on('keyup',function(e){
                    var that = this;
                    var valor = $(that).val().toLowerCase();
                    if (valor.length <= 0) {
                        $('#categoriesWrapper li').show();
                    } else {
                        $('#categoriesWrapper li b').each(function(){
                            if ($(this).text().toLowerCase().indexOf( valor ) != -1) {
                                $(this).closest('li').show();
                            } else {
                                $(this).closest('li').hide();
                            }
                        });
                    }
                }); 
                
            });");
                    
         $scripts[] = array('id'=>'importFunctions','method'=>'function','script'=>
            "function file_delete(field, preview) {
                $('#' + field).val('');
                $('#' + preview).parent('.row').find('.clear').remove();
                $('#' + preview).replaceWith('<a class=\"button\" id=\"'+ preview +'\" onclick=\"file_upload(\\'file_to_import\\', \\'preview\\');\">Seleccionar Archivo</a>');
            }
            
            function file_upload(field, preview) {
                var height = $(window).height() * 0.8;
                var width = $(window).width() * 0.8;
            	$('#dialog').remove();
            	$('#form').prepend('<div id=\"dialog\" style=\"padding: 3px 0px 0px 0px;\"><iframe src=\"". Url::createAdminUrl("common/filemanager") ."&field=' + encodeURIComponent(field) + '\" style=\"padding:0; margin: 0; display: block; width: 100%; height: 100%;\" frameborder=\"no\" scrolling=\"auto\"></iframe></div>');
                
                $('#dialog').dialog({
            		title: '".$this->data['text_image_manager']."',
            		close: function (event, ui) {
            			var csv = $('#' + field).val();
            			if (csv) {
            				$('#' + preview).replaceWith('<input type=\"text\" value=\"' + csv.replace('data/','') + '\" id=\"' + preview + '\" disabled=\"disabled\" /><div class=\"clear\"></div>');
            			}
            		},	
            		bgiframe: false,
            		width: width,
            		height: height,
            		resizable: false,
            		modal: false
            	});}");
                    
        $this->scripts = array_merge($this->scripts,$scripts);
         
        $this->template = 'store/product_import.tpl';
        $this->children = array(
            'common/header',	
        	'common/footer'	
        );
        		
        $this->response->setOutput($this->render(true), $this->config->get('config_compression')); 
    }
	
    public function importwizard() {
         $this->data['Url'] = new Url;
         switch((int)$_GET['step']) {
            case 1:
            default:
                $this->load->auto("store/category");
                $this->data['categories'] = $this->modelCategory->getCategories(0);
        		$this->template = 'store/product_import_1.tpl';
        		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
                break;
            case 2:
                $data    = unserialize(file_get_contents(DIR_CACHE . "temp_product_data.csv"));
                
                $handle  = fopen(DIR_IMAGE . $data['file'], "r+");
                $this->data['header'] = fgetcsv($handle, 1000, $data['separator'], $data['enclosure']);
                $this->data['fields']['Producto'] = array(
                        'product_id'    =>'Producto ID',
                        'model'         =>'Modelo',
                        'quantity'      =>'Catnidad',
                        'price'         =>'Precio',
                        'tax_class_id'  =>'Impuesto ID',
                        'sku'           =>'SKU',
                        'stock_status_id'=>'Stock Status ID',
                        'manufacturer_id'=>'Fabricante ID',
                        'date_available'=>'Fecha de Disponibilidad',
                        'weight'        =>'Peso',
                        'weight_class_id'=>'Unidad de Peso ID',
                        'minimum'       =>'Cantidad M&iacute;nima'
                    );
                $this->data['fields']['Descripciones'] = array(
                        'language_id'   =>'Idioma ID',
                        'name'          =>'Nombre del Producto',
                        'description'   =>'Descripci&oacute;n del Producto',
                        'meta_description'=>'Resumen',
                        'meta_keywords' =>'Palabras Claves'
                    );
                $this->data['fields']['Opciones'] = array(
                        'language_id'   =>'Idioma ID',
                        'option_id'     =>'Opci&oacute;n ID',
                        'option_name'   =>'Grupo de la Opci&oacute;n',
                        'option_label'  =>'Nombre de la Opci&oacute;n',
                        'option_quantity'=>'Cantidad de la Opci&oacute;n',
                        'option_price'  =>'Precio de la Opci&oacute;n',
                        'option_prefix' =>'Prefijo de la Opci&oacute;n'
                    );
        		$this->template = 'store/product_import_2.tpl';
        		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
                break;
            case 3:
        		$this->template = 'store/product_import_3.tpl';
        		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
                break;
         } 
    }
	
    public function importprocess() {
         switch($_GET['step']) {
            case 2:
                $data = array();
                if (isset($this->request->post['product_category'])) {
                    $data['product_categories'] = serialize($this->request->post['product_category']);
                }
                $data['file']       = ($this->request->post['file']) ? $this->request->post['file'] : '';
                $data['separator']  = ($this->request->post['separator']) ? $this->request->post['separator'] : ";";
                $data['enclosure']  = ($this->request->post['enclosure'] && $this->request->post['enclosure'] != '&quote;') ? $this->request->post['enclosure'] : '"';
                $data['escape']     = ($this->request->post['escape']) ? $this->request->post['escape'] : '\\';
                $data['update']     = (int)$this->request->post['update'];
                $data['header']     = (int)$this->request->post['header'];
                
                $handle     = fopen(DIR_IMAGE . $data['file'], "r+");
                $handle2    = fopen(DIR_CACHE . "temp_product_data.csv", "w+");
                $handle3    = fopen(DIR_CACHE . "temp_product_header.csv", "w+");
                fputcsv($handle3,(fgetcsv($handle, 1000, $data['separator'], $data['enclosure'])), $data['separator'], $data['enclosure']);
                fclose($handle3);
                
                fputs($handle2,serialize($data));
                fclose($handle2);
                
                fclose($handle);
                unset($handle,$handle2,$handle3);
                break;
            case 3:
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
                header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT"); 
                header("Cache-Control: no-cache, must-revalidate"); 
                header("Pragma: no-cache");
                header("Content-type: application/json");
        
                $return     = array();
                $data       = unserialize(file_get_contents(DIR_CACHE . "temp_product_data.csv"));
                $handle     = fopen(DIR_IMAGE . $data['file'], "r+");
                $handle2    = fopen(DIR_CACHE . "temp_product_header.csv", "r+");
                
                if ($data['header']) $header = fgetcsv($handle2, 1000, $data['separator'], $data['enclosure']);
                
                $keys   = array();
                if (!in_array('model',$this->request->post['Header'])) {
                    $return['error'] = 1;
                    $return['msg'] = "Debe seleccionar el campo correspondiente al modelo del producto, de lo contrario no se podr&aacute;n cargar los productos";
                }
                
                if (!$return['error']) {
                    $product = array(
                        'product_id',
                        'model',
                        'sku',
                        'location',
                        'quantity',
                        'stock_status_id',
                        'manufacturer_id',
                        'price',
                        'tax_class_id',
                        'date_available',
                        'weight',
                        'weight_class_id',
                        'minimum'
                    );
                    $descriptions = array(
                        'language_id',
                        'description',
                        'meta_description',
                        'meta_keywords',
                        'name'
                    );
                    $options = array(
                        'language_id',
                        'option_id',
                        'option_name',
                        'option_label',
                        'option_quantity',
                        'option_price',
                        'option_prefix'
                    );
                    
                    $d = $data;
                    $new = $updated = $bad = $total = 1;
                    $headers = $this->request->post['Header'];
                    while ($data = fgetcsv($handle, 1000, $d['separator'], $d['enclosure'])) {
                        $product_id = $model = $forceUpdate = null;
                        if ($data == $header && $d['header']) continue;
                        $return['total'] = $total++;
                        
                        if ($d['update']) {
                            $sql        = "UPDATE ". DB_PREFIX ."product SET ";
                            $sql_desc   = "UPDATE ". DB_PREFIX ."product_description SET ";
                            
                            $sql_options = "UPDATE ". DB_PREFIX ."product_option SET ";
                            $sql_options_value = "UPDATE ". DB_PREFIX ."product_option_value SET ";
                            $sql_options_description = "UPDATE ". DB_PREFIX ."product_option_descrption SET ";
                            $sql_options_value_description = "UPDATE ". DB_PREFIX ."product_option_value_description SET ";
                        } else {
                            $sql        = "INSERT INTO ". DB_PREFIX ."product SET ";
                            $sql_desc   = "INSERT INTO ". DB_PREFIX ."product_description SET ";
                            
                            $sql_options = "INSERT INTO ". DB_PREFIX ."product_option SET ";
                            $sql_options_value = "INSERT INTO ". DB_PREFIX ."product_option_value SET ";
                            $sql_options_description = "INSERT INTO ". DB_PREFIX ."product_option_descrption SET ";
                            $sql_options_value_description = "INSERT INTO ". DB_PREFIX ."product_option_value_description SET ";
                        }
                
                        foreach ($header as $key=>$col) { //$key = 0; $col = 'Nombre'
                            $data[$key] = preg_replace('/<\s*html.*?>/','',$data[$key]);
                            $data[$key] = preg_replace('/<\s*\/\s*html\s*.*?>/','',$data[$key]);
                            $data[$key] = preg_replace('@<head[^>]*?>.*?</head>@siu', '', $data[$key]);
                            $data[$key] = preg_replace('@<style[^>]*?>.*?</style>@siu', '', $data[$key]);
                            $data[$key] = preg_replace('@<script[^>]*?.*?</script>@siu', '', $data[$key]);
                            $data[$key] = preg_replace('@<object[^>]*?.*?</object>@siu', '', $data[$key]);
                            $data[$key] = preg_replace('@<embed[^>]*?.*?</embed>@siu', '', $data[$key]);
                            $data[$key] = preg_replace('@<applet[^>]*?.*?</applet>@siu', '', $data[$key]);
                            $data[$key] = preg_replace('@<iframe[^>]*?.*?</iframe>@siu', '', $data[$key]);
                            $data[$key] = preg_replace('@<noframes[^>]*?.*?</noframes>@siu', '', $data[$key]);
                            $data[$key] = preg_replace('@<noscript[^>]*?.*?</noscript>@siu', '', $data[$key]);
                            $data[$key] = preg_replace('@<noembed[^>]*?.*?</noembed>@siu', '', $data[$key]);
                            foreach ($headers as $column => $field) {//$column = 'Nombre'; $field = 'name'; <select name="Header[name]">
                                $col = str_replace(" ","_",$col);
                                
                                //TODO: validar cada campo de acuerdo a su tipo y longitud para evitar la insercion de datos basura
                                if (!empty($field) && $col == $column) {
                                    if (in_array($field,$product)) {
                                        $keys[$key] = $field;
                                        $sql .= "`$field`='". $this->db->escape($data[$key]) ."',";
                                    } elseif (in_array($field,$descriptions)) {
                                        $keys[$key] = $field;
                                        if ($field == 'language_id') {
                                            $language_id = (int)$data[$key];
                                        }
                                        $sql_desc .= "`$field`='". $this->db->escape($data[$key]) ."',";
                                        $hasDescription = true;
                                    } elseif (in_array($field,$options)) {
                                        $keys[$key] = $field;
                                        if ($field == 'option_id') {
                                            $option_id = (int)$data[$key];
                                        }
                                        if ($field == 'language_id') {
                                            $language_id = (int)$data[$key];
                                        }
                                        if ($field == 'language_id' || $field == 'option_name') {
                                            $sql_options_description .= "`". str_replace("option_","",$field) ."`='". $this->db->escape($data[$key]) ."',";
                                        }
                                        if ($field == 'option_quantity' || $field == 'option_price' || $field == 'option_prefix') {
                                            $sql_options_value .= "`". str_replace("option_","",$field) ."`='". $this->db->escape($data[$key]) ."',";
                                        }
                                        if ($field == 'option_label' || $field == 'language_id') {
                                            $sql_options_value_description .= "`". str_replace("option_label","name",$field) ."`='". $this->db->escape($data[$key]) ."',";
                                        }
                                        $hasOptions = true;
                                    }
                                }
                            }
                        } 
                    
                        $pid = array_search('product_id',$keys);
                        $idx = array_search('model',$keys);
                        
                        if (!array_search('date_added',$keys)) $sql .= "`date_added`=NOW(),";
                        if (!array_search('date_modified',$keys)) $sql .= "`date_modified`=NOW(),";
                        if (!array_search('language_id',$keys)) {
                            $sql_desc .= "`language_id`='1',";
                            $sql_options_description .= "`language_id`='1',";
                            $sql_options_value_description .= "`language_id`='1',";
                            $language_id = 1;
                        }
                        
                        $forceOptionUpdate = false;
                        if (!empty($option_id)) {
                            $res = $this->db->query("SELECT * FROM ".DB_PREFIX."product_option WHERE option_id='". (int)$option_id ."'");
                            if ($res->num_rows) {
                                $forceOptionUpdate = true;
                            }
                            
                            $sql_options_value .= "`option_id`='". (int)$option_id ."',";
                            $sql_options_description .= "`option_id`='". (int)$option_id ."',";
                            $sql_options_value_description .= "`option_id`='". (int)$option_id ."',";
                        }
                        
                        if (!$pid && !$idx) {
                            $return['error'] = 1;
                            $return['msg'] = "Debe especificar el modelo del producto";
                            break;
                        }
                        
                        if ($pid) { $product_id = (int)$data[$pid]; }
                        if ($idx) { $model = $data[$idx]; }
                        
                        $forceUpdate = false; 
                        if (!empty($product_id) && !empty($model)) {
                            $res = $this->db->query("SELECT * FROM ".DB_PREFIX."product WHERE product_id='". (int)$product_id ."' OR model='". $this->db->escape($model) ."'");
                            if ($res->num_rows && !$d['update']) {
                                continue;
                            } elseif ($res->num_rows && $d['update']) {
                                $forceUpdate = true;
                            }
                        } elseif (!empty($model)) {
                            $res = $this->db->query("SELECT * FROM ".DB_PREFIX."product WHERE model='". $this->db->escape($model) ."'");
                            if ($res->num_rows && !$d['update']) {
                                continue;
                            } elseif ($res->num_rows && $d['update']) {
                                $product_id = $res->row['product_id'];
                                $forceUpdate = true;
                            }
                        } elseif (!empty($product_id)) {
                            $res = $this->db->query("SELECT * FROM ".DB_PREFIX."product WHERE product_id='". (int)$product_id ."'");
                            if ($res->num_rows && !$d['update']) {
                                continue;
                            } elseif ($res->num_rows && $d['update']) {
                                $forceUpdate = true;
                            }
                        }
                        
                        $sql = substr($sql,0,(strlen($sql)-1));
                        $sql_desc = substr($sql_desc,0,(strlen($sql_desc)-1));
                        $sql_options = substr($sql_options,0,(strlen($sql_options)-1));
                        $sql_options_value = substr($sql_options_value,0,(strlen($sql_options_value)-1));
                        $sql_options_description = substr($sql_options_description,0,(strlen($sql_options_description)-1));
                        $sql_options_value_description = substr($sql_options_value_description,0,(strlen($sql_options_value_description)-1));
                    
                        if ($d['update']) {
                            if (!$forceUpdate) {
                                $sql = str_replace("UPDATE","INSERT INTO",$sql);
                                $insert = true;
                            } else {
                                $sql = str_replace("INSERT INTO","UPDATE",$sql) . " WHERE `product_id` = '". (int)$product_id ."'";
                            }
                            $result = $this->db->query($sql);
                            if (!$forceUpdate) $product_id = $this->db->getLastId();
                            
                            if (!$forceUpdate) {
                                $sql_desc .= ",`product_id`='". (int)$product_id ."'";
                                $sql_desc = str_replace("UPDATE","INSERT INTO",$sql_desc);
                                $insert = true;
                            } else {
                                $sql_desc = str_replace("INSERT INTO","UPDATE",$sql_desc) . " WHERE `product_id` = '". (int)$product_id ."' AND `language_id` = '". (int)$language_id ."'";
                            }
                            if (isset($hasDescription) && $result) $this->db->query($sql_desc);
                            
                            if ($product_id) {
                                $sql_options .= ",`product_id`='". (int)$product_id ."'";
                                $sql_options_value .= ",`product_id`='". (int)$product_id ."'";
                                $sql_options_description .= ",`product_id`='". (int)$product_id ."'";
                                $sql_options_value_description .= ",`product_id`='". (int)$product_id ."'";
                            }
                        
                            if (!$forceOptionUpdate) {
                                $sql_options = str_replace("UPDATE","INSERT INTO",$sql_options);
                                $sql_options_value = str_replace("UPDATE","INSERT INTO",$sql_options_value);
                                $sql_options_description = str_replace("UPDATE","INSERT INTO",$sql_options_description);
                                $sql_options_value_description = str_replace("UPDATE","INSERT INTO",$sql_options_value_description);
                            } else {
                                $sql_options = str_replace("INSERT INTO","UPDATE",$sql_options) . " WHERE `option_id` = '". (int)$option_id ."'";
                                $sql_options_value = str_replace("INSERT INTO","UPDATE",$sql_options_value) . " WHERE `option_id` = '". (int)$option_id ."'";
                                $sql_options_description = str_replace("INSERT INTO","UPDATE",$sql_options_description) . " WHERE `option_id` = '". (int)$option_id ."' AND `language_id` = '". (int)$language_id ."'";
                                $sql_options_value_description = str_replace("INSERT INTO","UPDATE",$sql_options_value_description) . " WHERE `option_id` = '". (int)$option_id ."' AND `language_id` = '". (int)$language_id ."'";
                            }
                            if (isset($hasOptions) && $result) $this->db->query($sql_options);
                            
                            if ($result && isset($insert)) {
                                $return['nuevo'] = $new++;
                            } elseif ($result && !isset($insert)) {
                                $return['updated'] = $updated++;
                            } else {
                                $return['bad'] = $bad++;
                            }
                        } else {
                            $result = $this->db->query($sql);
                            $product_id = $this->db->getLastId();
                                
                            if ($product_id) {
                                $sql_desc .= ",`product_id`='". (int)$product_id ."'";
                                $sql_options .= ",`product_id`='". (int)$product_id ."'";
                                $sql_options_value .= ",`product_id`='". (int)$product_id ."'";
                                $sql_options_description .= ",`product_id`='". (int)$product_id ."'";
                                $sql_options_value_description .= ",`product_id`='". (int)$product_id ."'";
                            }
                            
                            if (isset($hasDescription) && $result) {
                                $result_desc = $this->db->query($sql_desc);
                            }
                        
                            if (isset($hasOptions) && $result) {
                                $result_options = $this->db->query($sql_options);
                                $result_options = $this->db->query($sql_options_value);
                                $result_options = $this->db->query($sql_options_description);
                                $result_options = $this->db->query($sql_options_value_description);
                            }
                            
                            if ($result) {
                                $return['nuevo'] = $new++;
                            } else {
                                $return['bad'] = $bad++;
                            }
                        }
                        
                        //TODO: asociar las categorias a cada producto
                    }
                }
                unlink(DIR_CACHE . "temp_product_header.csv");
                unlink(DIR_CACHE . "temp_product_data.csv");
                unlink(DIR_CACHE . "temp_product_categories.csv");
                $this->load->library('json');
        		$this->response->setOutput(Json::encode($return), $this->config->get('config_compression'));
                break;
         } 
    }
	
}