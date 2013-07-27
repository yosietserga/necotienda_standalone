<?php 
class ControllerCheckoutCart extends Controller {
	private $error = array();
	
	public function index() {
		$this->language->load('account/register');
		$this->language->load('checkout/cart');
		$this->load->model('localisation/country');
		$this->load->library('image');
		
        $this->session->set('redirect',Url::createUrl('checkout/cart'));
        
		if ($this->request->server['REQUEST_METHOD'] == 'GET' && isset($this->request->get['product_id'])) {
		
			if (isset($this->request->get['option'])) {
				$option = $this->request->get['option'];
			} else {
				$option = array();	
			}
			
			if (isset($this->request->get['quantity'])) {
				$quantity = $this->request->get['quantity'];
			} else {
				$quantity = 1;
			}
			
			$this->session->clear('shipping_methods');
			$this->session->clear('shipping_method');
			$this->session->clear('payment_methods');
			$this->session->clear('payment_method');
            
			$this->cart->add($this->request->get['product_id'], $quantity, $option);
			
			$this->redirect(Url::createUrl("checkout/cart"));
			
		}
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		
      		if (isset($this->request->post['quantity'])) {
				if (!is_array($this->request->post['quantity'])) {
					if (isset($this->request->post['option'])) {
						$option = $this->request->post['option'];
					} else {
						$option = array();	
					}
			
      				$this->cart->add($this->request->post['product_id'], $this->request->post['quantity'], $option);
				} else {
					foreach ($this->request->post['quantity'] as $key => $value) {
	      				$this->cart->update($key, $value);
					}
				}
				
    			$this->session->clear('shipping_methods');
    			$this->session->clear('shipping_method');
    			$this->session->clear('payment_methods');
    			$this->session->clear('payment_method');
      		}

			if (isset($this->request->post['redirect'])) {
				$this->session->set('redirect',$this->request->post['redirect']);
			}	
			
			$this->redirect(Url::createUrl("checkout/cart"));
                
    	}

    	$this->document->title = $this->data['heading_title'] = $this->language->get('heading_title');

      	$this->document->breadcrumbs = array();

      	$this->document->breadcrumbs[] = array(
        	'href'      => Url::createUrl("common/home"),
        	'text'      => $this->language->get('text_home'),
        	'separator' => false
      	); 

