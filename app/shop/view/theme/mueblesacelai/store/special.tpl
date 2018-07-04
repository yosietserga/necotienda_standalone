<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-heading.tpl");?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcrumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>

    <div id="products"><img src='<?php echo HTTP_IMAGE; ?>data/loader.gif' alt='Cargando...' /></div>

        <!-- widgets -->
        <div class="large-12 medium-12 small-12 columns">
            <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
        </div>
        <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>

    </section>

<script>
    (function () {
        window.deferjQuery(function () {
            $("#products").load("index.php?r=store/special/home<?php echo $url; ?>")
        });
    })();
</script>
<?php echo $footer; ?>