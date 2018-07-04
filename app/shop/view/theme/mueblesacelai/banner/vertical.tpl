<!--VERTICAL BANNER-->
<li id="<?php echo $widgetName; ?>" class="banner vertical<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="vertical">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 
    <?php if (count($banner['items'])) { ?>

    <!--VERTICAL BANNER CONTENT-->
    <div class="content widget-content" id="<?php echo $widgetName; ?>Content">
        <ul class="b-vertical-banner">
        <?php foreach ($banner['items'] as $item) { ?>
            <li>
                <!--title-->

                <?php if (!empty($item['title'])){ ?>
                    <a data-apply="parseHTML" class="b-vertical-title v-vertical-item"href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a>
                <?php } ?>

                <!--/title-->

                <!--image with link-->

                <?php if (!empty($item['image'])) { ?>
                    <?php if (!empty($item['link'])) { ?> <a class="b-vertical-picture b-vertical-item" href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php } ?>

                    <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $item['thumb']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>" />

                    <?php if (!empty($item['link'])) { ?> </a> <?php } ?>
                <?php } ?>

                <!--/image with link-->

                <!--description-->

                <?php if (!empty($item['description'])){ ?>
                    <p data-apply="parseHTML" class="b-vertical-description b-vertical-item"><?php echo $item['description']; ?></p>
                <?php } ?>

                <!--description-->

                <!--link-->

                <?php if (!empty($item['link'])){ ?>
                    <div class="b-vertical-link b-vertical-item btn" role="link">
                        <a href="<?php echo $item['link']; ?>">Leer más</a>
                    </div>
                <?php } ?>

                <!--/link-->
            </li>
        <?php } ?>
    </ul>
    </div>
    <!--/VERTICAL BANNER CONTENT-->
    <?php } ?>
</li>
<!--/VERTICAL BANNER-->
