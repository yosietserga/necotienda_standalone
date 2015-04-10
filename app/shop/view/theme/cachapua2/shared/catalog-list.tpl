<?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
    <div class="catalog catalog-list" id="productsWrapper" itemscope itemtype="http://schema.org/Product">
        <ul>
            <?php foreach($products as $product) { ?>
                <li>
                    <!--CATALOG PICTURE-->
                    <figure class="picture">
                        <a href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>" class="thumb" title="<?php echo $product['name']; ?>">
                            <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="nt-lazyload" />
                        </a>
                        <a href="#" class="quick-view" onclick="return quickView('product', '<?php echo $product['product_id']; ?>');"><?php echo $Language->get('text_quick_view'); ?>
                        </a>
                    </figure>
                    <!--/CATALOG PICTURE-->

                    <!--CATALOG INFO-->
                    <div class="info nt-hoverdir">
                        <div class="product-info">
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/sticker.tpl"); ?>
                            <?php if ($product['rating']) { ?>
                                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/rating.tpl"); ?>
                            <?php }else { ?>
                                <div style="min-height: 1.063em; width: 100%;" itemprop="aggregateRating"itemscope itemtype="http://schema.org/AggregateRating" class="rating placeholder" id="productAverage"></div>
                            <?php } ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/name.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/model.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/overview.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/description.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/product/price.tpl"); ?>
                        </div>
                        <div class="actions">
                            <div class="action-button action-see" data-action="see-product">
                                <a title="<?php echo $button_see_product; ?>" href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>"><?php echo $Language->get('button_see_product'); ?></a>
                            </div>

                            <div class="action-button action-add" data-action="add-product">
                                <?php if ($Config->get('config_store_mode')=='store') { ?>
                                    <a title="<?php echo $Language->get('button_add_to_cart'); ?>" <?php if (!$this->config->get("cart_ajax")) { ?>onclick="window.location.href = '<?php echo $Url::createUrl('checkout/cart',array('product_id'=>$product['product_id'])); ?>'"<?php } else { ?>onclick="addToCart('<?php echo $product['product_id']; ?>')"<?php } ?>><?php echo $Language->get('button_add_to_cart'); ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!--/CATALOG INFO-->
                </li>
            <?php } ?>
        </ul>
    </div>
<?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
<script>
    $(function () {
        if (!$.fn.elevateZoom) {
            elevateZoomScript = document.createElement("script");
            elevateZoomScript.async = true;
            elevateZoomScript.src = "<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/js/vendor/elevatezoom/jquery.elevateZoom-3.0.8.min.js'; ?>";
            document.body.appendChild(elevateZoomScript);
        }
    });
</script>