      	$this->document->breadcrumbs[] = array(
        	'href'      => Url::createUrl("checkout/cart"),
        	'text'      => $this->language->get('text_basket'),
        	'separator' => $this->language->get('text_separator')
      	);
        $this->data['breadcrumbs'] = $this->document->breadcrumbs;
    	if ($this->cart->hasProducts()) {
			
			$this->data['text_select']       = $this->language->get('text_select');
      		$this->data['text_sub_total']    = $this->language->get('text_sub_total');
			$this->data['text_discount']     = $this->language->get('text_discount');
			$this->data['text_weight']       = $this->language->get('text_weight');
		
     		$this->data['column_remove']     = $this->language->get('column_remove');
      		$this->data['column_image']      = $this->language->get('column_image');
      		$this->data['column_name']       = $this->language->get('column_name');
      		$this->data['column_model']      = $this->language->get('column_model');
      		$this->data['column_quantity']   = $this->language->get('column_quantity');
			$this->data['column_price']      = $this->language->get('column_price');
      		$this->data['column_total']      = $this->language->get('column_total');

        	$this->data['entry_email']       = $this->language->get('entry_email');
        	$this->data['entry_telephone']   = $this->language->get('entry_telephone');
        	$this->data['entry_company']     = $this->language->get('entry_company');
        	$this->data['entry_address_1']   = $this->language->get('entry_address_1');
        	$this->data['entry_postcode']    = $this->language->get('entry_postcode');
        	$this->data['entry_city']        = $this->language->get('entry_city');
        	$this->data['entry_country']     = $this->language->get('entry_country');
        	$this->data['entry_zone']        = $this->language->get('entry_zone');
        	$this->data['entry_rif']         = $this->language->get('entry_rif');

      		$this->data['button_shopping']   = $this->language->get('button_shopping');
      		$this->data['button_checkout']   = $this->language->get('button_checkout');
			
			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];			
			} elseif (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout')) {
      			$this->data['error_warning'] = $this->language->get('error_stock');
			} else {
				$this->data['error_warning'] = '';
			}
		
			$this->data['action'] = Url::createUrl('checkout/confirm');
			
      		$this->data['products'] = array();

      		foreach ($this->cart->getProducts() as $result) {
        		$option_data = array();
                
        		foreach ($result['option'] as $option) {
          			$option_data[] = array(
            			'name'  => $option['name'],
            			'value' => $option['value']
          			);
        		}

				if ($result['image']) {
					$image = $result['image'];
				} else {
					$image = 'no_image.jpg';
				}

        		$this->data['products'][] = array(
          			'key'      => $result['key'],
          			'name'     => $result['name'],
          			'model'    => $result['model'],
          			'thumb'    => NTImage::resizeAndSave($image, $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height')),
          			'option'   => $option_data,
          			'quantity' => $result['quantity'],
          			'stock'    => $result['stock'],
					'price'    => $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))),
					'total'    => $this->currency->format($this->tax->calculate($result['total'], $result['tax_class_id'], $this->config->get('config_tax'))),
					'href'     => Url::createUrl("store/product",array("product_id"=>$result['product_id']))
        		);
      		}
			
			if ($this->config->get('config_cart_weight')) {
				$this->data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class'));
			} else {
				$this->data['weight'] = false;
			}
			
      		$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
			 
			$this->load->model('checkout/extension');
			
			$sort_order = array(); 
			
			$results = $this->modelExtension->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				$this->load->model('total/' . $result['key']);

				$this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
			}
			
			$sort_order = array(); 
		  
			foreach ($total_data as $key => $value) {
      			$sort_order[$key] = $value['sort_order'];
    		}

    		array_multisort($sort_order, SORT_ASC, $total_data);

			$this->data['totals'] = $total_data;
			
			if ($this->session->has('message')) {
      			$this->data['message'] = $this->session->get('message');
				$this->session->clear('message');
			} 
            
			if ($this->session->has('redirect')) {
      			$this->data['continue'] = $this->session->get('redirect');
				
				$this->session->clear('redirect');
			} else {
				$this->data['continue'] = Url::createUrl("common/home");
			}
			
			$this->data['checkout'] = Url::createUrl("checkout/shipping");
			
        	$this->data['countries'] = $this->modelCountry->getCountries();
		
            if ($this->customer->isLogged()) {
                $this->data['email']    = $this->customer->getEmail();
                $this->data['company']  = $this->customer->getCompany();
                $this->data['telephone']= $this->customer->getTelephone();
                $this->data['rif_type'] = substr($this->customer->getRif(),0,1);
                $this->data['rif'] = substr($this->customer->getRif(),1);
                $this->data['isLogged'] = $this->customer->isLogged();
                
                $this->load->auto('account/address');
                $address = $this->modelAddress->getAddress($this->customer->getAddressId());
                if ($address) {
                    $this->data['payment_country_id'] = $address['country_id'];
                    $this->data['payment_zone_id']    = $address['zone_id'];
                    $this->data['payment_city']       = $address['city'];
                    $this->data['payment_address_1']  = $address['address_1'];
                    $this->data['payment_postcode']   = $address['postcode'];
                    $this->data['payment_address']    = $address['address_1'] .", ". $address['city'] .". ". $address['zone'] ." - ". $address['country'];
                    $this->session->set('payment_address_id',$this->customer->getAddressId());
                    
                    
                    $this->data['shipping_country_id'] = $address['country_id'];
                    $this->data['shipping_zone_id']    = $address['zone_id'];
                    $this->data['shipping_city']       = $address['city'];
                    $this->data['shipping_address_1']  = $address['address_1'];
                    $this->data['shipping_postcode']   = $address['postcode'];
                    $this->data['shipping_address']    = $address['address_1'] .", ". $address['city'] .". ". $address['zone'] ." - ". $address['country'];
                    $this->session->set('shipping_address_id',$this->customer->getAddressId());
                } else {
                    $this->data['no_address'] = true;
                }
                
                $this->tax->setZone($address['country_id'], $address['zone_id']);
		
            } else {
                $this->tax->setZone($this->config->get('config_country_id'), $this->config->get('config_zone_id'));
            }
            
            /******************** shipping methods ***********************/
    		$quote_data = array();
    		$results = $this->modelExtension->getExtensions('shipping');
    		foreach ($results as $result) {
  				$this->load->model('shipping/' . $result['key']);
    				
  				$quote = $this->{'model_shipping_' . $result['key']}->getQuote($address); 
    	
 				if ($quote) {
					$quote_data[$result['key']] = array(
    				    'title'      => $quote['title'],
    					'quote'      => $quote['quote'], 
    					'sort_order' => $quote['sort_order'],
    					'error'      => $quote['error']
					);
 				}
  			}
    	
  			$sort_order = array();
    		  
  			foreach ($quote_data as $key => $value) {
 				$sort_order[$key] = $value['sort_order'];
  			}
    	
  			array_multisort($sort_order, SORT_ASC, $quote_data);
    			
  			$this->session->set('shipping_methods',$quote_data);
            $this->data['shipping_methods'] = $quote_data;
            
            
            $script = "";
            // SCRIPTS
            if (!$this->customer->isLogged()) {
                $scripts[] = array('id'=>'custom_0_Cart','method'=>'ready','script'=>
                "$('#email').on('change',function(e){
                	$.post('". Url::createUrl("account/register/checkemail") ."', {email: $(this).val()},
                  		function(response){
                  		    $('#tempLink').remove();
                  		    var data = $.parseJSON(response);
                			if (typeof data.error != 'undefined') {
                				$('#email').removeClass('neco-input-success').addClass('neco-input-error');
                                $('#email').parent().find('.neco-form-error').attr({'title':\"Este email ya existe!\"});
                                $('#email').closest('.property').after('<p id=\"tempLink\" class=\"error\">'+ data.msg +'</p>');
                			} else {
                				$('#email').addClass('neco-input-success').removeClass('neco-input-error');
                                $('#email').parent().find('.neco-form-error').attr({'title':\"No hay errores en este campo\"});
                                $('#tempLink').remove();
                			}
                  	});
                });");
                
                //TODO: cargar los nombres de los paises y estados en la tabla de confirmacion
                $script = "if (!$('#email').attr('disabled')) { 
                    $.post('". Url::createUrl("account/register/register") ."', {
                        email: $('#email').val(),
                        company: $('#company').val(),
                        rif: $('#rif').val(),
                        telephone: $('#telephone').val(),
                        country_id: $('#payment_country_id').val(),
                        zone_id: $('#payment_zone_id').val(),
                        city: $('#payment_city').val(),
                        postcode: $('#payment_postcode').val(),
                        address_1: $('#payment_address_1').val(),
                    },
                    function(data) {
                        $.post('". Url::createUrl("checkout/cart/islogged") ."',function(data){
                            if (data) { 
                                $('#email').attr('disabled','disabled');
                                $('#company').attr('disabled','disabled');
                                $('#rif').attr('disabled','disabled');
                                $('#telephone').attr('disabled','disabled');
                                
                                $('#confirmCompany').text($('#company').val());
                                $('#confirmRif').text($('#rif').val());
                                var confirmPaymentAddress = $('#payment_address_1').val() +', '+ $('#payment_city').val() +'.';
                                $('#confirmPaymentAddress').text(confirmPaymentAddress);
                                
                                var confirmShippingAddress = $('#shipping_address_1').val() +', '+ $('#shipping_city').val() +'.';
                                $('#confirmShippingAddress').text(confirmShippingAddress);
                            }
                        });
                    });
                    }";
            } elseif ($this->customer->isLogged() && !$this->data['shipping_country_id']) {
                $script = 
                    "$.post('". Url::createUrl("account/register/addAddress") ."', {
                        country_id: $('#shipping_country_id').val(),
                        zone_id: $('#shipping_zone_id').val(),
                        city: $('#shipping_city').val(),
                        postcode: $('#shipping_postcode').val(),
                        address_1: $('#shipping_address_1').val(),
                    },
                    function(data) {
                        $('#payment_country_id').val($('#shipping_country_id').val());
                        $('#payment_zone_id').val($('#shipping_zone_id').val());
                        $('#payment_city').val($('#shipping_city').val());
                        $('#payment_postcode').val($('#shipping_postcode').val());
                        $('#payment_address_1').val($('#shipping_address_1').val());
                        
                        var confirmPaymentAddress = $('#shipping_address_1').val() +', '+ $('#shipping_city').val() +'.';
                        $('#confirmPaymentAddress').text(confirmPaymentAddress);
                                
                        var confirmShippingAddress = $('#shipping_address_1').val() +', '+ $('#shipping_city').val() +'.';
                        $('#confirmShippingAddress').text(confirmShippingAddress);
                    });";
            }
            
            $scripts[] = array('id'=>'scriptsCart','method'=>'ready','script'=>
            "$('#orderForm').ntForm({
                lockButton: false,
                cancelButton: false,
                submitButton: false
            });
            
            $('select[name=\'payment_zone_id\']').load('". Url::createUrl("account/register/zone") ."&country_id=". $address['country_id'] ."&zone_id=". $address['zone_id'] ."');
            $('select[name=\'shipping_zone_id\']').load('". Url::createUrl("account/register/zone") ."&country_id=". $address['country_id'] ."&zone_id=". $address['zone_id'] ."');
            $('#content').ntWizard({
                next:function(data) {
                    var stepId = $('.neco-wizard-step-active').attr('id');
                    $(data.element).find('.neco-wizard-next').text('Siguiente');
                    
                    if (stepId == 'necoWizardStep_1') {
                        $(this).find('.neco-wizard-next').text('". $this->data['button_checkout'] ."');
                        return false;
                    }
                    
                    if (stepId == 'necoWizardStep_2') {
                        var error = false;
                        var isLogged = ". (int)$this->customer->islogged() .";
                        var hasAddress = ". (int)$this->data['shipping_country_id'] .";
                        if (isLogged==0 || (isLogged && !hasAddress)) {
                            $('#email,#company,#rif,#telephone,#city,#postcode,#address_1').each(function(e){
                                var value    = !!$(this).val();
                                var required = $(this).attr('required');
                                var type     = $(this).attr('type');
                                var top      = $(this).offset().top;
                            
                                if (!value) {
                                    error = true;
                                    $(\"#tempError\").remove();
                                    msg = $(document.createElement('p')).attr('id','tempError').addClass('neco-submit-error').text('Debes rellenar todos los campos obligatorios identificados con asterisco (*)');
                                    $(this).removeClass('neco-input-success').addClass('neco-input-error')
                                        .parent()
                                            .find('.neco-form-error')
                                            .attr({'title':'Debes rellenar este campo con la informaci\u00F3n correspondiente'});
                                }
                                
                                var pattern = new RegExp(/.[\"\\\/\{\}\[\]\+']/i);
                                if (pattern.test($(this).val()) && !error) {
                                    error = true;
                                    $(\"#tempError\").remove();
                                    msg = $(document.createElement('p')).attr('id','tempError').addClass('neco-submit-error').text('No se permiten ninguno de estos caracteres especiales [\"#$/\'+}{\u003C\u003E] en este formulario');
                                    $(this).removeClass('neco-input-success').addClass('neco-input-error')
                                        .parent()
                                            .find('.neco-form-error')
                                            .attr({'title':'No se permiten ninguno de estos caracteres especiales [\"#$&/?\'+}{\u003C\u003E] en este campo'});
                                    top = $(this).offset().top;
                                }
                                
                                if (type == 'email' && $(this).val()=='@') {
                                    error = true;
                                    $(this).removeClass('neco-input-success').addClass('neco-input-error')
                                        .parent()
                                            .find('.neco-form-error')
                                            .attr({'title':'Debes ingresar una direcci\u00F3n de email v\u00E1lida'});
                                }
                            
                                        
                                if (type == 'email') {
                                    pattern = /^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.(([0-9]{1,3})|([a-zA-Z]{2,4})|(aero|coop|info|museum|name))$/i;
                                    $(this).on('change',function(event){
                                        err = checkPattern(pattern,$(this).val());
                                        
                                        if (!err) {
                                            $(this).removeClass('neco-input-success').addClass('neco-input-error');
                                            $(this).parent().find('.neco-form-error').attr({'title':\"Debes ingresar una direcci\u00F3n de email v\u00E1lida y que exista realmente\"});
                                            error = true;
                                        } else {
                                            $(this).parent().find('.neco-form-error').attr({'title':\"No hay errores en este campo\"});
                                            $(this).addClass('neco-input-success').removeClass('neco-input-error');
                                        }
                                    });
                                }
                                
                            
                                if (type == 'rif') {
                                    var pattern = /\b[JGVE]-[0-9]{8}-[0-9]{1}\b/i;
                                    $(this).on('change',function(event){
                                        err = checkPattern(pattern,$(this).val());
                                        
                                        if (!err) {
                                            $(this).parent().find('.neco-form-error').attr({'title':\"Debes ingresar un n\u00FAmero de C\u00E9dula o RIF v\u00E1lido para poder continuar\"});
                                            $(this).removeClass('neco-input-success').addClass('neco-input-error');
                                            error = true;
                                        } else {
                                            $(this).parent().find('.neco-form-error').attr({'title':\"No hay errores en este campo\"});
                                            $(this).addClass('neco-input-success').removeClass('neco-input-error');
                                        }
                                    });
                                }
                                
                            
                                if ($(this).hasClass('neco-input-error') && !error) {
                                    error = true;
                                    $(\"#tempError\").remove();
                                    msg = $(document.createElement('p')).attr('id','tempError').addClass('neco-submit-error').text('Hay errores en el formulario, por favor revise y corr\u00EDjalos todos para poder continuar');
                                }                        
                           
                            });
                            
                            if (!error) { ". $script ." }
                        } else {
                            var isChecked = $('input[name=shipping_method]:checked').val();
                            
                            if (!isChecked) {
                                error = true;
                                alert('Debes seleccionar un m\u00E9todo de env\u00EDo');
                            }
                        }
                        return error;
                    }
                    
                    if (stepId == 'necoWizardStep_3') {
                        var error = false;
                        var isLogged = ". (int)$this->customer->islogged() .";
                        if (isLogged==0) {
                            var isChecked = $('input[name=shipping_method]:checked').val();
                            
                            if (!isChecked) {
                                error = true;
                                alert('Debes seleccionar un m\u00E9todo de env\u00EDo');
                            }
                        } else {
                            $.post('". Url::createUrl("checkout/cart/process") ."',
                                $('#orderForm').serialize(),
                                    function(){
                                        location.href = '". $this->data['action'] ."';
                                    });
                        }
                        return error;
                    }
                    
                    if (stepId == 'necoWizardStep_4') {
                        var error = false;
                        var isLogged = ". (int)$this->customer->islogged() .";
                        if (isLogged==0) {
                            $.post('". Url::createUrl("checkout/cart/process") ."',
                                $('#orderForm').serialize(),
                                function(){
                                    location.href = '". $this->data['action'] ."';
                                });
                        }
                        return error;
                    }
                },
                prev:function(data) {
                    var stepId = $('.neco-wizard-step-active').attr('id');
                    if (stepId == 'necoWizardStep_2') {
                        $(this).find('.neco-wizard-next').text('". $this->data['button_checkout'] ."');
                    }
                    if (stepId == 'necoWizardStep_3') {
                        $('input').each(function(){ 
                            $(this).removeClass('neco-input-success'); 
                        });
                        
                            
                    }
                },
                create: function(e) {
                    $(e).find('.neco-wizard-next').text('". $this->data['button_checkout'] ."');
                }
            });
            $('input[name=shipping_method]').on('change',function(e){
                var tr = $('input[name=shipping_method]:checked').closest('tr');
                var title = tr.find('b:eq(0)').text();
                var price = tr.find('b:eq(1)').text();
                $('#shipping_method').html(title + ' ' + price);
            });
            ");
            
            $scripts[] = array('id'=>'functionsCart','method'=>'function','script'=>
            "function deleteCart(e,k) {
                $('#totals').html('<img src=\"". HTTP_IMAGE ."load.gif\" alt=\"Cargando...\" />'); 
                $(e).closest('tr').remove();
                $.getJSON('". Url::createUrl('checkout/cart/delete') ."',
                    {
                        key:k
                    },
                    function(data){
                        if (!data.error) { 
                            $('#weight').html(data.weight);
                            $('#totals').html(data.totals); 
                        } else { 
                            $('#cart').html(data.error); 
                            $('#weight').html('0.00kg');
                        } 
                    }
                );
            }
            function refreshCart(e,k) {
                $('#totals').html('<img src=\"". HTTP_IMAGE ."load.gif\" alt=\"Cargando...\" />'); 
                if (e.tagName != 'INPUT') {
                    e = $(e).prev('input');
                }
                var price = $(e).closest('tr').find('td:nth-child(6)');
                
                var values = price.text().split(',');
                values[0] = values[0].replace(/\D+/,'');
                var intValue = Number( values[0].replace(/[^0-9\.]+/g,'') );
                var floatValue = parseInt( Number( values[1].replace(/[^0-9\.]+/g,'') ) );
                price = parseFloat( intValue + '.' + floatValue );
                var totalValue = Math.round( (parseInt( $(e).val() ) * price) * 100) / 100;
                $(e).closest('tr').find('td:nth-child(7)').text('Bs. ' + totalValue );
                
                $.getJSON('". Url::createUrl('checkout/cart/refresh') ."',
                    {
                        key:k,
                        quantity:$(e).val()
                    },
                    function(data){
                        if (!data.error) { 
                            $('#weight').html(data.weight);
                            $('#totals').html(data.totals); 
                        } else { 
                            $('#cart').html(data.error); 
                            $('#weight').html('0.00kg');
                        } 
                    }
                );
            }
            function checkPattern(pat,value) {
                pattern = new RegExp(pat);
                return pattern.test(value);  
            }");
            
            $this->scripts = array_merge($this->scripts,$scripts);
            
            // javascript files
            $jspath = defined("CDN_JS") ? CDN_JS : HTTP_JS;
            
            $javascripts[] = $jspath."necojs/neco.form.js";
            $javascripts[] = $jspath."necojs/neco.wizard.js";
            $javascripts[] = $jspath."vendor/jquery-ui.min.js";
            $this->javascripts = array_merge($this->javascripts, $javascripts);

            // style files
            $csspath = defined("CDN") ? CDN.CSS : HTTP_CSS;
            
            $styles[] = array('media'=>'all','href'=>$csspath.'jquery-ui/jquery-ui.min.css');
            $styles[] = array('media'=>'all','href'=>$csspath.'neco.form.css');
            $styles[] = array('media'=>'all','href'=>$csspath.'neco.wizard.css');
            
            $this->data['styles'] = $this->styles = array_merge($this->styles,$styles);

            $this->load->helper('widgets');
            $widgets = new NecoWidget($this->registry,$this->Route);
            foreach ($widgets->getWidgets('main') as $widget) {
                $settings = (array)unserialize($widget['settings']);
                if ($settings['asyn']) {
                    $url = Url::createUrl("{$settings['route']}",$settings['params']);
                    $scripts[$widget['name']] = array(
                        'id'=>$widget['name'],
                        'method'=>'ready',
                        'script'=>
                        "$(document.createElement('div'))
                        .attr({
                            id:'".$widget['name']."'
                        })
                        .html(makeWaiting())
                        .load('". $url . "')
                        .appendTo('".$settings['target']."');"
                    );
                } else {
                    if (isset($settings['route'])) {
                        if ($settings['autoload']) $this->data['widgets'][] = $widget['name'];
                        $this->children[$widget['name']] = $settings['route'];
                        $this->widget[$widget['name']] = $widget;
                    }
                }
            }
            
            foreach ($widgets->getWidgets('featuredContent') as $widget) {
                $settings = (array)unserialize($widget['settings']);
                if ($settings['asyn']) {
                    $url = Url::createUrl("{$settings['route']}",$settings['params']);
                    $scripts[$widget['name']] = array(
                        'id'=>$widget['name'],
                        'method'=>'ready',
                        'script'=>
                        "$(document.createElement('div'))
                        .attr({
                            id:'".$widget['name']."'
                        })
                        .html(makeWaiting())
                        .load('". $url . "')
                        .appendTo('".$settings['target']."');"
                    );
                } else {
                    if (isset($settings['route'])) {
                        if ($settings['autoload']) $this->data['featuredWidgets'][] = $widget['name'];
                        $this->children[$widget['name']] = $settings['route'];
                        $this->widget[$widget['name']] = $widget;
                    }
                }
            }
            
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/checkout/cart.tpl')) {
				$this->template = $this->config->get('config_template') . '/checkout/cart.tpl';
			} else {
				$this->template = 'cuyagua/checkout/cart.tpl';
			}
			
    		$this->children[] = 'common/column_left';
    		$this->children[] = 'common/column_right';
    		$this->children[] = 'common/nav';
    		$this->children[] = 'common/header';
    		$this->children[] = 'common/footer';
            
			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));					
    	} else {
      		$this->data['heading_title'] = $this->language->get('heading_title');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = Url::createUrl("common/home");

            $this->load->helper('widgets');
            $widgets = new NecoWidget($this->registry,$this->Route);
            foreach ($widgets->getWidgets('main') as $widget) {
                $settings = (array)unserialize($widget['settings']);
                if ($settings['asyn']) {
                    $url = Url::createUrl("{$settings['route']}",$settings['params']);
                    $scripts[$widget['name']] = array(
                        'id'=>$widget['name'],
                        'method'=>'ready',
                        'script'=>
                        "$(document.createElement('div'))
                        .attr({
                            id:'".$widget['name']."'
                        })
                        .html(makeWaiting())
                        .load('". $url . "')
                        .appendTo('".$settings['target']."');"
                    );
                } else {
                    if (isset($settings['route'])) {
                        if ($settings['autoload']) $this->data['widgets'][] = $widget['name'];
                        $this->children[$widget['name']] = $settings['route'];
                        $this->widget[$widget['name']] = $widget;
                    }
                }
            }
            
            foreach ($widgets->getWidgets('featuredContent') as $widget) {
                $settings = (array)unserialize($widget['settings']);
                if ($settings['asyn']) {
                    $url = Url::createUrl("{$settings['route']}",$settings['params']);
                    $scripts[$widget['name']] = array(
                        'id'=>$widget['name'],
                        'method'=>'ready',
                        'script'=>
                        "$(document.createElement('div'))
                        .attr({
                            id:'".$widget['name']."'
                        })
                        .html(makeWaiting())
                        .load('". $url . "')
                        .appendTo('".$settings['target']."');"
                    );
                } else {
                    if (isset($settings['route'])) {
                        if ($settings['autoload']) $this->data['featuredWidgets'][] = $widget['name'];
                        $this->children[$widget['name']] = $settings['route'];
                        $this->widget[$widget['name']] = $widget;
                    }
                }
            }
            
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/error/not_found.tpl';
			} else {
				$this->template = 'cuyagua/error/not_found.tpl';
			}
			
    		$this->children[] = 'common/column_left';
    		$this->children[] = 'common/column_right';
    		$this->children[] = 'common/nav';
    		$this->children[] = 'common/header';
    		$this->children[] = 'common/footer';
            
			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));			
    	}
  	}
    
    protected function updateCart() {
        
		$this->load->auto('weight');
		$this->load->auto('cart');
		$this->load->auto('json');
		$this->load->auto('checkout/extension');
        $data = array();
        if ($this->cart->getProducts()) {
    		if ($this->config->get('config_cart_weight')) {
                $data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class'));
    		} else {
                $data['weight'] = false;
    		}
    			
            $total_data = array();
    		$total = 0;
    		$taxes = $this->cart->getTaxes();
    			 
    			
    		$sort_order = array(); 
    			
    		$results = $this->modelExtension->getExtensions('total');
    			
    		foreach ($results as $key => $value) {
                $sort_order[$key] = $this->config->get($value['key'] . '_sort_order');
    		}
    			
    		array_multisort($sort_order, SORT_ASC, $results);
    			
    		foreach ($results as $result) {
                $this->load->model('total/' . $result['key']);
                $this->{'model_total_' . $result['key']}->getTotal($total_data, $total, $taxes);
    		}
    		$sort_order = array(); 
    		foreach ($total_data as $key => $value) {
                $sort_order[$key] = $value['sort_order'];
    		}
    
        	array_multisort($sort_order, SORT_ASC, $total_data);
            $output = "";
    		foreach ($total_data as $value) {
                $output .= "<tr>";
                $output .= "<td><b>". $value['title'] ."</b></td>";
                $output .= "<td>". $value['text'] ."</td>";
                $output .= "</tr>";                    
    		}
            $data['totals'] = $output;
        } else {
            $data['error'] = "No hay productos en el carrito";
        }
		return Json::encode($data);	
		
    }
    
    public function process() {
        $shipping = explode('.', $this->request->post['shipping_method']);
        $this->session->set('shipping_method',$this->session->get('shipping_methods',$shipping[0],'quote',$shipping[1]));
        $this->session->set('payment_method',$this->session->get('payment_methods',$this->request->post['payment_method']));
    }
    
    public function refresh() {
        $this->cart->update($this->request->get['key'], $this->request->get['quantity']);
		$this->response->setOutput($this->updateCart(), $this->config->get('config_compression'));	
    }
    
    public function delete() {
        $this->cart->remove($_GET['key']);
		$this->response->setOutput($this->updateCart(), $this->config->get('config_compression'));	
    }
    
    public function islogged() {
        echo (int)$this->customer->islogged();
    }
}
