<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    <section id="maincontent" class="row">
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

        <span class="error-content"><?php echo $text_error; ?></span>

       <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
    </section>
</div>
<?php echo $footer; ?>