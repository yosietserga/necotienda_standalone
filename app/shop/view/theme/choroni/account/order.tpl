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
                <input type="text" name="filter_list" id="filter_list" value="" placeholder="Buscar por ID de Pedido" />
                <select name="filter_status" id="filter_status">
                    <option value="">Todos</option>
                    <?php foreach ($statuses as $status) { ?>
                    <option value="<?php echo $status['order_status_id']; ?>"><?php echo $status['name']; ?></option>
                    <?php } ?>
                </select>
                <select name="filter_limit" id="filter_limit">
                    <option value="5">5 por p&aacute;gina</option>
                    <option value="10">10 por p&aacute;gina</option>
                    <option value="20">20 por p&aacute;gina</option>
                    <option value="50">50 por p&aacute;gina</option>
                </select>
                <a onclick="filter()" id="filter" class="button" style="padding: 3px 4px;float:right !important">Filtrar</a>
            </div> 

            <div class="clear"></div><br />

            <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">

                <?php if ($orders) { ?>
                <table>
                    <thead>
                    <tr>
                        <th><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" style="width: 5px !important;" /></th>
                        <th><?php echo $text_order; ?></th>
                        <th><?php echo $text_status; ?></th>
                        <th><?php echo $text_products; ?></th>
                        <th><?php echo $text_date_added; ?></th>
                        <th><?php echo $text_total; ?></th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                            <?php foreach ($orders as $value) { ?>
                    <tr id="pid_<?php echo $value['order_id']; ?>">
                        <td><input type="checkbox" name="selected[]" value="<?php echo $value['order_id']; ?>"<?php if ($value['selected']) { ?> checked="checked"<?php } ?> style="width: 5px !important;" /></td>
                        <td><b>#<?php echo $value['order_id']; ?></b></td>
                        <td id="status<?php echo $value['order_id']; ?>"><?php echo $value['status']; ?></td>
                        <td style="text-align:center"><?php echo $value['products']; ?></td>
                        <td><?php echo $value['date_added']; ?></td>
                        <td><b><?php echo $value['total']; ?></b></td>
                        <td>
                                            <a href="<?php echo $Url::createUrl("account/invoice",array("order_id"=>$value['order_id'])); ?>" title="Ver Detalles" class="button">Ver</a>
                            <?php if ($value['order_status_id'] != 7) { ?>
                                            <a href="<?php echo $Url::createUrl("account/payment/register",array("order_id"=>$value['order_id'])); ?>" title="Pagar" class="button" style="background: #F5692C;">Pagar</a>
                            <?php } ?>
                        </td>
                    </tr>
                            <?php } ?>
                </table>
                <div class="clear"></div>
                <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
                <?php } else { ?>
                <div>No tiene ning&uacute;n pedido aun, <a href="<?php echo $Url::createUrl("common/home"); ?>" title="Comprar">&iquest;Desea agregar uno?</a></div>
                <?php } ?>
            </form>
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
<script>
function filter() {
     var url = '';
    
    if ($('#filter_list').val()){
        url += '&order_id=' + $('#filter_list').val();
    }
    
    if ($('#filter_sort').val()){
        url += '&sort=' + $('#filter_sort').val();
    }
    
    if ($('#filter_status').val()){
        url += '&status=' + $('#filter_status').val();
    }
    
    if ($('#filter_limit').val()){
        url += '&limit=' + $('#filter_limit').val();
    }
    
    window.location.href = '<?php echo $Url::createUrl("account/order"); ?>' + url;
    
    return false;
}
$('#filter').on('click',function(e){
    filter();
    return false;
});
$('#filter_list').on('keydown',function(e) {
    if (e.keyCode == 13) {
        filter();
    }
});
</script>
<?php echo $footer; ?>