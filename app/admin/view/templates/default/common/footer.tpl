<div id="footer">
  <?php echo $Language->get('text_footer'); ?>
<?php if ($javascripts) foreach ($javascripts as $js) echo '<script src="'. $js .'"></script>';  ?>
<?php if ($scripts) echo $scripts; ?>
</body></html>