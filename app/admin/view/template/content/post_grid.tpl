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
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_title; ?>')"<?php if ($sort == 'title') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_title; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_publish; ?>')"<?php if ($sort == 'publish') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_publish; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_publish_start; ?>')"<?php if ($sort == 'date_publish_start') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_date_publish_start; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_publish_end; ?>')"<?php if ($sort == 'date_publish_end') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $column_date_publish_end; ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_order; ?>')"<?php if ($sort == 'pa.sort_order') { ?> class="<?php echo strtolower($order); ?>"<?php } ?>><?php echo $column_sort_order; ?></a></th>
                <th><?php echo $column_action; ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($pages) { ?>
            <?php foreach ($pages as $page) { ?>
            <tr id="tr_<?php echo $page['page_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $page['page_id']; ?>" <?php if ($page['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $page['title']; ?></td>
                <td><?php echo $page['publish']; ?></td>
                <td><?php echo $page['date_publish']; ?></td>
                <td class="move"><img src="image/move.png" alt="Posicionar" title="Posicionar" style="text-align:center" /></td>
                <td>
                <?php foreach ($page['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "activate") { 
                        $jsfunction = "activate(". $page['page_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $page['page_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                    }
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $page['page_id']; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
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