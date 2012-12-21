<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
    <h1><?php echo $heading_title; ?></h1>
	<?php if (!$products) { ?>
        <div class="content"><?php echo $text_error; ?></div>
    <?php } ?>
    
    <div class="clear"></div>
    <div id="products"><img src='<?php echo HTTP_IMAGE; ?>nt_loader.gif' alt='Cargando...' /></div>
</div>
<script>$("#products").load("index.php?r=store/manufacturer/home&manufacturer_id=<?php echo $manufacturer_id; ?>")</script>
<?php echo $footer; ?> 