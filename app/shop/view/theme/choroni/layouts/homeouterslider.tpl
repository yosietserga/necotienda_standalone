<?php echo $header; ?>
<?php echo $navigation; ?>
<?php if(isset($slider)) echo $slider; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
  
<div class="grid_10" id="content">
  <h1><?php echo $heading_title; ?></h1>
  <p><?php echo $welcome; ?></p>
  
  <?php if($modules) { ?>
      <?php foreach ($modules as $module) { ?>
      <div id="<?php echo $module['code']; ?>"><img src='<?php echo HTTP_IMAGE; ?>loader.gif' alt='Cargando...' /></div>
      <script>$(function(){$("#<?php echo $module['code']; ?>").load("index.php?r=module/<?php echo $module['code']; ?>/home");});</script>
      <?php } ?>
  <?php } ?>
  
</div>
<?php echo $footer; ?> 