<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

    <span><?php echo $Language->get('text_published') ." ". $date_added; ?></span>

    <div class="generic-page">

        <?php echo $description; ?>
        
        <!-- widgets -->
        <div class="large-12 medium-12 small-12 columns">
            <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
        </div>
        <!-- widgets -->

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

<div id="fb-root"></div>
<script>
$(function(){
    ntPlugins = window.ntPlugins || [];

    ntPlugins.push({
        id:'#related',
        config:{
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
        },
        plugin:'ntCarousel'
    });
    window.ntPlugins = ntPlugins;
    
    $('#review').load('<?php echo $Url::createUrl("store/review") ."&object_type=post&object_id=". $post_id; ?>');
    $('#comment').load('<?php echo $Url::createUrl("store/review/comment") ."&object_type=post&object_id=". $post_id; ?>');
});
</script>
<?php echo $footer; ?>