<?php if ($error_warning) { ?><div class="warning"><?php echo $error_warning; ?></div><?php } ?>
    <div class="box">
        <h1>2. Carga el archivo</h1>
        <div class="buttons">
            <a id="next" data-next="3" class="button">Siguiente</a>
            <a onclick="location = '<?php echo $Url::createAdminUrl("store/product/import"); ?>'" class="button">Cancelar</a>
        </div>
        
        <div class="clear"></div>
                                
        <p style="font: normal 10px verdana;color:#333;text-align:justify">Selecciona el archivo de formato CSV (Separado por Comas) que contiene la información de los productos que se van a importar. Los campos pueden estar separados o delimitados por cualquier caracter, si se ha utilizado un caracter diferente a punto y coma (;), entonces ind&iacute;calo en el formulario.</p>
        <p style="font: normal 10px verdana;color:#333;text-align:justify">El archivo que se va a subir no debe ser mayor a 20MB y solo se aceptan archivos con extensiones .txt o .csv</p>
        <p style="font: normal 10px verdana;color:#333;text-align:justify">Para una mejor importaci&oacute;n de los datos, por favor descarga la plantilla CSV <a href="#" title="Plantilla CSV para importar productos">Aqu&iacute;</a></p>
        
        <div class="clear"></div>
                                   
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

            <div class="row">
                <label>Subir Archivo</label>
                <input type="file" name="file" id="file" value="" showquick="off" title="Selecciona el archivo CSV que contiene la información de los productos que se van a importar" />
            </div>
            
            <div class="clear"></div>
            
            <div id="progress">
                <div class="bar" style="background:url('image/progressbar.gif') left top repeat-x;width: 0%;height:18px;"></div>
            </div>
            
            <div class="clear"></div>
            
            <div class="row">
                <label>Contiene Cabecera</label>
                <input type="checkbox" title="Marca esta casilla si quieres actualizar los productos. Ten en cuenta que la informaci&oacute;n ser&aacute; sobreescrita" value="1" name="header" />
            </div>
                    
            <div class="clear"></div>
            
            <div class="row">
                <label>Actualizar Productos</label>
                <input type="checkbox" title="Marca esta casilla si quieres actualizar los productos. Ten en cuenta que la informaci&oacute;n ser&aacute; sobreescrita" value="1" name="update" />
            </div>
                    
            <div class="clear"></div>
            
            <div class="row">
                <label>Caracter Separador</label>
                <input type="text" title="Ingresa el caracter utilizado en el archivo CSV para separar los datos" value=";" name="separator" style="width:20px" />
            </div>
                    
            <div class="clear"></div>
            
            <div class="row">
                <label>Caracter para Encapsular</label>
                <input type="text" title="Ingresa el caracter utilizado en el archivo CSV para encapsular datos complejos" value="" name="enclosure" style="width:20px" />
            </div>
                    
            <div class="clear"></div>
            
            <div class="row">
                <label>Caracter Escape</label>
                <input type="text" title="Ingresa el caracter utilizado en el archivo CSV para separar los datos" value="\" name="escape" style="width:20px" />
            </div>
                    
            <div class="clear"></div>
            
        </form>
    </div>
<script type="text/javascript" src="js/vendor/fileUploader/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="js/vendor/fileUploader/jquery.fileupload.js"></script>
<script>
$(function(){
    $('#form').ntForm({
        lockButton:false,
        submitButton:false,
        cancelButton:false,
    });
    
     $('#file').fileupload({
        url: '<?php echo $Url::createAdminUrl("store/product/importprocess"); ?>&step=upload',
        dataType: 'json',
        done: function (e, data) {
            $('#progress .bar').css({'width':'0%'});
            if (data.result.error) {
                alert(data.result.msg);
            } else {
                $('#file').hide().after('<b id="done">Archivo Cargado</b>');
            }
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css({'width':progress + '%'});
        }
    });
    
    $('#next').on('click',function(e){
        if (!$("#done").length) {
            alert("Debes seleccionar un archivo para importar o no podr\u00E1s continuar con el proceso");
        } else {
            $('#wizardWrapper').animate({marginLeft:'-200%',opacity:0},500,function(){
                $.post('<?php echo $Url::createAdminUrl("store/product/importprocess"); ?>&step=' + $('#next').attr('data-next'),$("#form").serialize(),function(data){
                    $('#wizardWrapper').load('<?php echo $Url::createAdminUrl("store/product/importwizard"); ?>&step=' + $('#next').attr('data-next'),function(){
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