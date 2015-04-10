<li class="nt-editable googleMapsWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

<!-- googlemap-widget-title -->
<?php if ($heading_title) { ?>
    <div class="heading widget-heading" id="<?php echo $widgetName; ?>Header">
        <div class="heading-title">
            <h3>
                <i class="icon heading-icon fa fa-map fa-2x"></i>
                <?php echo $heading_title; ?>
            </h3>
        </div>
    </div>
    <?php } ?>
<!-- /googlemap-widget-title -->

    <div class="googlemap-widget-content" id="<?php echo $widgetName; ?>Content">
    <?php echo $code; ?>
  </div>
</li>
