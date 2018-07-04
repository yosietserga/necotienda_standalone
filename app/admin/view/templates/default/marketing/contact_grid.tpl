<!--
<select id="batch">
    <option value="">Procesamiento en lote</option>
    <option value="editAll">Editar</option>
    <option value="addToList">Agregar a una lista</option>
    <option value="addToList">Agregar A Lista</option>
    <option value="deleteAll">Eliminar</option>
</select>
<a href="#" title="Ejecutar acci&oacute;n por lote" onclick="if ($('#batch').val().length <= 0) { return false; } else { window[$('#batch').val()](); return false;}" style="margin-left: 10px;font-size: 10px;">[ Ejecutar ]</a>
<div class="clear"></div><br />

<div id="temp" style="display: none;">
    <form id="contact_list_form">
        <select name="contact_list_id" id="contact_list_id">
            <option value=""><?php echo $Language->get('text_select'); ?></option>
            <?php foreach ($lists as $list) { ?>
            <option value="<?php echo $list['contact_list_id']; ?>"><?php echo $list['name']; ?> (<?php echo $list['total_contacts']; ?>)</option>
            <?php } ?>
        </select>
    </form>
</div>
-->
<div class="pagination"><?php echo $pagination; ?></div>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
    <table id="list">
        <thead>
            <tr>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_name; ?>')"<?php if ($sort == 'name') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_name'); ?></a></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($contacts) { ?>
            <?php foreach ($contacts as $contact) { ?>
            <tr id="tr_<?php echo $contact['contact_id']; ?>">
                <td>
                    <?php echo $contact['name']; ?>&nbsp;
                    <?php echo $contact['email']; ?>
                </td>
                <!--
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
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $contact['contact_id']; ?>" src="<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
                <?php } ?>
                </td>
                -->
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="8" style="text-align:center"><?php echo $Language->get('text_no_results'); ?></td></tr>
        <?php } ?>
        </tbody>
    </table>
</form>
<div class="pagination"><?php echo $pagination; ?></div>