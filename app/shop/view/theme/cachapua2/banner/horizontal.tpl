<li class="nt-editable bannerWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
<?php if ($heading_title) { ?>
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
<?php } ?>
<?php if (count($banner['items'])) { ?>
<div class="widget-content" id="<?php echo $widgetName; ?>Content">
    <ul class="widget-horizontal-banner large-block-grid-3 medium-block-grid-3 small-block-grid-1">
        <?php foreach ($banner['items'] as $item) { ?>
        <li>
            <?php if (!empty($item['title'])){ ?>
                <a class="b-horizontal-title b-horizontal-item"href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php echo $item['title']; ?></a>
            <?php } ?>

            <?php if (empty($item['image'])) continue; ?>
                <?php if (!empty($item['link'])) { ?><a class="b-horizontal-picture b-horizontal-item" href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>"><?php } ?>
                <img src="<?php echo HTTP_IMAGE . $item['image']; ?>" data-thumb="<?php echo $item['thumb']; ?>" alt="<?php echo $item['title']; ?>" title="<?php echo $item['title']; ?>" />
            <?php if (!empty($item['link'])) { ?></a><?php } ?>
            <?php if (!empty($item['description'])){ ?>
                <p class="b-horizontal-description b-horizontal-item"><?php echo $item['description']; ?></p>
            <?php } ?>
            <?php if (!empty($item['link'])){ ?>
                <div class="b-horizontal-link b-horizontal-item action-button">
                    <a href="<?php echo $item['link']; ?>">Leer más</a>
                </div>
            <?php } ?>
        </li>
        <?php } ?>
    </ul> 
</div>
<?php } ?>
</li>
