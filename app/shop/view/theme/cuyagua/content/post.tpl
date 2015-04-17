<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <h1><?php echo $heading_title; ?></h1>
    <p><span><?php echo $Language->get('text_published') ." ". $date_added; ?></span></p>

    <div class="generic-page">
        <?php echo $description; ?>
    </div>

    <div id="postSocial" class="social-actions">
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/post-share-button.tpl"); ?>
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
<div id="fb-root"></div>
<script>
$(window).load(function(){
    <?php if ($related) { ?>
    $("#related").ntCarousel({
        url:'<?php echo $Url::createUrl("content/post/relatedJson") ."&post_id=". $post_id; ?>',
        image: {
          width:80,
          height:80  
        },
        loading: {
          image: '<?php echo HTTP_IMAGE; ?>loader.gif'
        },
        options: {
            scroll: 1
        }
    });
    <?php } ?>
    
    $('#review').load('<?php echo $Url::createUrl("content/post/review") ."&post_id=". $post_id; ?>');
    $('#comment').load('<?php echo $Url::createUrl("content/post/comment") ."&post_id=". $post_id; ?>');

});
</script>
<script src="<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/js/vendor/rrssb/js/rrssb.min.js'; ?>"></script>
<?php echo $footer; ?>