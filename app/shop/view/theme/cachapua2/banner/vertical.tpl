<!--vertical banner-->
<li class="nt-editable widget-vertical bannerWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <div class="widget-container">
    <?php if ($heading_title) { ?>
        <!--vertical banner title-->
        <div class="heading" id="<?php echo $widgetName; ?>Header">
            <div class="heading-icon">
                <i class="fa fa-bookmark fa-2x"></i>
            </div>
            <div class="heading-title">
                <h3>
                    <?php echo $heading_title; ?>
                </h3>   
            </div>
        </div>
        <!--/vertical banner title-->
    <?php } ?>

    <?php if (count($banner['items'])) { ?>

    <!--vertical banner content-->

    <div class="widget-content" id="<?php echo $widgetName; ?>Content">
        <ul>
            <?php foreach ($banner['items'] as $item) { ?>
            <li>
                <div class="b-vertical-container">
                    <?php if (empty($item['image'])) continue; ?>
                        <div class="b-vertical-picture b-vertical-item">
                            <?php if (!empty($item['link'])) { ?>
                                <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php } ?>
                                    <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $item['thumb']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>" />
                                    <?php if (!empty($item['link'])) { ?>
                                </a>
                        </div>
                    <?php } ?>

                    <?php if (!empty($item['title'])){ ?>
                        <div class="b-vertical-title b-vertical-item">
                            <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a>
                        </div>
                    <?php } ?>

                    <?php if (!empty($item['description'])){ ?>
                        <div class="b-vertical-description b-vertical-item">
                            <p ><?php echo $item['description']; ?></p>
                        </div>
                    <?php } ?>

                    <?php if (!empty($item['link'])){ ?>
                        <!--<div class="b-vertical-link b-vertical-item action-button">
                            <a href="<?php echo $item['link']; ?>">Leer más</a>
                        </div>-->
                    <?php } ?>
                </div>
            </li>
            <?php } ?>
        </ul> 
    </div>
    <!--/vertical banner content-->
    <?php } ?>
    </div>
</li>
<!--/vertical banner-->
