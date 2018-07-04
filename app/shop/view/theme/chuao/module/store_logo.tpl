<li nt-editable="1" class="box storeLogoWidget<?php echo ($settings['class']) ? ' '. $settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>" style="text-align:<?php echo $settings['position']; ?>">
	<?php if ($logo) { ?>
	<a title="<?php echo $store; ?>" href="<?php echo str_replace('&', '&amp;', HTTP_HOME); ?>"><img src="<?php echo $logo; ?>" title="<?php echo $store; ?>" alt="<?php echo $store; ?>" /></a>
	<?php } else { ?>
	<a title="<?php echo $store; ?>" href="<?php echo str_replace('&', '&amp;', HTTP_HOME); ?>"><?php echo $text_store; ?></a>
	<?php } ?>
    <div class="clear"></div><br />
</li>