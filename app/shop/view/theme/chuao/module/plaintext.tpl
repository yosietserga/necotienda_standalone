<li nt-editable="1" class="plaintextWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

  <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>

  <div class="content" id="<?php echo $widgetName; ?>Content">
    <p><?php echo $settings['text']; ?></p>
  </div>
</li>