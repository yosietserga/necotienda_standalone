<!--VERTICAL BANNER-->
<li class="nt-editable widget__vertical bannerWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php if ($heading_title) { ?>
        <!--VERTICAL BANNER TITLE-->
        <div class="widget__header heading" id="<?php echo $widgetName; ?>Header">
            <div class="widget__header-icon heading__icon">
                <i class="fa fa-bookmark fa-2x"></i>
            </div>
            <div class="widget__header-title heading__title">
                <h3>
                    <?php echo $heading_title; ?>
                </h3>   
            </div>
        </div>
        <!--/VERTICAL BANNER TITLE-->
    <?php } ?>

    <?php if (count($banner['items'])) { ?>

    <!--VERTICAL BANNER CONTENT-->
    <div class="content widget__vertical__content" id="<?php echo $widgetName; ?>Content">
        <ul class="widget__vertical__list small-block-grid-1 medium-block-grid-3 large-block-grid-1 ">
            <?php foreach ($banner['items'] as $item) { ?>
            <li>
                <?php if (empty($item['image'])) continue; ?>
                <?php if (!empty($item['link'])) { ?>
                    <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php } ?>
                        <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $item['thumb']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>" />
                        <?php if (!empty($item['link'])) { ?>
                    </a>
                <?php } ?>
            </li>
            <?php } ?>
        </ul> 
    </div>
    <!--/VERTICAL BANNER CONTENT-->
    <?php } ?>
</li>
<!--/VERTICAL BANNER-->
