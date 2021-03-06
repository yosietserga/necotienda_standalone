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
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_title; ?>')"<?php if ($sort == 'title') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_title'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_publish; ?>')"<?php if ($sort == 'publish') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_publish'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_date_publish_start; ?>')"<?php if ($sort == 'date_publish_start') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_date_publish_start'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_order; ?>')"<?php if ($sort == 'pa.sort_order') { ?> class="<?php echo strtolower($order); ?>"<?php } ?>><?php echo $Language->get('column_sort_order'); ?></a></th>
                <th><?php echo $Language->get('column_action'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($posts) { ?>
            <?php foreach ($posts as $post) { ?>
            <tr id="tr_<?php echo $post['post_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $post['post_id']; ?>" <?php if ($post['selected']) { ?>checked="checked"<?php } ?>/></td>
                <td><?php echo $post['title']; ?></td>
                <td><?php echo $post['publish']; ?></td>
                <td><?php echo $post['date_publish_start']; ?></td>
                <td class="move"><img src="image/move.png" alt="Posicionar" title="Posicionar" style="text-align:center" /></td>
                <td>
                <?php foreach ($post['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "activate") { 
                        $jsfunction = "activate(". $post['post_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $post['post_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                    }
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $post['post_id']; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
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