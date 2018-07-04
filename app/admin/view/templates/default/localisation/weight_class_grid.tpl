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
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_title; ?>')"<?php if ($sort == 'title') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_title'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_description; ?>')"<?php if ($sort == 'description') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_unit'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_value; ?>')"<?php if ($sort == 'value') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_value'); ?></a></th>
                <th><?php echo $Language->get('column_action'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($weight_classes) { ?>
            <?php foreach ($weight_classes as $weight_class) { ?>
            <tr id="tr_<?php echo $weight_class['weight_class_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $weight_class['weight_class_id']; ?>" <?php if ($weight_class['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $weight_class['title']; ?></td>
                <td><?php echo $weight_class['description']; ?></td>
                <td><?php echo $weight_class['value']; ?></td>
                <td>
                <?php foreach ($weight_class['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "activate") { 
                        $jsfunction = "activate(". $weight_class['weight_class_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $weight_class['weight_class_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                    }
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $weight_class['weight_class_id']; ?>" src="<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
                <?php } ?>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="6" style="text-align:center"><?php echo $Language->get('text_no_results'); ?></td></tr>
        <?php } ?>
        </tbody>
    </table>
</form>
<div class="pagination"><?php echo $pagination; ?></div>