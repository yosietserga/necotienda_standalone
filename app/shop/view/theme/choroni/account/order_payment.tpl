<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    <section id="maincontent">
        <section id="content">
    
        <?php if ($column_left) { ?><aside id="column_left" class="grid_3"><?php echo $column_left; ?></aside><?php } ?>
        
        <?php if ($column_left && $column_right) { ?>
        <div class="grid_6">
        <?php } elseif ($column_left || $column_right) { ?>
        <div class="grid_9">
        <?php } else { ?>
        <div class="grid_12">
        <?php } ?>
            
            <h1><?php echo $heading_title; ?></h1>
            <?php if ($success) { ?><div class="success"><?php echo $success; ?></div><?php } ?>
            <?php if ($error) { ?><div class="warning"><?php echo $error; ?></div><?php } ?>
    
            <div class="clear"></div><br />
        
            <div class="sort">
                <input type="text" name="filter_order" id="filter_order" value="" placeholder="Buscar Pedido..." />
                <?php echo $text_sort; ?>
                <a href="#" id="filter" class="button" style="padding: 3px 4px;">Filtrar</a>
            </div> 
            
            <div class="clear"></div><br />
            
            <ul id="paymentMethods" class="nt-editable">
            <?php foreach ($payment_methods as $payment_method) { ?>
                <li>{%<?php echo $payment_method['id']; ?>%}</li>
            <?php } ?>
            </ul>
    
        </div>
        
        <?php if ($column_right) { ?><aside id="column_right" class="grid_3"><?php echo $column_right; ?></aside><?php } ?>

            <div class="clear"></div>

            <div class="grid_12">
                <div id="featuredFooter">
                <ul class="widgets" data-position="featuredFooter"><?php if($featuredFooterWidgets) { foreach ($featuredFooterWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } } ?></ul>
                </div>
            </div>

        </section>
    </section>
</div>
<div id="jsWrapper"></div>
<script>
$(function(){
    if (!$.ui) {
        $(document.createElement('script')).attr({
            src:'assets/js/vendor/jquery-ui.min.js',
            type:'text/javascript'
        }).appendTo('#jsWrapper');
    }
    if (!$.fn.ntForm) {
        $(document.createElement('script')).attr({
            src:'assets/js/necojs/neco.form.js',
            type:'text/javascript'
        }).appendTo('#jsWrapper');
    }
    if (!$('link[rel="assets/css/neco.form.css"]').length) {
        $(document.createElement('link')).attr({
            href:'assets/css/neco.form.css',
            rel:'stylesheet',
            media:'screen'
        }).appendTo('head');
    }
    if (!$('link[rel="assets/css/jquery-ui/jquery-ui.min.css"]').length) {
        $(document.createElement('link')).attr({
            href:'assets/css/jquery-ui/jquery-ui.min.css',
            rel:'stylesheet',
            media:'screen'
        }).appendTo('head');
    }
    $('input[type="necoDate"]').datepicker();
});
</script>
<?php echo $footer; ?>