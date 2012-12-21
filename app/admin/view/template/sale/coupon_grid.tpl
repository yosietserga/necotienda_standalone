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
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_code; ?>')"<?php if ($sort == 'c.code') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_code; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_discount; ?>')"<?php if ($sort == 'c.discount') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_discount; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_start; ?>')"<?php if ($sort == 'c.date_start') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_date_start; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_end; ?>')"<?php if ($sort == 'c.date_end') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_date_end; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_status; ?>')"<?php if ($sort == 'c.status') { ?> class="<?php echo strtolower($order); ?>"<?php } ?>><?php echo $column_status; ?></a></th>
                <th><?php echo $column_action; ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($coupons) { ?>
            <?php foreach ($coupons as $coupon) { ?>
            <tr id="tr_<?php echo $coupon['coupon_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $coupon['coupon_id']; ?>" <?php if ($coupon['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $coupon['name']; ?></td>
                <td><?php echo $coupon['code']; ?></td>
                <td><?php echo $coupon['discount']; ?></td>
                <td><?php echo $coupon['date_start']; ?></td>
                <td><?php echo $coupon['date_end']; ?></td>
                <td><?php echo $coupon['status']; ?></td>
                <td>
                <?php foreach ($coupon['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "activate") { 
                        $jsfunction = "activate(". $coupon['coupon_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $coupon['coupon_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                    }
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $coupon['coupon_id']; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
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