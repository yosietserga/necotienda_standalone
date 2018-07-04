<li nt-editable="1" class="product_stock-widget<?php echo ($settings['class']) ? ' '. $settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <div itemprop="availability" href="http://schema.org/InStock" id="<?php echo $widgetName; ?>_productAvailability">
        <?php echo $heading_title; ?>
        <span><?php echo $stock; ?></span>
    </div>
</li>