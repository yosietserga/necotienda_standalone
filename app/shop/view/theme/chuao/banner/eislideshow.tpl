
<li id="<?php echo $widgetName; ?>" class="banner camera<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="cameraSlider">

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>

<?php if (count($banner['items'])) { ?>

<div class="content" id="<?php echo $widgetName; ?>Content">
    <div class="ei-slider" id="<?php echo $widgetName; ?>slider">
        <ul class="ei-slider-large">
        <?php foreach ($banner['items'] as $item) { ?>
            <?php if (!empty($item['image'])) { ?>

            <li>
                <!--Slider first image link-->
                <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" alt="<?php echo $item['title']; ?>" />
                <div class="ei-title">
                    <!--Slider first image title-->
                    <?php if (!empty($item['title'])) { ?><h2><?php echo $item['title']; ?></h2><?php } ?>
                    <?php if (!empty($item['description'])) { ?><h3><?php echo $item['description']; ?></h3><?php } ?>
                    <?php if (!empty($item['link'])) { ?>
                    <a class="read-more" href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">Más detalles</a>
                    <?php } ?>
                </div>
            </li>

            <?php } ?>
        <?php } ?>
        </ul>

        <ul class="ei-slider-thumbs">
            <?php foreach ($banner['items'] as $item) { ?>
            <?php if (!empty($item['image'])) { ?>
            <li><a href="#">.</a></li>
            <?php } ?>
            <?php } ?>
        </ul>
    </div>
</div>

<script>
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:'#<?php echo $widgetName; ?>slider',
            config:{
                animation			: 'center',
                autoplay			: true,
                slideshow_interval	: 3000,
                titlesFactor		: 0
            },
            plugin:'eislideshow'
        });
        window.ntPlugins = ntPlugins;
    });
</script>
<?php } ?>
</li>
