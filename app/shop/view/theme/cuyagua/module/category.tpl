<!--CATEGORY WIDGET-->
<li data-widget="category" class="nt-editable widget-category categoryWidget<?php echo ($settings['class']) ? " ". $settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
	<?php if ($heading_title) { ?>
        <div class="heading widget-heading heading-dropdown" id="<?php echo $widgetName; ?>Header">
            <div class="heading-title">
                <h3>
                    <i class="heading-icon icon icon-folder-open">
                        <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/folder-open.tpl"); ?>
                    </i>
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
