<select name="" onchange="">
    <option value="">Procesamiento en lote, selecciona una opci&oacute;n</option>
    <option value="">Editar los productos seleccionados</option>
    <option value="">Agregar a una categor&iacute;a</option>
    <option value="">Comparar los productos seleccionados</option>
    <option value="">Duplicar los productos seleccionados</option>
    <option value="">Activar los productos seleccionados</option>
    <option value="">Desactivar los productos seleccionados</option>
    <option value="">Eliminar los productos seleccionados</option>
</select>

<div class="clear"></div><br />

<div class="pagination"><?php echo $pagination; ?></div>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
    <table id="list">
        <thead>
            <tr>
                <th><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
                <th><?php echo $column_image; ?></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_name; ?>')"<?php if ($sort == 'cd.name') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_name; ?></a></th>
                <th><?php echo $column_qty; ?></th>
                <th><?php echo $column_orders; ?></th>
                <th><?php echo $column_invoices; ?></th>
                <th><?php echo $column_joins; ?></th>
                <th><?php echo $column_comments; ?></th>
                <th><?php echo $column_action; ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($customer_groups) { ?>
            <?php foreach ($customer_groups as $customer_group) { ?>
            <tr id="tr_<?php echo $customer_group['customer_group_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $customer_group['customer_group_id']; ?>" <?php if ($customer_group['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $customer_group['name']; ?></td>
                <td><?php echo $customer_group['cant_customers']; ?></td>
                <td><?php echo $customer_group['cant_orders']; ?> - <?php echo $customer_group['total_orders']; ?></td>
                <td><?php echo $customer_group['cant_invoices']; ?> - <?php echo $customer_group['total_invoices']; ?></td>
                <td><?php echo $customer_group['cant_references']; ?> - <?php echo $customer_group['total_references']; ?></td>
                <td><?php echo $customer_group['cant_reviews']; ?> - <?php echo $customer_group['total_reviews']; ?></td>
                <td>
                <?php foreach ($customer_group['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "activate") { 
                        $jsfunction = "activate(". $customer_group['customer_group_id'] .")";
                        $href = "";
                        $img_id = "img_activate_" . $customer_group['customer_group_id'];
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $customer_group['customer_group_id'] .")";
                        $href = "";
                        $img_id = "img_del_" . $customer_group['customer_group_id'];
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                        $img_id = "img_edit_" . $customer_group['customer_group_id'];
                    } 
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $customer_group['customer_group_id']; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
                <?php } ?>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="9" style="text-align:center"><?php echo $text_no_results; ?></td></tr>
        <?php } ?>
        </tbody>
    </table>
</form>
<div class="pagination"><?php echo $pagination; ?></div>