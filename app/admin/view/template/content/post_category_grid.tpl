<select name="" onchange="">
    <option value="">Procesamiento en lote, selecciona una opci&oacute;n</option>
    <option value="">Editar las categor&iacute;as seleccionadas</option>
    <option value="">Comparar las categor&iacute;as seleccionadas</option>
    <option value="">Activar las categor&iacute;as seleccionadas</option>
    <option value="">Desactivar las categor&iacute;as seleccionadas</option>
    <option value="">Eliminar las categor&iacute;as seleccionadas</option>
</select>
<div class="clear"></div><br />
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="formGrid">
    <table id="list" style="margin-bottom: 0px;">
        <thead>
            <tr>
                <th><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></th>
                <th><?php echo $column_name; ?></th>
                <th><?php echo $column_action; ?></th>
            </tr>
        </thead>
    </table>
    <?php if ($categories) { ?>
        <?php echo $categories; ?>
    <?php } else { ?>
        <?php echo $text_no_results; ?>
    <?php } ?>
</form>