<select id="batch">
    <option value="">Procesamiento en lote</option>
    <!--
    <option value="editAll">Editar</option>
    <option value="addToList">Agregar a una lista</option>
    -->
    <option value="deleteAll">Eliminar</option>
</select>
<a href="#" title="Ejecutar acci&oacute;n por lote" onclick="window[$('#batch').val()]();return false;" style="margin-left: 10px;font-size: 10px;">[ Ejecutar ]</a>
<div class="clear"></div><br />

<div class="pagination"><?php echo $pagination; ?></div>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
    <table id="list">
        <thead>
            <tr>
                <th><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_name; ?>')"<?php if ($sort == 'name') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_name; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_email; ?>')"<?php if ($sort == 'subject') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_email; ?></a></th>
                <th><?php echo $column_telephone; ?></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_added; ?>')"<?php if ($sort == 'date_added') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_date_added; ?></a></th>
                <th><?php echo $column_action; ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($contacts) { ?>
            <?php foreach ($contacts as $contact) { ?>
            <tr id="tr_<?php echo $contact['contact_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $contact['contact_id']; ?>" <?php if ($contact['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $contact['name']; ?></td>
                <td><?php echo $contact['email']; ?></td>
                <td><?php echo $contact['telephone']; ?></td>
                <td><?php echo $contact['date_added']; ?></td>
                <td>
                <?php foreach ($contact['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "activate") { 
                        $jsfunction = "activate(". $contact['contact_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $contact['contact_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                    } elseif ($action['action'] == "duplicate") {
                        $jsfunction = "copy(". $contact['contact_id'] .")";
                        $href = "";
                    }
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $contact['contact_id']; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
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