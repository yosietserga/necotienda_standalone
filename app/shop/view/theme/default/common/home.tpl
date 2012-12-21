<?php echo $header; ?>
<?php echo $navigation; ?>
<aside id="featured"></aside>
<section id="maincontent">
    <aside id="column_left"><?php echo $column_left; ?></aside>
    <section id="content">
        <div class="grid_10">{%module_latest_1%}
          <h1><?php echo $heading_title; ?></h1>
          <p><?php echo $welcome; ?></p>
          
          <?php if($modules) { ?>
              <?php foreach ($modules as $key => $module) { ?>
              <div id="home_<?php echo $key . "_" .$module['code']; ?>"><img src='<?php echo HTTP_IMAGE; ?>nt_loader.gif' alt='Cargando...' /></div>
              <?php } ?>
          <?php } ?>
          
        </div>
        
    </section>
    <aside id="column_right"><?php echo $column_right; ?></aside>
</section>
<?php echo $footer; ?>