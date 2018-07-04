<li id="<?php echo $widgetName; ?>" class="banner horizontal-parallax<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="horizontal">

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>

<?php if (count($banner['items'])) { ?>
<div class="widget-content" id="<?php echo $widgetName; ?>Content" data-banner="horizontal-parallax">
    <ul class="container">
        <?php foreach ($banner['items'] as $item) { ?>
        <li class="item">
            <!--picture-->
            <?php if (!empty($item['image'])) { ?>
                <?php if (!empty($item['link'])) { ?><a href="<?php echo $item['link']; ?>"><?php } ?>
                <figure style="background-image: url('<?php echo HTTP_IMAGE . $item['image']; ?>')" class="b-horizontal-picture b-horizontal-item">
                </figure>
                <?php if (!empty($item['link'])) { ?></a><?php } ?>
            <?php } ?>
            <!--/picture-->

            <!--header-->
            <header class="b-horizontal-header">

                <!--title-->

                <?php if (!empty($item['title'])){ ?>
                <a data-apply="parseHTML" class="b-horizontal-title b-horizontal-item"href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a>
                <?php } ?>
                <!--/title-->

                <!--description-->

                <?php if (!empty($item['description'])){ ?>
                <p data-apply="parseHTML" class="b-horizontal-description b-horizontal-item"><?php echo $item['description']; ?></p>
                <?php } ?>
                <!--/description-->

                <!--read-more-->
                <?php if (!empty($item['link'])){ ?>
                <div class="b-horizontal-link b-horizontal-item action-button">
                    <a href="<?php echo $item['link']; ?>">Más detalles</a>
                </div>
                <?php } ?>

                <!--/read-more-->
            </header>
            <!--/header-->

        </li>
        <?php } ?>
    </ul>
</div>
<?php } ?>
</li>
