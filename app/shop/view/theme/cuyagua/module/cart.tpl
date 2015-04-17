<li id="module_cart" class="nt-editable cart-widget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>">

<!-- cart-widget-title -->
    <?php if ($heading_title) { ?>
        <div class="heading widget-heading heading-dropdown" id="<?php echo $widgetname; ?>header">
            <div class="heading-title">
                <h3>
                    <i class="heading-icon icon icon-cart">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/cart.tpl"); ?>
                    </i>
                    <?php echo $heading_title; ?>
                </h3>
            </div>
        </div>
    <?php } ?>
<!-- /cart-widget-title -->

<!-- /cart-widget-content -->
    <div class="widget-content cart-widget-content" id="<?php echo $widgetName; ?>Content">
    <?php if ($products) { ?>
        <?php foreach ($products as $product) { ?>
        <div class="cartProduct">
            <span class="cartRemove" id="remove_<?php echo $product['key']; ?>"></span>
            <?php echo $product['quantity']; ?>x;
            <a title="<?php echo $product['name']; ?>" href="<?php echo str_replace('&', '&amp;', $product['href']); ?>">
                <?php echo substr($product['name'],0,30).'...'; ?>
            </a>
            <?php foreach ($product['option'] as $option) { ?>
                <div class="cartProductOption">- <?php echo $option['name']; ?> <?php echo $option['value']; ?></div>
            <?php } ?>
        </div>
        <?php } ?>

        <?php foreach ($totals as $total) { ?>
            <div class="cartWidgetTotal"><?php echo $total['title']; ?></div>
            <div class="cartWidgetTotal"><?php echo $total['text']; ?></div>
        <?php } ?>

        <div class="cartLinks">
            <a title="<?php echo $Language->get('text_view'); ?>" href="<?php echo $Url::createUrl('checkout/cart'); ?>">
                <i class="fa fa-shopping-cart"></i>
                <?php echo $Language->get('text_view'); ?>
            </a>
            <a title="<?php echo $Language->get('text_checkout'); ?>" href="<?php echo $Url::createUrl('checkout/confirm'); ?>">
                <i class="fa fa-cubes"></i>
                <?php echo $Language->get('text_checkout'); ?>
            </a>
        </div>
    <?php } else { ?>
        <div style="text-align: center;"><?php echo $text_empty; ?></div>
    <?php } ?>
  </div>
<!-- /cart-widget-content -->
</li>