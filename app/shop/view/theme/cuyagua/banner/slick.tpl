<!-- slick-banner -->
<li class="nt-editable break slickBanner<?php echo ($settings['class']) ? " " . $settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
     <div class="widget-content" id="<?php echo $widgetName; ?>Content" data-banner="slick">
        <?php foreach ($banner['items'] as $item) { ?>
            <div>
                <?php if (empty($item['image'])) { continue; } ?>
                <?php if (!empty($item['link'])) { ?>
                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">
                <?php } ?>
                <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $item['thumb']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>" />
                <?php if (!empty($item['link'])) { ?></a><?php } ?>
            </div>
        <?php } ?>
     </div>
</li>
<!-- /slick-banner -->

<script async>
    (function () {
       var slickScript;
       if (typeof $.fn.slick === 'undefined') {
               slickScript = document.createElement("script");
               slickScript.src = '<?php echo HTTP_HOME . 'assets/theme/' . $this->config->get('config_template') . '/js/vendor/slick/slick/slick.min.js';?>';
               slickScript.async = true;
            $("head").append(slickScript);
       }
    })();
</script>
<script type="text/javascript" defer>
    (function(){
        var initSlickSlider;

        /**
         * init the slick carusel plugin
         * @param string target - slick plugin target
         */

        initSlickSlider = function (target) {
            $(target).slick({
                  slidesToShow: 1
                , slidesToScroll: 1
                , infinite: true
                , dots: false
                , fade: false
                , arrows: true
                , slide: 'div'
                , cssEase: 'linear'
                , useCSS: false
            });
        };
        initSlickSlider("[data-banner='slick']");
    })();
</script>
