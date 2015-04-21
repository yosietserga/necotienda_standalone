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

<?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
    <table id="list">
        <thead>
            <tr>
                <th><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
                <th><?php echo $Language->get('Host'); ?></th>
                <th><?php echo $Language->get('Username'); ?></th>
                <th><?php echo $Language->get('Action'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($servers) { ?>
            <?php foreach ($servers as $server_id => $server) { ?>
            <tr id="tr_<?php echo $server_id; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $server_id; ?>" <?php if ($server['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $server['server']; ?></td>
                <td><?php echo $server['username']; ?></td>
                <td>
                <?php foreach ($server['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $server_id .")";
                        $href = "";
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                    }
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $server_id; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
                <?php } ?>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="4" style="text-align:center"><?php echo $Language->get('text_no_results'); ?></td></tr>
        <?php } ?>
        </tbody>
    </table>
</form>