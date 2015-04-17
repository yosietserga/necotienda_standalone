<li class="nt-editable box carouselWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php if ($heading_title) { ?><div class="header" id="<?php echo $widgetName; ?>Header"><h1><?php echo $heading_title; ?></h1></div><?php } ?>
    <div class="content" id="<?php echo $widgetName; ?>Content"></div>
</li>
<script type="text/javascript">
$(function(){


    if (typeof $.fn.ntCarousel == 'undefined') {
        $('<script>').attr({
            'src':'<?php echo HTTP_JS; ?>necojs/neco.carousel.js',
            'type':'text/javascript'
        }).appendTo('head');
    }
    if ($.fn.ntCarousel) {
        $("#<?php echo $widgetName; ?>Content").ntCarousel({
            url: '<?php echo Url::createUrl("module/". $settings['module'] ."/carousel"); if ((int)$settings['limit']) echo '&limit='.(int)$settings['limit'] ?>',
            image: {
              width:<?php echo (int)$settings['width']; ?>,
              height:<?php echo (int)$settings['height']; ?>  
            },
            loading: {
              image: '<?php echo HTTP_IMAGE; ?>loader.gif'
            },
            options: {
                scroll: <?php echo (int)$settings['scroll']; ?>
            }
        });
    }

});
</script>