<?php if ($error_warning) { ?><div class="warning"><?php echo $error_warning; ?></div><?php } ?>
    <div class="box">
        <h1>3. Mapa del Archivo</h1>
        <div class="buttons">
            <a id="next" data-next="4" class="button">Importar Productos</a>
            <a onclick="location = '<?php echo $Url::createAdminUrl("store/product/import"); ?>'" class="button">Cancelar</a>
        </div>
        
        <div class="clear"></div>
                                
        <p style="font: normal 10px verdana;color:#333;text-align:justify">Por favor indica cu&aacute;les son los campos correspondientes que est&aacute;n asociados a los diferentes atributos de los productos, por ejemplo "Nombre" -&gt; "Nombre del Prudcto". Esto permite que puedas subir cualquier archivo CSV con cualquier estrutura</p>
        <p style="font: normal 10px verdana;color:#333;text-align:justify">Es obligatorio que indiques que campo corresponde al modelo del producto, de lo contrario no se procesar&aacute;n los datos.</p>
        
        <div class="clear"></div>
                                    
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <?php if (isset($header)) { ?>
            <?php foreach ($header as $column) { ?>
            <div class="row">
                <label><?php echo $column; ?> pertenece a:</label>
                <select title="Selecciona el archivo CSV que contiene la información de los productos que se van a importar" name="Header[<?php echo str_replace(" ","_",trim($column)); ?>]" id="<?php echo str_replace(" ","_",trim($column)); ?>" showquick="off">
                    <option value="">Selecciona un campo</option>
                    <?php foreach ($fields as $field=>$label) { ?>
                        <option value="<?php echo $field; ?>"><?php echo $label; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="clear"></div>
            <?php }  ?>
        <?php } else { ?>
        <?php }  ?>
            
        </form>
    </div>
<script>
$(function(){
    $('#form').ntForm({
        lockButton:false,
        submitButton:false,
        cancelButton:false,
    });
    $('#next').on('click',function(e){
        var  hasModel = false;
        $("select").each(function(){
            if ($(this).val() == 'model') hasModel = true;
        });
        if (!hasModel) {
            alert("Debes seleccionar un campo que corresponda al modelo del producto o no podr\u00E1s continuar con el proceso");
        } else {
            $('#wizardWrapper').animate({marginLeft:'-200%',opacity:0},500,function(){
                var div = $(document.createElement('div')).attr({
                    'class':'tooltip warning',
                    'id':'temp'
                }).text('Cargando...');
                $("#menu_h").after(div);
                $.post('<?php echo $Url::createAdminUrl("store/product/importprocess"); ?>&step=' + $('#next').attr('data-next'),$("#form").serialize(),function(data){
                    div.remove();
                    $('#wizardWrapper').load('<?php echo $Url::createAdminUrl("store/product/importwizard"); ?>&step=' + $('#next').attr('data-next') +'&new=' + data.nuevo +'&updated=' + data.updated +'&bad=' + data.bad +'&total=' + data.total,function(){
                        $('#wizardWrapper')
                            .css({marginLeft:'200%'})
                            .animate({marginLeft:'10px',opacity:1},500);
                    });
                });
            });
        }
    });
});
</script>