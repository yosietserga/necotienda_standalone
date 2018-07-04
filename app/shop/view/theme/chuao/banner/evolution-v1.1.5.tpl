<?php $classes = ($settings['class']) ? $settings['class'] : ''; ?>

<li id="<?php echo $widgetName;?>" class="banner-evolution <?php echo $classes ?> nt-editable"> 
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 
    <div class="widget-content" id="<?php echo $widgetName; ?>Content" data-banner="evolution">
        <?php foreach ($banner['items'] as $item) { ?>

        <div>
            <?php if (!empty($item['title']) || !empty($item['description'])) { ?>
            <div class="caption">
                <?php if (!empty($item['title'])) { ?><h4><?php echo $item['title']; ?></h4><?php } ?>

                <?php if (!empty($item['description'])) { ?>
                <p class="body">
                    <?php echo $item['description']; ?>
                </p>
                <?php } ?>

                <?php if (!empty($item['link'])) { ?>
                <a href="<?php echo $item['link']; ?>" class="button"><?php echo $Language->get('See More'); ?> </a>
                <?php } ?>
            </div>
            <?php } ?>

            <?php if (!empty($item['link'])) { ?>
            <a href="<?php echo $item['link']; ?>">
            <?php } ?>

                <?php if (!empty($item['image'])) { ?>
                <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $item['thumb']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>" />
                <?php } ?>

            <?php if (!empty($item['link'])) { ?>
            </a>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</li>

<script>
    $(function(){
        ntPlugins = window.ntPlugins || [];

        var w = $('#<?php echo $widgetName; ?>').width();
        var h = $('#<?php echo $widgetName; ?> img').height();

        ntPlugins.push({
            id:"#<?php echo $widgetName; ?>Content",
            config:{
                width      : w,
                height     : h,
                transition : 'squareRandom'
            },
            plugin:'slideshow'
        });
        window.ntPlugins = ntPlugins;

        $(window).off('resize').on('resize', function(){
            var w = $('#widget_banner_1047204256').width();
            var h = $('#widget_banner_1047204256 .jquery-slider-slide-current img').height();

            $('#widget_banner_1047204256 .jquery-slider-wrapper').width(w).height(h);
            $('#widget_banner_1047204256 .widget-content').width(w).height(h);

            $("#widget_banner_1047204256Content").slideshow({
                width      : w,
                height     : h,
                transition : 'squareRandom'
            });
        });
    });
</script>