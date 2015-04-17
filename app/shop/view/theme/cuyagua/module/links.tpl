<!--WIDGET LINKS-->
<li data-component="dropdown" class="nt-editable widget-links<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName;?>">
	<?php if ($heading_title) { ?>
	<div class="links-heading links" id="<?php echo $widgetName; ?>Header" data-trigger="dropdown">
		<div class="links-title">
			<h3>
				<?php echo $heading_title; ?>
			</h3>	
		</div>
	</div>
	<?php } ?>
    <div data-wrapper="dropdown">
        <div class="links-content widget-content" id="<?php echo $widgetName; ?>Content" data-dropdown="links"><?php echo $links; ?></div>
    </div>
</li>
<!--/WIDGET LINKS-->