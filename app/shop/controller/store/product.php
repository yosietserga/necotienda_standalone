<?php  class ControllerStoreProduct extends Controller {
	private $error = array(); 
	public $product_id;
	public function index() { 
		$this->document->breadcrumbs = array();
		$this->document->breadcrumbs[] = array(
			'href'      => Url::createUrl('store/home'),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);
		
		if (isset($this->request->get['path'])) {
			$path = '';
			foreach (explode('_', $this->request->get['path']) as $path_id) {
				$category_info = $this->modelCategory->getCategory($path_id);
				$path .= (!$path) ? $path_id : '_' . $path_id;
				if ($category_info) {
					$this->document->breadcrumbs[] = array(
						'href'      => $this->modelSeo_url->rewrite(Url::createUrl('store/category',array('path'=>$path))),
						'text'      => $category_info['name'],
						'separator' => $this->language->get('text_separator')
					);
				}
			}
		}
		
		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_info = $this->modelManufacturer->getManufacturer($this->request->get['manufacturer_id']);
			if ($manufacturer_info) {	
				$this->document->breadcrumbs[] = array(
					'href'	    => $this->modelSeo_url->rewrite(Url::createUrl('store/manufacturer',array('manufacturer_id'=>$this->request->get['manufacturer_id']))),
					'text'	    => $manufacturer_info['name'],
					'separator' => $this->language->get('text_separator')
				);
			}
		}
		
		if (isset($this->request->get['keyword'])) {
			$url = '';
			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}
			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}
			$this->document->breadcrumbs[] = array(
				'href'      => Url::createUrl('store/search','&keyword=' . $this->request->get['keyword'] . $url),
				'text'      => $this->language->get('text_search'),
				'separator' => $this->language->get('text_separator')
			);	
		}
		
		$this->product_id = $product_id = isset($this->request->get['product_id']) ? $this->request->get['product_id'] : $product_id = 0;
		$product_info = $this->modelProduct->getProduct($product_id);
		
		if ($product_info) {
			$url = '';
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}
			if (isset($this->request->get['keyword'])) {
				$url .= '&keyword=' . $this->request->get['keyword'];
			}
			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}
			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}						
			$this->document->breadcrumbs[] = array(
				'href'      => $this->modelSeo_url->rewrite(Url::createUrl('store/product',$url . '&product_id=' . $this->request->get['product_id'])),
				'text'      => $product_info['name'],
				'separator' => $this->language->get('text_separator')
			);			
			
			$this->document->title = $product_info['name'];
			$this->document->keywords = $product_info['meta_keywords'];
			$this->document->description = $product_info['meta_description'];
			$this->document->links = array();
			$this->document->links[] = array(
				'href' => $this->modelSeo_url->rewrite(Url::createUrl('store/product',array('product_id'=>$this->request->get['product_id']))),
				'rel'  => 'canonical'
			);

			$this->data['heading_title']     = $product_info['name'];
			$this->data['text_enlarge']      = $this->language->get('text_enlarge');
			$this->data['text_discount']     = $this->language->get('text_discount');
			$this->data['text_options']      = $this->language->get('text_options');
			$this->data['text_price']        = $this->language->get('text_price');
			$this->data['text_availability'] = $this->language->get('text_availability');
			$this->data['text_model']        = $this->language->get('text_model');
			$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$this->data['text_order_quantity'] = $this->language->get('text_order_quantity');
			$this->data['text_price_per_item'] = $this->language->get('text_price_per_item');
			$this->data['text_qty']          = $this->language->get('text_qty');
			$this->data['text_write']        = $this->language->get('text_write');
			$this->data['text_average']      = $this->language->get('text_average');
			$this->data['text_no_rating']    = $this->language->get('text_no_rating');
			$this->data['text_note']         = $this->language->get('text_note');
			$this->data['text_no_images']    = $this->language->get('text_no_images');
			$this->data['text_no_related']   = $this->language->get('text_no_related');
			$this->data['text_wait']         = $this->language->get('text_wait');
			$this->data['text_tags']         = $this->language->get('text_tags');
			$this->data['text_minimum']      = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
			$this->data['entry_name']        = $this->language->get('entry_name');
			$this->data['entry_review']      = $this->language->get('entry_review');
			$this->data['entry_rating']      = $this->language->get('entry_rating');
			$this->data['entry_good']        = $this->language->get('entry_good');
			$this->data['entry_bad']         = $this->language->get('entry_bad');
			$this->data['entry_captcha']     = $this->language->get('entry_captcha');
			$this->data['button_continue']   = $this->language->get('button_continue');
			
			$average = ($this->config->get('config_review')) ? $this->modelReview->getAverageRating($this->request->get['product_id']) : $average = false;

			$this->data['review_status'] = $this->config->get('config_review');
			$this->data['text_stars']    = sprintf($this->language->get('text_stars'), $average);
			$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');
			$this->data['action']        = Url::createUrl('checkout/cart');
			$this->data['redirect']      = Url::createUrl('store/product',$url . '&product_id=' . $this->request->get['product_id']);

			$image = isset($product_info['image']) ? $product_info['image'] : $image = 'no_image.jpg';
			$this->data['popup']=NTImage::resizeAndSave($image, $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height'));
			$this->data['thumb']=NTImage::resizeAndSave($image, $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height'));

            $imgProduct = array(
                'popup'  => NTImage::resizeAndSave($image, $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
                'preview'=> NTImage::resizeAndSave($image, $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
                'thumb'  => NTImage::resizeAndSave($image, $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
            );

			$this->data['product_info'] = $product_info;
			
			$discount = $this->modelProduct->getProductDiscount($this->request->get['product_id']);
			
			if ($discount) {
				$this->data['price'] = $this->currency->format($this->tax->calculate($discount, $product_info['tax_class_id'], $this->config->get('config_tax')));
				$this->data['special'] = false;
			} else {
				$this->data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				$special = $this->modelProduct->getProductSpecial($this->request->get['product_id']);
			
				if ($special) {
					$this->data['special'] = $this->currency->format($this->tax->calculate($special, $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$this->data['special'] = false;
				}
			}
			
			$discounts = $this->modelProduct->getProductDiscounts($this->request->get['product_id']);
			$this->data['discounts'] = array(); 
			
			foreach ($discounts as $discount) {
				$this->data['discounts'][] = array(
					'quantity' => $discount['quantity'],
					'price'    => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')))
				);
			}
			
			if ($product_info['quantity'] <= 0) {
				$this->data['stock'] = $product_info['stock'];
			} else {
				if ($this->config->get('config_stock_display')) {
					$this->data['stock'] = $product_info['quantity'];
				} else {
					$this->data['stock'] = $this->language->get('text_instock');
				}
			}
			
			if ($product_info['minimum']) {
				$this->data['minimum'] = $product_info['minimum'];
			} else {
				$this->data['minimum'] = 1;
			}
			
			$this->data['model']         = $product_info['model'];
			$this->data['manufacturer']  = $product_info['manufacturer'];
			$this->data['manufacturers'] = $this->modelSeo_url->rewrite(Url::createUrl('store/manufacturer',array('manufacturer_id'=>$product_info['manufacturer_id'])));
			$this->data['description']   = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
			$this->data['product_id']    = $this->request->get['product_id'];
			$this->data['average']       = $average;
			$this->data['options']       = array();
			
			$options = $this->modelProduct->getProductOptions($this->request->get['product_id']);
			
			foreach ($options as $option) { 
				$option_value_data = array();
				foreach ($option['option_value'] as $option_value) {
					$option_value_data[] = array(
						'option_value_id' => $option_value['product_option_value_id'],
						'name'            => $option_value['name'],
						'price'           => (float)$option_value['price'] ? $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax'))) : false,
						'prefix'          => $option_value['prefix']
					);
				}
				
				$this->data['options'][] = array(
					'option_id'    => $option['product_option_id'],
					'name'         => $option['name'],
					'option_value' => $option_value_data
				);
			}
			
			$this->data['images'] = array();
			$results = $this->modelProduct->getProductImages($this->request->get['product_id']);
			
			foreach ($results as $k => $result) {
				$this->data['images'][$k] = array(
					'popup' => NTImage::resizeAndSave($result['image'] , $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					'preview' => NTImage::resizeAndSave($result['image'], $this->config->get('config_image_thumb_width'), $this->config->get('config_image_thumb_height')),
					'thumb' => NTImage::resizeAndSave($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
				);
			}
            $k = count($this->data['images']) + 1;
            $this->data['images'][$k] = $imgProduct;
            
			if (!$this->config->get('config_customer_price')) {
				$this->data['display_price'] = true;
			} elseif ($this->customer->isLogged()) {
				$this->data['display_price'] = true;
			} else {
				$this->data['display_price'] = false;
			}
            
			$customer_id = ($this->customer->isLogged()) ? $this->session->get('customer_id') : $customer_id = 0;
			
			$this->modelProduct->updateViewed($this->request->get['product_id'],$customer_id);
			
			$this->data['tags'] = array();
					
			$results = $this->modelProduct->getProductTags($this->request->get['product_id']);
			
			foreach ($results as $result) {
				if ($result['tag']) {
					$this->data['tags'][] = array(
						'tag'	=> $result['tag'],
						'href'	=> Url::createUrl('store/search',array('keyword'=>$result['tag']))
					);
				}
			}
			
            // style files
            $csspath = defined("CDN") ? CDN_CSS : HTTP_THEME_CSS;
            
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/common/header.tpl')) {
    		  $csspath = str_replace("%theme%",$this->config->get('config_template'),$csspath);
    		} else {
    		  $csspath = str_replace("%theme%","default",$csspath);
    		}
            
            if (fopen($csspath.str_replace('controller','',strtolower(__CLASS__) . '.css'),'r')) {
                $styles[] = array('media'=>'all','href'=>$csspath.str_replace('controller','',strtolower(__CLASS__) . '.css'));
            }
            
            if (count($styles)) {
                $this->data['styles'] = $this->styles = array_merge($this->styles,$styles);
            }
            
            if ($hasFeatured) {
                //TODO: obtener los sliders si están asignados a este producto
                $this->children[] = 'common/showslider';
            }
            
            if (!$hasColumnLeft) {
                //TODO: obtener si este template tiene columna izquierda, entonces cargar hijo
                $this->children[] = 'common/column_left';
            }
            
            if ($hasColumnRight) {
                //TODO: obtener si este template tiene columna derecha, entonces cargar hijo
                $this->children[] = 'common/column_right';
            }
            
    		$this->children[] = 'common/header';
    		$this->children[] = 'common/nav';
    		$this->children[] = 'common/footer';
            
            //TODO: obtener el layout configurado y utilizarlo como template
            
            $template = ($this->config->get('config_product_layout')) ? $this->config->get('config_product_layout') : 'product';
            
   			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/'. $template .'.tpl')) {
  				$this->template = $this->config->get('config_template') . '/store/'. $template .'.tpl';
   			} else {
  				$this->template = 'default/store/'. $template .'.tpl';
   			}
   			
			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
		} else {
		  //TODO: forward to error/not_found
			$url = '';
			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}
			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
			}
			if (isset($this->request->get['keyword'])) {
				$url .= '&keyword=' . $this->request->get['keyword'];
			}
			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}
			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}	
      		$this->document->breadcrumbs[] = array(
        		'href'      => $this->modelSeo_url->rewrite(Url::createUrl('store/product',$url . '&product_id=' . $product_id)),
        		'text'      => $this->language->get('text_error'),
        		'separator' => $this->language->get('text_separator')
      		);			
		
      		$this->document->title      = $this->language->get('text_error');
      		$this->data['heading_title']= $this->language->get('text_error');
      		$this->data['text_error']   = $this->language->get('text_error');
      		$this->data['button_continue'] = $this->language->get('button_continue');
      		$this->data['continue']     = Url::createUrl('store/home');
	  
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/error/not_found.tpl';
			} else {
				$this->template = 'default/error/not_found.tpl';
			}
			
    		$this->children = array(
    			'common/header',
    			'common/nav',
    			'common/column_left',
    			'common/column_right',
    			'common/footer'
    		);
            
			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    	}
  	}
	
	public function review() {
		$this->data['text_no_reviews'] = $this->language->get('text_no_reviews');
		$page = isset($this->request->get['page']) ? $this->request->get['page'] : $page = 1;
		$this->data['reviews'] = array();
		$results = $this->modelReview->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);
		foreach ($results as $result) {
        	$this->data['reviews'][] = array(
        		'author'     => $result['author'],
				'rating'     => $result['rating'],
				'text'       => strip_tags($result['text']),
        		'stars'      => sprintf($this->language->get('text_stars'), $result['rating']),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
		
		$review_total = $this->modelReview->getTotalReviewsByProductId($this->request->get['product_id']);
			
		$pagination = new Pagination();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = Url::createUrl('store/product/review',array('product_id'=>$this->request->get['product_id'],'page'=>'{page}'));
			
		$this->data['pagination'] = $pagination->render();
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/review.tpl')) {
			$this->template = $this->config->get('config_template') . '/store/review.tpl';
		} else {
			$this->template = 'default/store/review.tpl';
		}
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
	
	public function comment() {
		$this->data['review_status']  = $this->config->get('config_review');
		$this->data['text_stars']     = sprintf($this->language->get('text_stars'), $average);
		$this->data['entry_name']     = $this->language->get('entry_name');
		$this->data['entry_review']   = $this->language->get('entry_review');
		$this->data['entry_rating']   = $this->language->get('entry_rating');
		$this->data['entry_good']     = $this->language->get('entry_good');
		$this->data['entry_bad']      = $this->language->get('entry_bad');
		$this->data['entry_captcha']  = $this->language->get('entry_captcha');
        $this->data['button_continue']= $this->language->get('button_continue');
		$this->data['text_wait']         = $this->language->get('text_wait');
        
        // evitando ataques xsrf y xss
        $fid = ($this->session->has('fid')) ? $this->session->get('fid') : strtotime(date('d-m-Y h:i:s'));$this->session->set('fid',$fid);
        $fkey = $this->fkey . "." . $this->session->get('fid') . "_" . str_replace('/','-',$_GET['r']);
        $this->data['fkey'] = "<input type='hidden' name='fkey' id='fkey' value='$fkey' />";
        
        $scripts[] = array(
            'id'=>'productComment',
            'method'=>'ready',
            'script'=>"$('.star_review').on(\"hover\",
                    function() {
                        var idThis = $(this).attr('id');
                        $('.star_review').each (function() {
                            var idStar = $(this).attr('id');
                            if (idStar <= idThis) {
                                $(this).css({'backgroundPosition':'left top'});
                            }
                        });
                    },
                    function() {
                        $('.star_review').each (function() {
                            $(this).css({'backgroundPosition':'right top'});
                        });
                    }
                );
                $('.detail a').click(function() {
                    var idThis = $(this).attr('id');
                    $('input[name=rating]').val(idThis);
                    $('.detail a').each (function() {
                        var idStar = $(this).attr('id');
                        if (idStar <= idThis) {
                            $(this).removeClass();
                            $(this).addClass('star_clicked');
                            $(this).css({'backgroundPosition':'left top'});
                        } else {
                            $(this).removeClass();
                            $(this).addClass('star_review');
                            $(this).css({'backgroundPosition':'right top'});
                        }
                    });
                });");
        $scripts[] = array(
            'id'=>'productReviewWrite',
            'method'=>'function',
            'script'=>"function review() {
            	$.ajax({
            		type: 'POST',
            		url: '".HTTP_HOME."index.php?r=store/product/write&product_id=".$this->request->getQuery('product_id')."',
            		dataType: 'json',
            		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()) + '&fkey=' + encodeURIComponent($('#fkey').val()),
            		beforeSend: function() {
            			$('.success, .warning').remove();
            			$('#review_button').attr('disabled', 'disabled');
            			$('#review_title').after('<div class=\"wait\"><img src=\"image/loading_1.gif\" alt=\"\">".$this->data['text_wait']."</div>');
            		},
            		complete: function() {
            			$('#review_button').attr('disabled', '');
            			$('.wait').remove();
            		},
            		success: function(data) {
            			if (data.error) {
            				$('#review_title').after('<div class=\"warning\">' + data.error + '</div>');
            			}
            			if (data.success) {
            				$('#review_title').after('<div class=\"success\">' + data.success + '</div>');
            				$('input[name=\'name\']').val('');
            				$('textarea[name=\'text\']').val('');
            				$('input[name=\'rating\']:checked').attr('checked', '');
            				$('input[name=\'captcha\']').val('');
            			}
            		}
            	});
            }");
                    
        $this->scripts = array_merge($this->scripts,$scripts);
            
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/comment.tpl')) {
			$this->template = $this->config->get('config_template') . '/store/comment.tpl';
		} else {
			$this->template = 'default/store/comment.tpl';
		}
		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}
	
	public function write() {
		$product_id = $this->product_id;
		$json = array();
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $fid = substr($_POST['fkey'],strpos($_POST['fkey'],".")+1,10); // verificamos que id del formulario es correcto
            $date = substr($this->fkey,strpos($this->fkey,"_")+1,10); // verificamos que la fecha es de hoy
            if (($this->session->get('fkey')==$this->fkey) && ($fid==$this->session->get('fid')) && ($date==strtotime(date('d-m-Y')))) { // validamos el id de sesión para evitar ataques csrf
                $this->session->clear('fid');                    
        			
    			$this->model_catalog_review->addReview($product_id, $this->request->post);
    			
    			$json['success'] = $this->language->get('text_success');
            }
		} else {
			$json['error'] = $this->error['message'];
		}
		$this->load->library('json');
		$this->response->setOutput(Json::encode($json));
	}
	
    public function related() {
        $this->load->language("store/related");      
        $this->load->model("catalog/product");
        $results = $this->modelProduct->getProductRelated($this->request->get['product_id']);
        require_once(DIR_CONTROLLER . "store/product_array.php");
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/store/products_grid.tpl')) {
			$this->template = $this->config->get('config_template') . '/store/products_grid.tpl';
		} else {
			$this->template = 'default/store/products_grid.tpl';
		}
        $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
    }

	private function validate() {
		if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name']))> 25)) {
			$this->error['message'] = $this->language->get('error_name');
		}
		
		if ((strlen(utf8_decode($this->request->post['text'])) < 25) || (strlen(utf8_decode($this->request->post['text']))> 1000)) {
			$this->error['message'] = $this->language->get('error_text');
		}

		if (!$this->request->post['rating']) {
			$this->error['message'] = $this->language->get('error_rating');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
