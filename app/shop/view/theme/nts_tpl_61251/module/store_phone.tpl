<li nt-editable="1" class="store-phone-widget<?php echo ($settings['class']) ? ' '. $settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>
    <i class="fa fa-phone"></i>
    <a href="tel:<?php echo $telephone;?>"><?php echo $telephone;?></a>
</li>