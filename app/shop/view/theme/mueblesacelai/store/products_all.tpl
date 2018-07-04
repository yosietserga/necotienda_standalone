<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-heading.tpl");?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcrumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>

    <?php if ($description) { ?><p><?php echo $description; ?></p><?php } ?>
    <?php if (!$products) { ?><div class="content"><?php echo $Language->get('text_error'); ?></div><?php } ?>

    <?php if($products) { ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/sort.tpl"); ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-list.tpl"); ?>
    <?php } ?>
    
        <!-- widgets -->
        <div class="large-12 medium-12 small-12 columns">
            <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
        </div>
        <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>