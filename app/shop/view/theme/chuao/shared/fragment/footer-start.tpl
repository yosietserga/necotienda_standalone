<?php if (count($javascripts) > 0) foreach ($javascripts as $js) { if (empty($js)) continue; ?>
<script type="text/javascript" src="<?php echo $js; ?>"></script>
<?php } ?>
<?php if ($scripts) echo $scripts; ?>

<script>
$(function() {
    $().UItoTop();
});
</script>

