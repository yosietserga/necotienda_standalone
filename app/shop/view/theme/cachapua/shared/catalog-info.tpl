<!-- catalog-info -->
<div class="info nt-hoverdir">

    <div class="sticker">
        <?php echo $product['sticker']; ?>
    </div>

    <?php if ($product['rating']) { ?>
        <div class="rating">
            <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" />
        </div>
    <?php }else { ?>
        <div class="rating" style="min-height: 1.063em; width: 100%;">
        </div>
    <?php }?>

    <a href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>" title="<?php echo $product['name']; ?>" class="name">
        <?php echo $product['name']; ?>
    </a>

    <p class="model">
        <?php echo $product['model']; ?>
    </p>

    <p class="overview"><?php echo substr($product['overview'],0,150)." ... "; ?><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>">Leer M&aacute;s</a></p>

    <div class="description description"><?php echo $product['description']; ?></div>

    <?php if ($display_price && $Config->get('config_store_mode')=='store') { ?>
        <p class="price"><?php echo $product['price']; ?></p>
    <?php } ?>
    <div class="actions">
        <div class="action-button action-see" data-action="see-product">
            <a title="<?php echo $button_see_product; ?>" href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>"><?php echo $Language->get('button_see_product'); ?></a>
        </div>
        <div class="action-button action-add" data-action="add-product">
            <?php if ($Config->get('config_store_mode')=='store') { ?>
                <a title="<?php echo $Language->get('button_add_to_cart'); ?>" class="action-add" <?php if (!$this->config->get("cart_ajax")) { ?>onclick="window.location.href = '<?php echo $Url::createUrl('checkout/cart',array('product_id'=>$product['product_id'])); ?>'"<?php } else { ?>onclick="addToCart('<?php echo $product['product_id']; ?>')"<?php } ?>><?php echo $Language->get('button_add_to_cart'); ?></a>
            <?php } ?>
        </div>
    </div>
</div>
<!-- /catalog-info -->