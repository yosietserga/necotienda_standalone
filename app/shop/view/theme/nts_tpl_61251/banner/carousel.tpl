<li id="<?php echo $widgetName; ?>" class="banner carousel<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable">
<?php if ($heading_title) { ?><div class="header" id="<?php echo $widgetName; ?>Header"><hgroup><h1><?php echo $heading_title; ?></h1></hgroup></div><?php } ?>
<?php if (count($banner['items'])) { ?>
<div class="content owl-carousel" id="<?php echo $widgetName; ?>Content">
    <?php foreach($banner['items'] as $item) { ?>
    <div>

        <?php if (!empty($item['link'])) { ?><a href="<?php echo $item['link']; ?>"><?php } ?>

        <?php if (!empty($item['image'])) { ?>
        <figure>
            <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $item['thumb']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>" />
        </figure>
        <?php } ?>

        <?php if (!empty($item['link'])) { ?></a><?php } ?>

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

    </div>
    <?php } ?>

</div>
<script>
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:'#<?php echo $widgetName; ?>Content',
            config:{
                loop:true,
                margin:10,
                nav:true,
                autoplay:true,
                autoplayTimeout:3000,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:2
                    },
                    1000:{
                        items:4
                    }
                }
            },
            plugin:'owlCarousel'
        });
        window.ntPlugins = ntPlugins;
    });
</script>
<?php } ?>
</li>