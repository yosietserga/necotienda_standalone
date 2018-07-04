<!-- slick-banner -->
<li id="<?php echo $widgetName;?>" class="banner slick<?php echo ($settings['class']) ? " " . $settings['class'] : ''; ?> nt-editable">
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

<script>
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:"<?php echo $widgetName; ?>Content",
            config:{
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: false,
                fade: false,
                arrows: true,
                slide: 'div',
                cssEase: 'linear',
                useCSS: false
            },
            plugin:'slick'
        });
        window.ntPlugins = ntPlugins;
    });
</script>
