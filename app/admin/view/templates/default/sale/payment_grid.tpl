<select id="batch">
    <option value="">Procesamiento en lote</option>
    <!--
    <option value="editAll">Editar</option>
    <option value="addToList">Agregar a una lista</option>
    -->
    <option value="deleteAll">Colocar En Espera</option>
    <option value="deleteAll">Aprobar</option>
    <option value="deleteAll">Desaprobar</option>
    <option value="deleteAll">Devolver</option>
    <option value="deleteAll">Eliminar</option>
</select>
<a href="#" title="Ejecutar acci&oacute;n por lote" onclick="if ($('#batch').val().length <= 0) { return false; } else { window[$('#batch').val()](); return false;}" style="margin-left: 10px;font-size: 10px;">[ Ejecutar ]</a>
<div class="clear"></div><br />
<div class="pagination"><?php echo $pagination; ?></div>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
    <table id="list">
        <thead>
            <tr>
                <th><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_order_payment_id; ?>')"<?php if ($sort == 'op.order_payment_id') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_payment_id'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_order_id; ?>')"<?php if ($sort == 'op.order_id') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_order_id'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_customer; ?>')"<?php if ($sort == 'customer') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_customer'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_payment_method; ?>')"<?php if ($sort == 'payment_method') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_payment_method'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_bank; ?>')"<?php if ($sort == 'bk.name') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_bank'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_order_payment_status_id; ?>')"<?php if ($sort == 'op.order_payment_status_id') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_status'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_transac_date; ?>')"<?php if ($sort == 'op.transac_date') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_transac_date'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_transac_number; ?>')"<?php if ($sort == 'op.transac_number') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_transac_number'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_amount; ?>')"<?php if ($sort == 'op.amount') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_amount'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_added; ?>')"<?php if ($sort == 'op.date_added') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_date_added'); ?></a></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($payments) { ?>
            <?php foreach ($payments as $payment) { ?>
            <tr id="tr_<?php echo $payment['order_payment_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $payment['order_payment_id']; ?>" <?php if ($payment['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $payment['order_payment_id']; ?></td>
                <td><?php echo $payment['order_id']; ?></td>
                <td><a href="<?php echo $Url::createAdminUrl("sale/customer",array('customer_id'=>$payment['customer']['customer_id'])); ?>"><?php echo $payment['customer']['firstname'] .' '. $payment['customer']['lastname']; ?></a></td>
                <td><?php echo $payment['payment_method']; ?></td>
                <td><?php echo $payment['bank']; ?></td>
                <td><?php echo $payment['status']; ?></td>
                <td><?php echo $payment['transac_date']; ?></td>
                <td><b><?php echo $payment['transac_number']; ?></b></td>
                <td><?php echo $payment['amount']; ?></td>
                <td><?php echo $payment['date_added']; ?></td>
                <!-- <td>
                <?php foreach ($payment['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $payment['order_payment_id'] .")";
                        $href = "";
                        $img_id = "img_del_" . $payment['order_payment_id'];
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                        $img_id = "img_edit_" . $payment['order_payment_id'];
                    } 
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $payment['order_payment_id']; ?>" src="<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
                <?php } ?>
                </td> -->
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="5" style="text-align:center"><?php echo $Language->get('text_no_results'); ?></td></tr>
        <?php } ?>
        </tbody>
    </table>
    <p>Total Pagos Mostrados: <?php echo $total; ?></p>
</form>
<div class="pagination"><?php echo $pagination; ?></div>