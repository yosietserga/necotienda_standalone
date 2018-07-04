<li nt-editable="1" class="box richtextWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 

    <div class="widget-content" id="<?php echo $widgetName; ?>Content"><?php echo html_entity_decode($page['description']); ?></div>
</li>