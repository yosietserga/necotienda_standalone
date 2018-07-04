<li id="<?php echo $widgetName; ?>" class="banner banner-hhe-08<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="horizontal">

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>

<?php if (count($banner['items'])) { ?>
<div class="widget-content" id="<?php echo $widgetName; ?>Content" data-banner="horizontal">
    <ul class="container">
        <?php foreach ($banner['items'] as $item) { ?>
        <li class="item"<?php if (isset($style)) { echo ' style="'. $style .'"'; } ?>>


            <!--picture-->
            <?php if (!empty($item['image'])) { ?>
            <?php if (!empty($item['link'])) { ?><a href="<?php echo $item['link']; ?>"><?php } ?>
            <div class="stack">
                <div class="stack__deco"></div>
                <div class="stack__deco"></div>
                <div class="stack__deco"></div>
                <div class="stack__deco"></div>
                <figure class="stack__figure">
                    <img class="stack__img" src="<?php echo HTTP_IMAGE . $item['image']; ?>" alt="<?php $item['title']; ?>" />
                </figure>
            </div>
            <?php if (!empty($item['link'])) { ?></a><?php } ?>
            <?php } ?>
            <!--/picture-->

            <!--header-->
            <section class="details">
                <!--title-->
                <?php if (!empty($item['title'])){ ?>
                <a class="title" href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>" data-apply="parseHTML"><?php echo $item['title']; ?></a>
                <?php } ?>
                <!--/title-->

                <!--description-->
                <?php if (!empty($item['description'])){ ?>
                <p class="body" data-apply="parseHTML"><?php echo $item['description']; ?></p>
                <?php } ?>
                <!--/description-->

                <!--read-more-->
                <?php if (!empty($item['link']) && (!empty($item['title']) || !empty($item['description']))){ ?>
                <div class="link">
                    <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">
                        M&aacute;s detalles
                    </a>
                </div>
                <?php } ?>
                <!--/read-more-->
            </section>
            <!--/header-->
        </li>
        <?php } ?>
    </ul>
</div>
<script>
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:"#<?php echo $widgetName; ?>",
            config:{
                el: '#<?php echo $widgetName; ?> li'
            },
            fn:function( config ) {
                [].slice.call(document.querySelectorAll( config.el )).forEach(function(stackEl) {
                    new PolarisFx(stackEl);
                });
            }
        });
        window.ntPlugins = ntPlugins;
    });
</script>
<?php } ?>
</li>
