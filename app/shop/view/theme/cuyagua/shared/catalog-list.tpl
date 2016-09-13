<?php if ($pagination) { ?>
<div class="pagination"><?php echo $pagination; ?></div>
<?php } ?>
    <div class="catalog catalog-grid" id="productsWrapper" itemscope itemtype="http://schema.org/Product">
        <ul>
            <?php foreach($products as $product) { ?>
                <li class="catalog-item">
                    <!--CATALOG PICTURE-->
                    <!--<?php echo $product['thumb']; ?>-->
                    <figure class="picture">
                        <a href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>" class="thumb" title="<?php echo $product['name']; ?>">
                            <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="nt-lazyload" />
                        </a>
                        <a href="javascript:;" class="quick-view" onclick="quickView('product', '<?php echo $product['product_id']; ?>', this);"><?php echo $Language->get('text_quick_view'); ?></a>
                    </figure>
                    <!--/CATALOG PICTURE-->

                    <!--CATALOG INFO-->
                    <div class="info nt-hoverdir">
                        <?php if ($product['rating']) { ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/rating.tpl"); ?>
                        <?php }else { ?>
                            <div style="min-height: 1.063em; width: 100%;" class="rating" id="productAverage"></div>
                        <?php } ?>
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/name.tpl"); ?>
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/model.tpl"); ?>
                        <?php if ($product['overview'] !== null || !empty($product['overview']) ) { ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/overview.tpl"); ?>
                        <?php }?>
                        <?php if ($product['description'] !== null || !empty($product['description']) ) { ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/description.tpl"); ?>
                        <?php }?>
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/price.tpl"); ?>

                        <?php if (!empty($product['attributes'])) { ?>
                        <div class="product-attributes-wrapper">
                            <div class="product-attributes nt-editable">
                                <?php foreach ($product['attributes'] as $key => $attr) { ?>
                                <h3><?php echo $attr['title']; ?></h3>
                                <?php foreach ($attr['items'] as $k => $attribute) { ?>
                                <div class="row">
                                    <div class="small-6 medium-6 large-6 columns"><?php echo $attribute['label']; ?></div>
                                    <div class="small-6 medium-6 large-6 columns"><?php echo $attribute['value']; ?></div>
                                </div>
                                <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>

                        <?php if ($Config->get('config_store_mode') === 'store') { ?>
                            <div class="group group--btn" role="group">
                                <!--<div class="btn btn--detail" data-action="see-product">
                                    <a title="<?php echo $button_see_product; ?>" href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>"><?php echo $Language->get('button_see_product'); ?></a>
                                </div>-->
                            <div class="btn btn-add btn--secondary" data-action="addToCart" role="button" aria-label="AddToCart">
                                <a title="<?php echo $Language->get('button_add_to_cart'); ?>" <?php if (!$this->config->get("cart_ajax")) { ?>onclick="window.location.href = '<?php echo $Url::createUrl('checkout/cart',array('product_id'=>$product['product_id'])); ?>'"<?php } else { ?>onclick="addToCart('<?php echo $product['product_id']; ?>')"<?php } ?>><?php echo $Language->get('button_add_to_cart'); ?></a>
                            </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!--/CATALOG INFO-->
                </li>
            <?php } ?>
        </ul>
    </div>
<?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/scripts/quickview-deps.tpl"); ?>
