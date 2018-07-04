<?php echo $header; ?>
<?php echo $navigation; ?>

<!-- section-categories -->
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcrumbs.tpl");?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl");?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl");?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-heading.tpl");?>

    <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<!-- /section-categories -->
<?php echo $footer; ?>