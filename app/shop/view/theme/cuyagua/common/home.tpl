<?php echo $header; ?>
<?php echo $navigation; ?>

<section id="maincontent">

    <!-- <aside id="column_left"><?php echo $column_left; ?></aside> -->
    
    <section id="content">
    
        <div class="grid_13">
        
            <section id="featured">
                <?php echo $showslider; ?>
            </section>

            <h1><?php echo $heading_title; ?></h1>
            <p><?php echo $welcome; ?></p>
              
            <div class="clear"></div>
            
            <div class="box">
                <div class="content"><div id="newest"></div></div>
            </div>

          <?php if($modules) { ?>
              <?php foreach ($modules as $key => $module) { ?>
              <div id="home_<?php echo $key . "_" .$module['code']; ?>"><img src='<?php echo HTTP_IMAGE; ?>loader.gif' alt='Cargando...' style="width: 300px;margin: 30% auto 0px auto;" /></div>
              <?php } ?>
          <?php } ?>
          
        </div>
        
        <aside id="column_right"><?php echo $column_right; ?></aside>
        
    </section>
    
</section>

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