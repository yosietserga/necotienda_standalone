<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    
    <?php if ($breadcrumbs) { ?>
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <?php } ?>
    
    <?php if ($success) { ?><div class="grid_12"><div class="message success"><?php echo $success; ?></div></div><?php } ?>
    <?php if ($msg || $error_warning) { ?><div class="grid_12"><div class="message warning"><?php echo ($msg) ? $msg : $error_warning; ?></div></div><?php } ?>
    <?php if ($error) { ?><div class="grid_12"><div class="message error"><?php echo $error; ?></div></div><?php } ?>
    <div class="grid_12" id="msg"></div>
    
    <div class="grid_12">
        <div class="box">
            <h1><?php echo $Language->get('heading_title'); ?></h1>
            <a href="<?php echo $Url::createAdminUrl('module/crm/step'); ?>" class="button">Pasos de Venta</a>
            <a href="<?php echo $Url::createAdminUrl('module/crm/status'); ?>" class="button">Status</a>
            <a href="<?php echo $Url::createAdminUrl('module/crm/step'); ?>" class="button">Oportunidades</a>
            <a href="<?php echo $Url::createAdminUrl('module/crm/step'); ?>" class="button">Ventas</a>
            <a href="<?php echo $Url::createAdminUrl('module/crm/step'); ?>" class="button">Clientes Potenciales</a>
            <a href="<?php echo $Url::createAdminUrl('module/crm/step'); ?>" class="button">Productos</a>
        </div>
    </div>
</div>
<script>
$(function(){
    <?php if ($ajaxRequest) { ?>
    $.getJSON('<?php echo $Url::createAdminUrl('module/crm/step/api'); ?>',
    {
        f:'getAll'
    })
    .done(function(data){
        
        if (data.items) {
            html = '';
            $.each(data.items, function(i, item) { 
                html += '<tr id="tr_'+ item.sale_step_id +'">'
                +'<td><input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="'+ item.sale_step_id +'"';
                if (item.selected) {
                    html += ' checked="checked" />';
                }
                html += '</td>'
                +'<td>'+ item.name +'</td>'
                +'<td>';
                $.each(item.action, function(j, action){ 
                    if (action.action === "activate") {
                        href = 'onclick="activate('+ item.sale_step_id +')"';
                    } else if (action.action === "delete") {
                        href = 'onclick="eliminar('+ item.sale_step_id +')"';
                    } else if (action.action === "edit") {
                        href = 'href="'+ action.href +'"';
                    }

                    html += '<a title="'+ action.text +'" '+ href +'>'
                    +'<img id="img_'+ item.sale_step_id +'" src="image/'+ action.img +'" alt="'+ item.name +'" />'
                    +'</a>';
                });
                html += '</td>'
                +'</tr>';
            });
        } else { 
            html = '<tr><td colspan="4"></td></tr>';
        }
        
        $('#list tbody').append(html);
        
    });
    <?php } ?>
    $('#list tbody').sortable({
        opacity: 0.6, 
        handle: '.move',
        update: function() {
            $.ajax({
                type:'post',
                dateType:'json',
                url:'<?php echo $Url::createAdminUrl("module/crm/step/sortable"); ?>',
                data: $(this).sortable("serialize"),
                success: function(data) {
                    if (data > 0) {
                        var msj = "<div class='success'>Se han ordenado los objetos correctamente</div>";
                    } else {
                        var msj = "<div class='warning'>Hubo un error al intentar ordenar los objetos, por favor intente m�s tarde</div>";
                    }
                    $("#msg").append(msj).delay(3600).fadeOut();
                }
            });
        }
    }).disableSelection();
    $('#list .move').css('cursor','move');

    $('#formFilter').ntForm({
        lockButton:false,
        ajax:true,
        type:'get',
        dataType:'html',
        url:'<?php echo $Url::createAdminUrl("module/crm/step/api"); ?>',
        beforeSend:function(){
            $('#gridWrapper').hide();
            $('#gridPreloader').show();
        },
        success:function(data){
            $('#gridPreloader').hide();
            $('#gridWrapper').html(data).show();
        }
    });
    
    $('#formFilter').on('keyup', function(e){
        var code = e.keyCode || e.which;
        if (code == 13){
            $('#formFilter').ntForm('submit');
        }
    });
});

function editAll() {
    return false;
}
function deleteAll() {
    if (confirm('\\xbfDesea eliminar todos los objetos seleccionados?')) {
        $('#gridWrapper').hide();
        $('#gridPreloader').show();
        $.post('" . Url::createAdminUrl("module/crm/step/delete") . "',$('#form').serialize(),function(){
            $('#gridWrapper').load('" . Url::createAdminUrl("module/crm/step/api") . "',function(){
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
            $.getJSON('" . Url::createAdminUrl("module/crm/step/delete") . "',{
            id:e
        });
    }
    return false;
 }
</script>
<?php echo $footer; ?>