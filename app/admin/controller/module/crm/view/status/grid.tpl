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
                <th><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" showquick="off" /></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_name; ?>')"<?php if ($sort == 'name') { ?> class="<?php echo strtolower($order); ?>" <?php } ?>><?php echo $Language->get('column_name'); ?></a></th>
                <th><a onclick="$('#gridWrapper').load('<?php echo $sort_order; ?>')"<?php if ($sort == 'p.sort_order') { ?> class="<?php echo strtolower($order); ?>"<?php } ?>><?php echo $Language->get('column_sort_order'); ?></a></th>
                <th><?php echo $Language->get('column_action'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($statuss) { ?>
            <?php foreach ($statuss as $status) { ?>
            <tr id="tr_<?php echo $status['sale_status_id']; ?>">
                <td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $status['sale_status_id']; ?>" <?php if ($status['selected']) { ?>checked="checked"<?php } ?> showquick="off" /></td>
                <td><?php echo $status['name']; ?></td>
                <td class="move hideOnMobile hideOnTablet"><img src="image/move.png" alt="Posicionar" title="Posicionar" style="text-align:center" /></td>
                <td>
                <?php foreach ($status['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "activate") { 
                        $jsfunction = "activate(". $status['sale_status_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "delete") {
                        $jsfunction = "eliminar(". $status['sale_status_id'] .")";
                        $href = "";
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                    }
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $status['sale_status_id']; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
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
<script>
$(function(){
    $('#list tbody').sortable({
        opacity: 0.6, 
        cursor: 'move',
        handle: '.move',
        update: function() {
            $.ajax({
                type:'post',
                dateType:'json',
                url:'<?php echo $Url::createAdminUrl("module/crm/status/sortable"); ?>',
                data: $(this).sortable('serialize'),
                success: function(data) {
                    if (data > 0) {
                        var msj = '<div class="message success">Se han ordenado los objetos correctamente</div>';
                    } else {
                        var msj = '<div class="message warning">Hubo un error al intentar ordenar los objetos, por favor intente m&aacute;s tarde</div>';
                    }
                    $('#msg').fadeIn().append(msj).delay(3600).fadeOut();
                }
            });
        }
    }).disableSelection();
    $('.move').css('cursor','move');
});
function editAll() {
    return false;
}
function deleteAll() {
    if (confirm('\\xbfDesea eliminar todos los objetos seleccionados?')) {
        $('#gridWrapper').hide();
        $('#gridPreloader').show();
        $.post('" . Url::createAdminUrl("module/crm/status/delete") . "',$('#form').serialize(),function(){
            $('#gridWrapper').load('" . Url::createAdminUrl("module/crm/status/api") . "',function(){
                $('#gridWrapper').show();
                $('#gridPreloader').hide();
            });
        });
    }
    return false;
}
function eliminar(e) {
    if (confirm('\\xbfDesea eliminar este objeto?')) {
        $('#tr_' + e).remove();
            $.getJSON('" . Url::createAdminUrl("module/crm/status/delete") . "',{
            id:e
        });
    }
    return false;
 }
</script>