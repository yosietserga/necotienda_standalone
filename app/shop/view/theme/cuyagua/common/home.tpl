<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent">
    <section id="content">
        <div class="grid_16">
            <div id="featuredContent">
            <?php if($featuredWidgets) { ?><ul class="widgets"><?php foreach ($featuredWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
            </div>
        </div>
        <div class="clear"></div>        
        <div class="grid_13">        
            <div class="clear"></div>
            <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
            <div class="clear"></div>            
        </div>
        <aside id="column_right"><?php echo $column_right; ?></aside>
    </section>
</section>
<?php echo $footer; ?>