<div id="<?php echo $widgetName . $k; ?>Carousel" class="owl-carousel">
    <?php if($tab['products']) { ?>
        <?php foreach($tab['products'] as $product) { ?>
        <div>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-picture.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-info.tpl"); ?>
        </div>
        <?php } ?>
        <script type="text/javascript">
            $(function(){
                $("#<?php echo $widgetName. $k; ?>Carousel").owlCarousel({
                    loop:true,
                    margin:10,
                    nav:true,
                    autoplay:true,
                    autoplayTimeout:3000,
                    autoplayHoverPause:true,
                    responsiveClass:true,
                    responsive:{
                        0:{
                            items:1,
                            nav:true
                        },
                        600:{
                            items:3,
                            nav:false
                        }
                    }
                });
            });
        </script>
    <?php } else { ?>
        <h2>No hay productos que cumplan con este criterio</h2>
    <?php } ?>
</div>
