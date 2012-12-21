<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent">
    <aside id="column_left"><?php echo $column_left; ?></aside>
    <section id="content">
        <div class="grid_10">
            <h1><?php echo $heading_title; ?></h1>
            <div class="clear"></div>
            <div id="products"><img src='<?php echo HTTP_IMAGE; ?>nt_loader.gif' alt='Cargando...' /></div>
        </div>
    </section>
    <aside id="column_right"><?php echo $column_right; ?></aside>
</section>
<?php echo $footer; ?> 