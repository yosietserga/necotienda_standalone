<!--CATEGORY WIDGET-->
<li data-widget="category" class="nt-editable widget-category categoryWidget<?php echo ($settings['class']) ? " ". $settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>"> 
  <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 

  <div class="widget-content sidebar-list" id="<?php echo $widgetName; ?>Content">
      <?php echo $category; ?>
  </div>
</li>
<!--/CATEGORY WIDGET-->
