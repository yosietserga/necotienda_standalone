<!--latest-widget -->
<?php if ($products) { ?>
<li class="nt-editable widget-latest latestWidget<?php echo ($settings['class']) ? ' ' .$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>

    <!-- latest-widget-content -->
    <div class="widget-content latest-content" id="<?php echo $widgetName; ?>Content">
        <?php foreach ($products as $product) { ?>
        <div class="article row">
            <figure class="picture large-5 medium-3 small-3 columns">
                <a title="<?php echo $prodjct['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" class="thumb">
                    <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                </a>
            </figure>

            <div class="info large-7 medium-9 small-9 columns">
                <a class="name" title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>">
                    <?php echo $product['name']; ?>
                </a>

                <p class="overview overview hide-for-small-only hide-for-large-up">
                    <?php echo substr($product['overview'],0,80)." ... "; ?>
                    <a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>">Leer M&aacute;s</a>
                </p>
                <?php if ($Config->get('config_store_mode') === 'store') { ?>
                <?php if ($display_price && $Config->get('config_store_mode')=='store') { ?>
                <?php if (!$product['special']) { ?>
                <em class="price">
                    <?php echo $product['price'];?>
                </em>
                <?php } else { ?>
                <div class="prices">
                    <em class="old-price"><?php echo $product['price']; ?></em>
                    <em class="new-price"><?php echo $product['special']; ?></em>
                    <em class="reduction-percentage">
                        <?php
            $v1 = filter_var($product['special'], FILTER_SANITIZE_NUMBER_INT) / 100;
            $v2 = filter_var($product['price'], FILTER_SANITIZE_NUMBER_INT) / 100;
            echo round((( $v1 - $v2 ) / (($v1 + $v2) / 2)) * 100, 0) . '%';
            ?>
                    </em>
                </div>
                <?php } ?>
                <?php } ?>
                <?php if ($product['rating']) { ?>
                <div class="rating">
                    <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" />
                </div>
                <?php }else { ?>
                <div class="rating" style="min-height: 1.063em; width: 100%;"></div>
                <?php }?>
                <?php } ?>

                <?php if ($Config->get('config_store_mode') === 'store') { ?>
                <div class="group group--btn" role="group">
                    <div class="btn btn-detail" data-action="see-product">
                        <a title="<?php echo $button_see_product; ?>" href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>"><?php echo $Language->get('button_see_product'); ?></a>
                    </div>
                    <div class="btn btn-add btn--secondary" data-action="addToCart" role="button" aria-label="AddToCart">
                        <?php if ($Config->get('config_store_mode')=='store') { ?>
                        <a title="<?php echo $Language->get('button_add_to_cart'); ?>" class="action-add" <?php if (!$this->config->get("cart_ajax")) { ?>onclick="window.location.href = '<?php echo $Url::createUrl('checkout/cart',array('product_id'=>$product['product_id'])); ?>'"<?php } else { ?>onclick="addToCart('<?php echo $product['product_id']; ?>')"<?php } ?>><?php echo $Language->get('button_add_to_cart'); ?></a>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <!-- /latest-widget-content -->
</li>
<?php } ?>
<!-- /latest-widget -->
