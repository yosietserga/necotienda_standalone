<select id="batch">
    <option value="">Procesamiento en lote</option>
    <!--
    <option value="editAll">Editar</option>
    <option value="addToList">Agregar a una lista</option>
    -->
    <option value="deleteAll">Eliminar</option>
</select>
<br />
<a href="#" title="Ejecutar acci&oacute;n por lote" onclick="if ($('#batch').val().length <= 0) { return false; } else { window[$('#batch').val()](); return false;}" style="margin-left: 10px;font-size: 10px;">[ Ejecutar ]</a>
<div class="clear"></div><br />
<div class="pagination"><?php echo $pagination; ?></div>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
    <table id="list">
        <thead>
            <tr>
                <th><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
                <th><?php echo $Language->get('column_image'); ?></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_name; ?>')"<?php if ($sort == 'name') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_name'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_order; ?>')"<?php if ($sort == 'p.sort_order') { ?> class="<?php echo strtolower($order); ?>"<?php } ?>><?php echo $Language->get('column_sort_order'); ?></a></th>
                <th><?php echo $Language->get('column_action'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($manufacturers) { ?>
            <?php foreach ($manufacturers as $manufacturer) { ?>
            <tr id="tr_<?php echo $manufacturer['manufacturer_id']; ?>">
                <td class="hideOnMobile hideOnTablet"><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $manufacturer['manufacturer_id']; ?>" <?php if ($manufacturer['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td data-title="<?php echo $Language->get('Image'); ?>"><img alt="<?php echo $manufacturer['name']; ?>" src="<?php echo $manufacturer['image']; ?>" style="padding: 1px; border: 1px solid #ccc;" /></td>
                <td data-title="<?php echo $Language->get('Name'); ?>"><a href="<?php echo $Url::createUrl("store/manufacturer",array('manufacturer_id'=>$manufacturer['manufacturer_id']),'NONSSL',HTTP_CATALOG); ?>" target="_blank"><?php echo $manufacturer['name']; ?></a></td>
                <td data-title="<?php echo $Language->get('Move'); ?>" class="move"><img src="<?php echo str_replace('%theme%',$Config->get('config_admin_template'),HTTP_ADMIN_THEME_IMAGE) .'move.png'; ?>"" alt="Posicionar" title="Posicionar" style="text-align:center" /></td>
                <td data-title="<?php echo $Language->get('Actions'); ?>">
                <?php foreach ($manufacturer['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "activate") { 
                        $jsfunction = "activate(". $manufacturer['manufacturer_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $manufacturer['manufacturer_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                    }
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $manufacturer['manufacturer_id']; ?>" src="<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
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