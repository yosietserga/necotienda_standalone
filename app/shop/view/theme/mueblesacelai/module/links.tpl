<!--WIDGET LINKS-->
<li data-component="dropdown" class="nt-editable widget-links<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName;?>">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 

    <div data-wrapper="dropdown">
        <div class="links-content widget-content" id="<?php echo $widgetName; ?>Content" data-dropdown="links"><?php echo $links; ?></div>
    </div>
</li>
<!--/WIDGET LINKS-->