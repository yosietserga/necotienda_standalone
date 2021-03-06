<select id="batch">
    <option value="">Procesamiento en lote</option>
    <!--
    <option value="editAll">Editar</option>
    <option value="addToList">Agregar a una lista</option>
    -->
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
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_order; ?>')"<?php if ($sort == 'o.order_id') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_order'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_name; ?>')"<?php if ($sort == 'name') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_name'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_status; ?>')"<?php if ($sort == 'status') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_status'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_added; ?>')"<?php if ($sort == 'o.date_added') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_date_added'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_total; ?>')"<?php if ($sort == 'o.total') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_total'); ?></a></th>
                <th><?php echo $Language->get('column_action'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($orders) { ?>
            <?php foreach ($orders as $order) { ?>
            <tr id="tr_<?php echo $order['order_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" <?php if ($order['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['name']; ?></td>
                <td><?php echo $order['status']; ?></td>
                <td><?php echo $order['date_added']; ?></td>
                <td><?php echo $order['total']; ?></td>
                <td>
                <?php foreach ($order['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "print") { 
                        $href = "href='" . $action['href'] ."' target='_blank'";
                        $jsfunction = "";
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $order['order_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                    }
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $order['manufacturer_id']; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
                <?php } ?>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="8" style="text-align:center"><?php echo $Language->get('text_no_results'); ?></td></tr>
        <?php } ?>
        </tbody>
    </table>
</form>
<div class="pagination"><?php echo $pagination; ?></div>