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

        </section>
    </section>
</div>
<?php echo $footer; ?>