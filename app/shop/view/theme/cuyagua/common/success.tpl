<?php echo $header; ?>
<?php echo $navigation; ?>

<section id="maincontent" class="row">
    <?php include_once(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include_once(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <?php include_once(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/messages.tpl"); ?>

    <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>

    <?php include_once(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>

</section>
<?php echo $footer; ?>