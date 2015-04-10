<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
        <h1><?php echo $heading_title; ?></h1>
        <?php if ($description) { ?><p><?php echo $description; ?></p><?php } ?>
        <?php if (!$products) { ?><div class="content"><?php echo $Language->get('text_error'); ?></div><?php } ?>

        <?php if($products) { ?>
        <div id="products">
            <?php if ($sorts) { ?>
            <div class="sort">
                <a class="view_style" onclick="if ($('#productsWrapper').hasClass('list_view')) { $('#productsWrapper').removeClass('list_view').addClass('grid_view'); $(this).find('i').removeClass('fa-th-list').addClass('fa-th-large'); } else { $('#productsWrapper').removeClass('grid_view').addClass('list_view'); $(this).find('i').removeClass('fa-th-large').addClass('fa-th-list'); }">
                    <i class="fa fa-th-list fa-2x"></i>
                </a>
            </div>
            <?php } ?>
            <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
            <div class="list_view" id="productsWrapper">
                <ul>
                <?php foreach($products as $product) { ?>
                <li>
                    <a href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>" class="thumb" title="<?php echo $product['name']; ?>">
                        <img src="<?php echo HTTP_IMAGE; ?>data/preloader.gif" data-original="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="nt-lazyload" />
                        <a href="#" class="quick_view_button" onclick="return quickView('product', '<?php echo $product['product_id']; ?>');"><?php echo $Language->get('text_quick_view'); ?></a>
                    </a>
                    <div class="product_info nt-hoverdir">
                        <?php echo $product['sticker']; ?>

                        <a href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>" title="<?php echo $product['name']; ?>" class="name"><?php echo $product['name']; ?></a>

                        <?php if ($product['rating']) { ?><img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" /><?php } ?>

                        <p class="model"><?php echo $product['model']; ?></p>

                        <p class="overview"><?php echo substr($product['overview'],0,150)." ... "; ?><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>">Leer M&aacute;s</a></p>

                        <div class="description"><?php echo $product['description']; ?></div>

                        <?php if ($display_price && $Config->get('config_store_mode')=='store') { ?>
                        <p class="price"><?php echo $product['price']; ?></p>
                        <?php } ?>

                        <a title="<?php echo $button_see_product; ?>" class="button_see_small" href="<?php echo $Url::createUrl('store/product',array('product_id'=>$product['product_id'])); ?>">
                            <i class="fa fa-rocket"></i>&nbsp;
                            <?php echo $Language->get('button_see_product'); ?>
                        </a>

                        <?php if ($Config->get('config_store_mode')=='store') { ?>
                        <a title="<?php echo $Language->get('button_add_to_cart'); ?>" class="button_add_small" <?php if (!$this->config->get("cart_ajax")) { ?>onclick="window.location.href = '<?php echo $Url::createUrl('checkout/cart',array('product_id'=>$product['product_id'])); ?>'"<?php } else { ?>onclick="addToCart('<?php echo $product['product_id']; ?>')"<?php } ?>>
                            <i class="fa fa-shopping-cart"></i>&nbsp;
                            <?php echo $Language->get('button_add_to_cart'); ?>
                        </a>
                        <?php } ?>

                    </div>
                </li>
            <?php } ?>
            </ul>
        </div>
        <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
        <script>
        $(function() {
            $("#productsWrapper img").lazyload();
        });
        </script>
        <?php } ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>