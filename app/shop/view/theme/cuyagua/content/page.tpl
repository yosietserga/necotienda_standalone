<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

    <div class="generic-page">
        <?php echo $description; ?>
    </div>

    <div id="postSocial" class="social-actions">
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-share-button.tpl"); ?>
    </div>

    <?php if ($allow_reviews) { ?>
    <div id="comments">
        <div id="comment" class="box nt-editable"><img src='<?php echo HTTP_IMAGE; ?>data/loader.gif' alt='Cargando...' /></div>
        <div id="review" class="content nt-editable"><img src='<?php echo HTTP_IMAGE; ?>data/loader.gif' alt='Cargando...' /></div>
    </div>
    <?php } ?>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>

</section>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>necojs/neco.carousel.js"></script>

<script>
(function() {
    window.deferjQuery(function () {
        window.appendScriptSource("<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/js/vendor/rrssb/js/rrssb.min.js'; ?>");
    });
})();
<?php echo $footer; ?>