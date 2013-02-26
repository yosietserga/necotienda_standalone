<select id="batch">
    <option value="">Procesamiento en lote</option>
    <!--
    <option value="editAll">Editar</option>
    <option value="addToList">Agregar a una lista</option>
    -->
    <option value="copyAll">Copiar</option>
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
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_name; ?>')"<?php if ($sort == 'name') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_name; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_email; ?>')"<?php if ($sort == 'c.email') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_email; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_customer_group; ?>')"<?php if ($sort == 'customer_group') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_customer_group; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_approved; ?>')"<?php if ($sort == 'c.approved') { ?> class="<?php echo strtolower($order); ?>"<?php } ?>><?php echo $column_approved; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_status; ?>')"<?php if ($sort == 'c.status') { ?> class="<?php echo strtolower($order); ?>"<?php } ?>><?php echo $column_status; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_added; ?>')"<?php if ($sort == 'c.date_added') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_date_added; ?></a></th>
                <th><?php echo $column_action; ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($customers) { ?>
            <?php foreach ($customers as $customer) { ?>
            <tr id="tr_<?php echo $customer['customer_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" <?php if ($customer['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $customer['name']; ?></td>
                <td><?php echo $customer['email']; ?></td>
                <td><?php echo $customer['customer_group']; ?></td>
                <td><?php echo $customer['approved']; ?></td>
                <td><?php echo $customer['status']; ?></td>
                <td><?php echo $customer['date_added']; ?></td>
                <td>
                <?php foreach ($customer['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "activate") { 
                        $jsfunction = "activate(". $customer['customer_id'] .")";
                        $href = "";
                        $img_id = "img_activate_" . $customer['customer_id'];
                    } elseif ($action['action'] == "approve") {
                        $jsfunction = "aprobar(". $customer['customer_id'] .")";
                        $href = "";
                        $img_id = "img_approve_" . $customer['customer_id'];
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $customer['customer_id'] .")";
                        $href = "";
                        $img_id = "img_del_" . $customer['customer_id'];
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                        $img_id = "img_edit_" . $customer['customer_id'];
                    } 
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $customer['customer_id']; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
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