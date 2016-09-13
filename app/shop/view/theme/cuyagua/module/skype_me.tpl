<li class="nt-editable skypeme-widget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 

    <div class="widget-content" id="<?php echo $widgetName; ?>Content">
        <?php echo $skype_me; ?>
    </div>
</li>
