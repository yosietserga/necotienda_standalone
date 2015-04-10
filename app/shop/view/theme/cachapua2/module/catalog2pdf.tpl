<li class="nt-editable catalogtopdf-widget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
<!-- cart-widget-title -->
    <?php if ($heading_title) { ?>
        <div class="heading widget-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
            <div class="heading-title">
                <h3>
                    <i class="icon heading-shopping-cart fa fa-star fa-2x"></i>
                    <?php echo $heading_title; ?>
                </h3>
            </div>
        </div>
    <?php } ?>
<!-- /cart-widget-title -->

<!-- cart-widget-content -->
    <div class="widget-content catalogtopdf-widget-content" id="<?php echo $widgetName; ?>Content">
        <a href="<?php echo str_replace("&","&amp;",$href); ?>" title="<?php echo $Language->get('text_download_pdf'); ?>" class="button"><?php echo $Language->get('text_download_pdf'); ?></a>
    </div>
<!-- /cart-widget-content -->
</li>
