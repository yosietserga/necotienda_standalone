<!--PLAIN TEXT WIDGET-->
<li class="nt-editable plaintextWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
<?php if ($heading_title) { ?>
	<div class="header" id="<?php echo $widgetName; ?>Header">
		<h1><?php echo $heading_title; ?></h1>
	</div>
	<?php } ?>
	<div class="content" id="<?php echo $widgetName; ?>Content">
		<p><?php echo $settings['text']; ?></p>
	</div>
</li>
<!--/TEXT-WIDGET-->