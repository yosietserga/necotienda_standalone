<li nt-editable="1" class="product_overview-widget<?php echo ($settings['class']) ? ' '. $settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php if ($heading_title) echo '<h2>'. $heading_title .'</h2>'; ?>
    <div itemprop="description" id="<?php echo $widgetName; ?>_productOverview">
        <p><?php echo $overview; ?></p>
    </div>
</li>