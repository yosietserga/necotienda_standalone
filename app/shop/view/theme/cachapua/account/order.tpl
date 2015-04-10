<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/message.tpl"); ?>
    <h1><?php echo $heading_title ?></h1>

    <div class="filter-form simple-form">
        <div class="form-entry">
            <input type="text" name="filter_list" id="filter_list" value="" placeholder="Buscar por ID de Pedido" />
        </div>
        <div class="form-entry">
            <select name="filter_status" id="filter_status">
                <option value="">Todos</option>
                <?php foreach ($statuses as $status) { ?>
                <option value="<?php echo $status['order_status_id']; ?>"><?php echo $status['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-entry">
        <select name="filter_limit" id="filter_limit">
            <option value="5">5 por p&aacute;gina</option>
            <option value="10">10 por p&aacute;gina</option>
            <option value="20">20 por p&aacute;gina</option>
            <option value="50">50 por p&aacute;gina</option>
        </select>
        </div>
        <div class="action-button action-success">
            <a onclick="filter()" id="filter">Filtrar</a>
        </div>
    </div>
    <div class="tabulated-data order-data" data-table="orders">
        <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
            <?php if ($orders) { ?>
                <table>
                    <thead>
                    <tr>
                        <th><div class="check-action"><input data-check='allOrders' title="Seleccionar Todos" type="checkbox"/><span></span></div></th>
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
                            <td><div class="check-action"><input data-check="order" type="checkbox" name="selected[]" value="<?php echo $value['order_id']; ?>"<?php if ($value['selected']) { ?> checked="checked"<?php } ?> /><span></span></div></td>
                            <td>#<?php echo $value['order_id']; ?></td>
                            <td id="status<?php echo $value['order_id']; ?>"><?php echo $value['status']; ?></td>
                            <td ><?php echo $value['products']; ?></td>
                            <td><?php echo $value['date_added']; ?></td>
                            <td><?php echo $value['total']; ?></td>
                            <td>
                                <div class="actions">
                                    <div class="action-button action-see">
                                        <a href="<?php echo $Url::createUrl("account/invoice",array("order_id"=>$value['order_id'])); ?>" title="Ver Detalles">Ver</a>
                                    </div>
                                    <div class="action-button action-add">
                                        <?php if ($value['order_status_id'] != 7) { ?>
                                            <a href="<?php echo $Url::createUrl("account/payment/register",array("order_id"=>$value['order_id'])); ?>" title="Pagar">Pagar</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
            <?php } else { ?>
            <div class="no-info">No tiene ning&uacute;n pedido aun, <a href="<?php echo $Url::createUrl("common/home"); ?>" title="Comprar">&iquest;Desea agregar uno?</a></div>
            <?php } ?>
        </form>
    </div>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
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

(function checkAllOrdersOnPage () {
    'use strict';
    var checkerForAll = document.querySelector("[data-check='allOrders']");
    var ordersInputs = document.querySelectorAll("[data-table='orders'] * [data-check='order']");
    var isChecked = function isChecked(check) {
        return (check.checked);
    };
    var switchChecks = function switchChecks() {
        var args = [].slice.call(arguments);
        return [].forEach.call(args[1], function(check) {
            check.checked = args[0];
        });
    };
    checkerForAll.addEventListener('click', function (e) {
        var checkbox = e.target;
        if (checkbox.checked) {
           switchChecks(true, ordersInputs);
        } else if ([].some.call(ordersInputs, isChecked) && !checkbox.checked) {
           switchChecks(false, ordersInputs);
        }
        return false;
    }, false);
})();
</script>
<?php echo $footer; ?>