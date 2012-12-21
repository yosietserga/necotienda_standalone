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
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_name; ?>')"<?php if ($sort == 'name') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_name; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_subject; ?>')"<?php if ($sort == 'subject') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>>Asunto</a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_sent; ?>')"<?php if ($sort == 'date_added') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>>Contactos</a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_sent; ?>')"<?php if ($sort == 'date_added') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>>Estado</a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_added; ?>')"<?php if ($sort == 'date_added') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>>Fecha Enviado</a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_added; ?>')"<?php if ($sort == 'date_added') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_date_added; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_added; ?>')"<?php if ($sort == 'date_added') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_date_added; ?></a></th>
                <th><?php echo $column_action; ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($newsletters) { ?>
            <?php foreach ($newsletters as $newsletter) { ?>
            <tr id="tr_<?php echo $newsletter['newsletter_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $newsletter['newsletter_id']; ?>" <?php if ($newsletter['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $newsletter['name']; ?></td>
                <td><?php echo $newsletter['subject']; ?></td>
                <td><?php echo $newsletter['date_added']; ?></td>
                <td>
                <?php foreach ($newsletter['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "activate") { 
                        $jsfunction = "activate(". $newsletter['newsletter_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $newsletter['newsletter_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                    } elseif ($action['action'] == "duplicate") {
                        $jsfunction = "copy(". $newsletter['newsletter_id'] .")";
                        $href = "";
                    }
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $newsletter['newsletter_id']; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
                <?php } ?>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="8" style="text-align:center"><?php echo $text_no_results; ?></td></tr>
        <?php } ?>
        </tbody>
    </table>
</form>
<div class="pagination"><?php echo $pagination; ?></div>