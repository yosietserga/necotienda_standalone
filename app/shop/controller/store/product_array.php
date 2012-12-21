<?php

/**
 * @author Yosiet Serga
 * @copyright 2011
 * @package NecoTienda
 */

		$this->load->auto('catalog/review');
      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['button_see_product'] = $this->language->get('button_see_product');
		$this->data['button_add_to_cart'] = $this->language->get('button_add_to_cart');
		$this->data['products'] = array();
			
		foreach ($results as $result) {
		    $image = !empty($result['image']) ? $result['image'] : 'no_image.jpg';

			if ($this->config->get('config_review')) {
				$rating = $this->modelReview->getAverageRating($result['product_id']);	
			} else {
				$rating = false;
			}

			$special = false;
			$discount = $this->modelProduct->getProductDiscount($result['product_id']);
			
			if ($discount) {
				$price = $this->currency->format($this->tax->calculate($discount, $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				$special = $this->modelProduct->getProductSpecial($result['product_id']);
				if ($special) {
					$special = $this->currency->format($this->tax->calculate($special, $result['tax_class_id'], $this->config->get('config_tax')));
				}						
			}
						
			$options = $this->modelProduct->getProductOptions($result['product_id']);
			
			if ($options) {
				$add = $this->modelSeo_url->rewrite(Url::createUrl('store/product',array('product_id'=>$result['product_id'])));
			} else {
				$add = Url::createUrl('checkout/cart',array('product_id'=>$result['product_id']));
			}
			$this->load->auto('image');
			$this->data['products'][] = array(
				'product_id'    => $result['product_id'],
				'name'    		=> $result['name'],
				'model'   		=> $result['model'],
				'overview'   	=> $result['meta_description'],
				'rating'  		=> $rating,
				'stars'   		=> sprintf($this->language->get('text_stars'), $rating),
				'price'   		=> $price,
				'options'   	=> $options,
				'special' 		=> $special,
				'image'   		=> NTImage::resizeAndSave($image, 38, 38),
				'thumb'   		=> NTImage::resizeAndSave($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
				'href'    		=> $this->modelSeo_url->rewrite(Url::createUrl('store/product',array('product_id'=>$result['product_id']))),
				'add'    		=> $add
			);
		}

		if (!$this->config->get('config_customer_price')) {
			$this->data['display_price'] = true;
		} elseif ($this->customer->isLogged()) {
			$this->data['display_price'] = true;
		} else {
			$this->data['display_price'] = false;
		}