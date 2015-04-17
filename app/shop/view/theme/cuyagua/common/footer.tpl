<!-- footer/underbottom -->
<footer class="underbottom">
    <section class="row">
        <ul class="underbottom-widgets widgets">
            <?php if ($widgets) {
                foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}
            <?php } } ?>
        </ul>
    </section>
</footer>
<!-- footer/underbottom -->

<!-- terms -->
<section class="terms">
    <div class="row">
        <div class="large-7 medium-7 small-12 columns">
            <ul id="links" class="nt-editable site-links">
                <li>
                    <a href="<?php echo HTTP_HOME; ?>" title="<?php echo $Language->get('text_home'); ?>">
                        <?php echo $Language->get('text_home'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $Url::createUrl('store/special'); ?>" title="<?php echo $Language->get('text_special'); ?>">
                        <?php echo $Language->get('text_special'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $Url::createUrl('checkout/cart'); ?>" title="<?php echo $Language->get('text_cart'); ?>">
                        <?php echo $Language->get('text_cart'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createUrl('page/sitemap'); ?>" title="<?php echo $Language->get('text_sitemap'); ?>">
                        <?php echo $Language->get('text_sitemap'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $Url::createUrl('page/contact'); ?>" title="<?php echo $Language->get('text_contact'); ?>">
                        <?php echo $Language->get('text_contact'); ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="large-5 medium-5 small-12 columns">
            <em><?php echo $text_powered_by; ?></em>
        </div>
    </div>
</section>
<!-- /terms -->

</div>
<!--/FOOTER UNDERBOTTOM-->
<!-- SCRIPTS AND SETTINGS -->


<?php
 if (count($javascripts) > 0) foreach ($javascripts as $js) { if (empty($js)) continue; ?>
     <script type="text/javascript" src="<?php echo $js; ?>"></script>
<?php } ?>

<?php if ($scripts) echo $scripts; ?>
<script type="text/javascript" async>
    <?php if ($google_analytics_code) { ?>
    var _gaq=[['_setAccount','<?php echo $google_analytics_code; ?>'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
    <?php } ?>
    
$(function() {
    $('#filter_keyword').on('keydown',function(e){
        var code = e.keyCode || e.which;
        if ($(this).val().length > 0 && code == 13) {
            moduleSearch();
        }
    });
    
    $("[data-request='cart']").one('click',function(e){
            $('[data-component="cart-overview"]').html('<img src="assets/images/loader.gif" alt="Cargando..." />').load('<?php echo $Url::createUrl("checkout/cart/callback"); ?>');
    });

    if (Modernizr.mq('only screen and (max-width: 62em)')) {
        $("*[data-action='call']").attr("href", "<?php echo 'callto://' . preg_replace('/\D+/', '', $Config->get('config_telephone'));?>");
    } else {
        $("*[data-action='call']").attr("href", "<?php echo 'tel:+58' . preg_replace('/\D+/', '', $Config->get('config_telephone')); ?>");
    }

    if (Modernizr.mq('only screen and (max-width: 62em)')) {
        $.ajax({
          url: '<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/js/vendor/mmenu/jquery.mmenu.oncanvas.js';?>',
          dataType: "script",
          success: function () {
            var navElement = document.getElementById("leftOffCanvas");
            $("#leftOffCanvas").mmenu();
            navElement.style.visibility = "visible";
            navElement.style.clip = "auto";
          }
        });
    }
    
    $().UItoTop();
});
</script>
</body>
</html>