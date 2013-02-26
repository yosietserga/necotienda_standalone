<?php echo $header; ?>
<?php echo $navigation; ?>

<div class="clear"></div>

<section id="featured">
    <div class="container_16">
        <div class="grid_16"><?php echo $showslider; ?></div>
    </div>
</section>

<div class="clear"></div>

<section class="container_16">
    <div class="grid_16">
        <div class="box">
            <div class="content"><div id="newest"></div></div>
        </div>
    </div>
</section>

<!--
<div class="clear"></div>
  
<section id="maincontent">

    <aside id="column_left"><?php echo $column_left; ?></aside>
    
    <section id="content">
        <div class="grid_10">
        
          <h1><?php echo $heading_title; ?></h1>
          <p><?php echo $welcome; ?></p>
          
          <?php if($modules) { ?>
              <?php foreach ($modules as $key => $module) { ?>
              <div id="home_<?php echo $key . "_" .$module['code']; ?>"><img src='<?php echo HTTP_IMAGE; ?>loader.gif' alt='Cargando...' /></div>
              <?php } ?>
          <?php } ?>
          
        </div>
        
    </section>
    
    <aside id="column_right"><?php echo $column_right; ?></aside>
    
</section>
-->
 <script>
$(function(){
    $("#newest").ntCarousel({
        url:'<?php echo Url::createUrl("module/latest/carousel"); ?>',
        image: {
          width:130,
          height:100  
        },
        loading: {
          image: '<?php echo HTTP_IMAGE; ?>loader.gif'
        },
        options: {
            scroll: 1
        }
    });
});
</script>
<?php echo $footer; ?>