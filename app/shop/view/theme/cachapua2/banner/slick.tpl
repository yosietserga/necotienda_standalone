<!-- slick-banner -->
<li class="nt-editable slick-banner<?php echo ($settings['class']) ? " " . $settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <div class="widget-container">
        <?php if ($heading_title) { ?>
        <div class="heading" id="<?php echo $widgetName; ?>Header">
            <div class="heading-icon">
                <i class="fa fa-bookmark fa-2x"></i>
            </div>
            <div class="heading-title">
                <h3>
                    <?php echo $heading_title; ?>
                </h3>
            </div>
        </div>
    <?php } ?>
         <div class="widget-content" id="<?php echo $widgetName; ?>Content" data-banner="slick">
             <div class="slick-row">
                <?php
                $i = 1;
                foreach ($banner['items'] as $key => $item) { ?>
                    <div class="slick-column">
                        <?php if (empty($item['image'])) { continue; } ?>
                            <div class="item-picture">
                        <?php if (!empty($item['link'])) { ?>
                            <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">
                        <?php } ?>
                            <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $item['thumb']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>" />
                        <?php if (!empty($item['link'])) { ?>
                            </a>
                            </div>
                        <?php } ?>
                        <div class="item-body">
                            <?php if (!empty($item['title'])){ ?>
                                <div class="b-slick-title b-slick-item">
                                    <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a>
                                </div>
                            <?php } ?>

                            <?php if (!empty($item['description'])){ ?>
                                <div class="b-slick-description b-slick-item">
                                    <p ><?php echo $item['description']; ?></p>
                                </div>
                            <?php } ?>

                            <?php if (!empty($item['link'])){ ?>
                                <div class="b-slick-link b-slick-item action-button">
                                    <a href="<?php echo $item['link']; ?>">Leer más</a>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <?php if ($i % 6 === 0 && $i < count($banner['items'])){ ?>
                        </div><div class="slick-row">
                    <?php } ?>
                <?php $i++; } ?>
         </div>
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
                fade: true,
            });
        };
        initSlickSlider("[data-banner='slick']");
    })();
</script>
