<!--latest-widget -->
<?php if ($products) { ?>
<li class="nt-editable widget-latest latestWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

    <!--latest-widget-title -->
    <?php if ($heading_title) { ?>
    <div class="heading widget-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
        <div class="heading-title">
            <h3>
                <i class="icon heading-icon fa fa-send fa-2x"></i>
                <?php echo $heading_title; ?>
            </h3>
        </div>
    </div>
    <?php } ?>
    <!-- /latest-widget-title -->

    <!-- latest-widget-content -->
    <div class="widget-content latest-content" id="<?php echo $widgetName; ?>Content">
        <?php foreach ($products as $product) { ?>
            <div class="article row">
                <figure class="picture large-6 medium-3 small-4 columns">
                    <a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" class="thumb">
                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                    </a>
                </figure>
                <div class="info large-6 medium-6 small-8 columns">
                    <div class="rating">
                        <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" />
                    </div>
                    <a class="name" title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>">
                        <?php echo $product['name']; ?>
                    </a>
                    <p class="overview overview hide-for-small-only hide-for-large-only"><?php echo substr($product['overview'],0,80)." ... "; ?>
                        <a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>">Leer M&aacute;s</a>
                    </p>

                    <?php if ($display_price && $Config->get('config_store_mode')=='store') { ?>
                        <?php if (!$product['special']) { ?>
                            <em class="price">
                                <?php echo $product['price']; ?>
                            </em>
                        <?php } else { ?>
                            <em class="new-price"><?php echo $product['special']; ?></em>
                            <em class="old-price"><?php echo $product['price']; ?></em>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- /latest-widget-content -->

</li>
<?php } ?>
<!-- /latest-widget -->
