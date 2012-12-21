<?php if ($error_warning) { ?><div class="warning"><?php echo $error_warning; ?></div><?php } ?>
    <div class="box">
        <h1>1. Selecciona las categor&iacute;as</h1>
        <div class="buttons">
            <a id="next" data-next="2" class="button">Siguiente</a>
            <a onclick="location = '<?php echo $Url::createAdminUrl("store/product/import"); ?>'" class="button">Cancelar</a>
        </div>
        
        <div class="clear"></div>
                                
        <p style="font: normal 10px verdana;color:#333;text-align:justify">A continuaci&oacute;n se muestran todas las categor&iacute;as registradas en el sitio web, si deseas que los productos que vas a importar est&eacute;n asociados a una o varias categor&iacute;as de una vez, por favor m&aacute;rcalas y haz click en el bot&oacute;n Siguiente.</p>
        <p style="font: normal 10px verdana;color:#333;text-align:justify">Si aun no has creado la categor&iacute;a, no selecciones ninguna y haz click en Siguiente, luego podr&aacute;s asignar los productos importados a las categor&iacute;as correspondientes.</p>
        <p style="font: normal 10px verdana;color:#333;text-align:justify">Para una mejor importaci&oacute;n de los datos, por favor descarga la plantilla CSV <a href="#" title="Plantilla CSV para importar productos">Aqu&iacute;</a></p>
        
        <div class="clear"></div>
                           
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

            <div class="row">
                <label>Filtrar categor&iacute;as por su nombre:</label>
                <input type="text" title="Filtrar listado de categor&iacute;as" value="" name="q" id="q" />
                <div class="clear"></div>
                <ul class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($categories as $category) { ?>
                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                    <li class="categories <?php echo $class; ?>">
                    <?php if (in_array($category['category_id'], $product_category)) { ?>
                        <input title="<?php echo $help_category; ?>" type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" showquick="off" /><?php echo $category['name']; ?>
                    <?php } else { ?>
                        <input title="<?php echo $help_category; ?>" type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" showquick="off" /><?php echo $category['name']; ?>
                    <?php } ?>
                    </li>
                <?php } ?>
                </ul>
            </div>
                    
            <div class="clear"></div>
                    
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
        $('#wizardWrapper').animate({marginLeft:'-200%',opacity:0},500,function(){
            $.post('<?php echo $Url::createAdminUrl("store/product/importprocess"); ?>&step=' + $('#next').attr('data-next'),$("#form").serialize(),function(data){
                $('#wizardWrapper').load('<?php echo $Url::createAdminUrl("store/product/importwizard"); ?>&step=' + $('#next').attr('data-next'),function(){
                    $('#wizardWrapper')
                        .css({marginLeft:'200%'})
                        .animate({marginLeft:'10px',opacity:1},500);
                });
            });
        });
    });
});
</script>