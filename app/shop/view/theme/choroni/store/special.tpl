<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
    <h1><?php echo $heading_title; ?></h1>

    <div class="clear"></div>
    <div id="products"></div>
</div>
<script>$("#products").load("index.php?r=store/special/home<?php echo $url; ?>")</script>
<?php echo $footer; ?> 