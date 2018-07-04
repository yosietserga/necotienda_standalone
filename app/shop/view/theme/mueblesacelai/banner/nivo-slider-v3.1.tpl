<li id="<?php echo $widgetName; ?>" class="banner nivo<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="nivoSlider">
<?php if ($heading_title) { ?>
        <div class="header" id="<?php echo $widgetName; ?>Header">
            <h1><?php echo $heading_title; ?></h1>
        </div>
<?php } ?>
<?php if (count($banner['items'])) { ?>
<div class="content" id="<?php echo $widgetName; ?>Content">
    <div class="slider-wrapper theme-default" style="position:relative;">
        <div id="slider" class="nivoSlider">
            <?php foreach ($banner['items'] as $item) { ?>
                <?php if (!empty($item['link'])) { ?><a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"> <?php } ?>

                <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $Image->resizeAndSave($item['image'],50,50); ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>" />

                <?php if (!empty($item['link'])) { ?></a> <?php } ?>
            <?php } ?>
        </div>
        <?php if (!empty($item['description'])) { ?>
            <div id="htmlcaption" class="nivo-html-caption">
                <h2 data-apply="parseHTML"><?php echo $item['title']; ?></h2>
                <p data-apply="parsehtml"><?php echo $item['description']; ?></p>
                <?php if (!empty($item['link'])) { ?>
                    <a class="read-more" href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">Más detalles</a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:"<?php echo $widgetname; ?> .nivoSlider",
            config:{
                effect:'random',
                slices:12,
                animSpeed:300,
                pauseTime:6000,
                startSlide:0,
                directionNav:false,
                directionNavHide:true,
                controlNav: false,
                controlNavThumbs:true,
                controlNavThumbsFromRel:false,
                controlNavThumbsSearch: '.jpg',
                controlNavThumbsReplace: '_thumb.jpg',
                keyboardNav:true,
                pauseOnHover:true,
                manualAdvance:false,
                captionOpacity: 0.8,
                beforeChange: function(){},
                afterChange: function(){},
                slideshowEnd: function(){}
            },
            plugin:'nivoSlider'
        });
        window.ntPlugins = ntPlugins;
    });
    
    (function(w){

        var config = {
            effect:'fade',
            slices:12,
            animSpeed:450,
            pauseTime:3000000,
            startSlide:0,
            directionNav: true,
            directionNavHide: false,
            controlNav: false,
            controlNavThumbs: false,
            controlNavThumbsFromRel:false,
            controlNavThumbsSearch: '.jpg',
            controlNavThumbsReplace: '_thumb.jpg',
            keyboardNav:true,
            pauseOnHover:true,
            manualAdvance: false,
            prevText: '<?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/angle-left.tpl"); ?>',
            nextText: '<?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/angle-right.tpl"); ?>',
            captionOpacity:0,
            beforeChange: function(){},
            afterChange: function(){},
            slideshowEnd: function(){}
        };

    })(window);
</script>
<?php } ?>
</li>
