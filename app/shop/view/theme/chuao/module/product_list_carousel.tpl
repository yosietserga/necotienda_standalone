<!-- catalog-latest -->
<?php if($products) { ?>
<li nt-editable="1" class="widget-product-list widget-product-list-<?php echo $settings['view']; ?> widget-product-list-home productListWidget<?php echo ($settings['class']) ? ' ' .$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/blockgrid-start.tpl"); ?>

    <div id="<?php echo $widgetName; ?>Carousel" class="owl-carousel">
        <?php foreach($products as $product) { ?>
        <div>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-picture.tpl"); ?>
            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-info.tpl"); ?>
        </div>
        <?php } ?>
    </div>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/blockgrid-end.tpl"); ?>
</li>
<script type="text/javascript">
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:'#<?php echo $widgetName . $k; ?>Carousel',
            config:{
                loop:true,
                margin:10,
                nav:true,
                autoplay:true,
                autoplayTimeout:3000,
                autoplayHoverPause:true,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:2,
                        nav:true
                    },
                    600:{
                        items:4,
                        nav:false
                    }
                }
            },
            plugin:'owlCarousel'
        });

        ntPlugins.push({
            id:'#<?php echo $widgetName . $k; ?>Carousel .owl-item .scrollImg',
            config:{
                lazyLoad:'ondemand',
                vertical:true,
                rows:3,
                nextArrow:'<span class="arrow arrow-down arrow-2x"></span>',
                prevArrow:'<span class="arrow arrow-up arrow-2x"></span>'
            },
            plugin:'slick'
        });

        window.ntPlugins = ntPlugins;

        $('#<?php echo $widgetName . $k; ?>Carousel .thumbs img').on('click', function(e){
            var p = $(this).closest('.picture');
            p.find('.items img').attr('src', $(this).data('preview'));
        });
    });
</script>
<?php } ?>
