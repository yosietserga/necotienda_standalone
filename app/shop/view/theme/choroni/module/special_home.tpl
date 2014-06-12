<?php if($products) { ?>
<li class="nt-editable box specialWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
<?php if ($heading_title) { ?><div class="header" id="<?php echo $widgetName; ?>Header"><hgroup><h1><?php echo $heading_title; ?></h1></hgroup></div><?php } ?>
    
    <?php if ($sorts) { ?>
    <div class="sort">
        <select name="sort" onchange="window.location.href = this.value">
            <?php foreach ($sorts as $sorted) { ?>
            <option value="<?php echo $sorted['href']; ?>"<?php if (($sort . '-' . $order) == $sorted['value']) { ?> selected="selected"<?php } ?>><?php echo $sorted['text']; ?></option>
            <?php } ?>
        </select>

        <a class="view_style" onclick="if ($('#<?php echo $widgetName; ?>List').hasClass('list_view')) { $('#<?php echo $widgetName; ?>List').removeClass('list_view').addClass('grid_view'); } else { $('#<?php echo $widgetName; ?>List').removeClass('grid_view').addClass('list_view'); }  $(this).toggleClass('view_style_grid');">&nbsp;</a>
    </div> 
    <?php } ?>

    <div class="clear"></div>
    
    <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
    
    <div class="clear"></div>

    <div class="list_view" id="<?php echo $widgetName; ?>List">
        <ul>
        <?php foreach($products as $product) { ?>
            <li>
                <a href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>" class="thumb" title="<?php echo $product['name']; ?>">
                    <img src="<?php echo HTTP_IMAGE; ?>data/preloader.gif" data-original="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="nt-lazyload" />
                </a>
                <div class="product_info nt-hoverdir">
                    <?php echo $product['sticker']; ?>
                    <a href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>" title="<?php echo $product['name']; ?>" class="name"><?php echo $product['name']; ?></a>

                    <?php if ($product['rating']) { ?><img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" /><?php } ?>

                    <p class="model"><?php echo $product['model']; ?></p>

                    <p class="overview"><?php echo substr($product['overview'],0,150)." ... "; ?><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>">Leer M&aacute;s</a></p>

                    <div class="description"><?php echo $product['description']; ?></div>

                    <p class="price"><?php echo $product['price']; ?></p>

                    <a title="<?php echo $button_see_product; ?>" class="button_see_small" href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>"><?php echo $Language->get('button_see_product'); ?></a>

                    <?php if ($Config->get('config_store_mode')=='store') { ?>
                    <a title="<?php echo $Language->get('button_add_to_cart'); ?>" class="button_add_small" <?php if (!$this->config->get("cart_ajax")) { ?>onclick="window.location.href = '<?php echo $Url::createUrl('checkout/cart',array('product_id'=>$product['product_id'])); ?>'"<?php } else { ?>onclick="addToCart('<?php echo $product['product_id']; ?>')"<?php } ?>><?php echo $Language->get('button_add_to_cart'); ?></a>
                    <?php } ?>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>

    <div class="clear"></div>
    
    <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
    
    <div class="clear"></div><br />
</li>
<script>
$(function() {
    $("#<?php echo $widgetName; ?>List img").lazyload();
});
</script>
<?php } ?>