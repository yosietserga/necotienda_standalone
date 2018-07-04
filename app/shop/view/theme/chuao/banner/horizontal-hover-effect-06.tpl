<li id="<?php echo $widgetName; ?>" class="banner banner-hhe-06<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="horizontal">

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>

<?php if (count($banner['items'])) { ?>
<div class="widget-content" id="<?php echo $widgetName; ?>Content" data-banner="horizontal">
    <ul class="container">
        <?php foreach ($banner['items'] as $item) { ?>
        <li class="item">
            <div class="ch-item" style="background-image:url(<?php echo HTTP_IMAGE . $item['image']; ?>)">
                <div class="ch-info">
                    <!--title-->
                    <?php if (!empty($item['title'])){ ?>
                    <a class="title" href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><h3><?php echo $item['title']; ?></h3></a>
                    <?php } ?>
                    <!--/title-->

                    <!--description-->
                    <?php if (!empty($item['description'])){ ?>
                    <p class="body" data-apply="parseHTML"><?php echo $item['description']; ?></p>
                    <?php } ?>
                    <!--/description-->

                    <?php if (!empty($item['link']) && (!empty($item['title']) || !empty($item['description']))){ ?>
                    <div class="link">
                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">
                            M&aacute;s detalles
                        </a>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<?php } ?>
</li>
