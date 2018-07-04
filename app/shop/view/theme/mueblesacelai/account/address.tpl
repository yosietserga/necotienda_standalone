<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

        <form class="simple-form" action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/country.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/zone.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/city.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/postcode.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/address.tpl"); ?>

            <div class="entry-default-address form-entry">
                <label for="address_1"><?php echo $Language->get('text_label_check_address'); ?></label>
                <input type="checkbox" id="default" name="default" value="1"<?php if ($default) { ?> checked="checked"<?php } ?> title="Seleccione si desea utilizar esta direcci&oacute;n como predeterminada" />
            </div>
            <input type="hidden" name="company" value="<?php echo $company; ?>" />
            <input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
            <input type="hidden" name="lastname" value="<?php echo $lastname; ?>" />
            <div class="necoform-actions" data-actions="necoform"></div>
        </form>
        
    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>

</section>
<script type="text/javascript">
    window.deferjQuery(function () {
        $('#zone_id').load('index.php?r=account/address/zone&country_id=<?php echo $country_id; ?>&zone_id=<?php echo $zone_id; ?>');
    });
</script>
<?php echo $footer; ?>