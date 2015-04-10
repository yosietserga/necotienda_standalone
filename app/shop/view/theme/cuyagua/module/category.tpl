<!--CATEGORY WIDGET-->
<li class="nt-editable widget-category categoryWidget<?php echo ($settings['class']) ? " ". $settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
	<?php if ($heading_title) { ?>
        <div class="heading widget-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
            <div class="heading-title">
                <h3>
                    <i class="icon heading-icon fa fa-bookmark fa-2x"></i>
                    <?php echo $heading_title; ?>
                </h3>
            </div>
        </div>
        <?php } ?>
    <div class="widget-content sidebar-list" id="<?php echo $widgetName; ?>Content">
        <?php echo $category; ?>
    </div>
</li>
<!--/CATEGORY WIDGET-->
