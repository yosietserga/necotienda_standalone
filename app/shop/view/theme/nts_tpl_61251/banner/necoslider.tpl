<li id="<?php echo $widgetName; ?>" class="banner nivo<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editable" data-banner="nivoSlider">
<?php if ($heading_title) { ?>
        <div class="header" id="<?php echo $widgetName; ?>Header">
            <h1><?php echo $heading_title; ?></h1>
        </div>
<?php } ?>
    <div class="container">
        <ul id="slides">
            <li class="slide showing"></li>
            <li class="slide"></li>
            <li class="slide"></li>
        </ul>
        <div class="buttons">
            <button class="controls" id="previous">&lt;</button>

            <button class="controls" id="pause">&#10074;&#10074;</button>

            <button class="controls" id="next">&gt;</button>
        </div>
    </div>
</li>
