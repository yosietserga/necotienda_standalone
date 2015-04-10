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
            <div class="header">
                <h1><?php echo $Language->get('heading_title'); ?></h1>
                <div class="buttons">
                <a href="<?php echo $Url::createAdminUrl('module/crm/plugin'); ?>" class="button">Escriorio del Módulo</a>
                <a href="<?php echo $Url::createAdminUrl('module/crm/step'); ?>" class="button">Principal de los Pasos</a>
                <a href="<?php echo $Url::createAdminUrl('module/crm/step/create'); ?>" class="button"><?php echo $Language->get('button_insert'); ?></a>
                </div>
            </div>    

            <div class="clear"></div><br />

            <h3>Filtros<span id="filters">[ Mostrar ]</span></h3>
            <form action="<?php echo $search; ?>" method="post" enctype="multipart/form-data" id="formFilter">        
                <div class="grid_11">
                    <div class="row">       
                        <label>Nombre:</label>
                        <input type="text" name="filter_name" value="" />
                    </div>

                    <div class="row">
                        <label>Ordernar Por:</label>
                        <select name="sort">
                            <option value="">Selecciona un campo</option>
                            <option value="name">Nombre</option>
                            <option value="sort_order">Posici&oacute;n</option>
                            <option value="date_added">Fecha cuando se cre&oacute;</option>
                        </select>
                    </div>
                </div>

                <div class="grid_11">
                    <div class="row">
                        <label>Fecha Inicial:</label>
                        <input type="necoDate" name="filter_date_start" value="" />
                    </div>
                    <div class="row">
                        <label>Fecha Final:</label>
                        <input type="necoDate" name="filter_date_end" value="" />
                    </div>
                    <div class="row">
                        <label>Mostrar:</label>
                        <select name="limit">
                            <option value="">Selecciona una cantidad</option>
                            <option value="10">10 Resultados por p&aacute;gina</option>
                            <option value="25">25 Resultados por p&aacute;gina</option>
                            <option value="50">50 Resultados por p&aacute;gina</option>
                            <option value="100">100 Resultados por p&aacute;gina</option>
                            <option value="150">150 Resultados por p&aacute;gina</option>
                        </select>
                    </div>
                </div>

                <div class="clear"></div><br />
            </form>
        </div>
    </div>
    
    <div class="clear"></div>

    <div class="box">
        <div id="gridPreloader"></div>
        <div id="gridWrapper"></div>
    </div>
    
</div>
<script>
$(function(){
    $('#gridWrapper').load('<?php echo $Url::createAdminUrl("module/crm/step/grid"); ?>',
    function(){
        $('#gridPreloader').hide();
    });

    $('#formFilter').ntForm({
        lockButton:false,
        ajax:true,
        type:'get',
        dataType:'html',
        url:'<?php echo $Url::createAdminUrl("module/crm/step/grid"); ?>',
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
        if (code === 13){
            $('#formFilter').ntForm('submit');
        }
    });
});

</script>
<?php echo $footer; ?>