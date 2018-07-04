<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

    <div id="products">
        <?php if($products) { ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/sort.tpl"); ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-list.tpl"); ?>
        <?php } else { ?>
        <div class="content"><?php echo $Language->get('Products Not Found'); ?></div>
        <?php } ?>
    </div>

    <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>

</section>
<?php echo $footer; ?>