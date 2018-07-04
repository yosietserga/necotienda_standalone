<li id="<?php echo $widgetName; ?>" class="banner nivo<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="nivoSlider">
<?php if ($heading_title) { ?>
        <div class="header" id="<?php echo $widgetName; ?>Header">
            <h1><?php echo $heading_title; ?></h1>
        </div>
<?php } ?>
SRSDFSDFSDFSDFSDFD
<?php if (count($banner['items'])) { ?>
<div class="content" id="<?php echo $widgetName; ?>Content">
    <div class="slider-wrapper theme-default" style="position:relative;">
        <div id="<?php echo $widgetName; ?>slider" class="nivoSlider">
            <?php foreach ($banner['items'] as $k => $item) { ?>
            <?php if (empty($item['image'])) { continue; } ?>
                <?php if (!empty($item['link'])) { ?><a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"> <?php } ?>

                <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $Image->resizeAndSave($item['image'],50,50); ?>" alt="<?php echo $item['title']; ?>" title="<?php if (!empty($item['description'])) { echo '#'. $widgetName .'_slide_caption_'. $k; } elseif (!empty($item['title'])) { echo $item['title']; } ?>" />

                <?php if (!empty($item['link'])) { ?></a> <?php } ?>


                <?php if (!empty($item['description'])) { ?>
                <div id="<?php echo '#'. $widgetName .'_slide_caption_'. $k; ?>" class="nivo-html-caption">
                    <?php if (!empty($item['title'])) { ?><h2 data-apply="parseHTML"><?php echo $item['title']; ?></h2><?php } ?>
                    <p data-apply="parsehtml"><?php echo $item['description']; ?></p>
                    <?php if (!empty($item['link'])) { ?>
                    <a class="read-more" href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">Más detalles</a>
                    <?php } ?>
                </div>
                <?php } ?>
            <?php } ?>
        </div>

    </div>
</div>
<script>
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:"#<?php echo $widgetName; ?>slider",
            plugin:'nivoSlider'
        });
        window.ntPlugins = ntPlugins;
    });
</script>
<?php } ?>
</li>
