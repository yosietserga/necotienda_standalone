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
                    <a onclick="location = '<?php echo $insert; ?>'" class="button"><?php echo $Language->get('button_insert'); ?></a>
                    <a onclick="location = '<?php echo $import; ?>'" class="button"><?php echo $Language->get('button_import'); ?></a>
                    <a onclick="location = '<?php echo $export; ?>'" class="button"><?php echo $Language->get('button_export'); ?></a>
                </div>
            </div>      
            <div class="clear"></div><br />

            <h3>Filtros<span id="filters">[ Mostrar ]</span></h3>
            <form action="<?php echo $search; ?>" method="post" enctype="multipart/form-data" id="formFilter">        
                <div class="grid_11">
                    <div class="row">       
                        <label>Nombre del Producto:</label>
                        <input type="text" name="filter_name" value="" />
                    </div>

                    <div class="row">
                        <label>Modelo del Producto:</label>
                        <input type="text" name="filter_model" value="" />
                    </div>

                    <div class="row">
                        <label>Pertenece a la Categor&iacute;a:</label>
                        <input type="text" name="filter_category" value="" />
                    </div>

                    <div class="row">
                        <label>Ordernar Por:</label>
                        <select name="sort">
                            <option value="">Selecciona un campo</option>
                            <option value="cd.name">Nombre de la categor&iacute;a</option>
                            <option value="c.sort_order">Posici&oacute;n</option>
                            <option value="c.date_added">Fecha cuando se cre&oacute;</option>
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
    
    <div class="grid_12">
        <div class="box">
            <div id="ProductForm"></div>
            <div id="gridPreloader"></div>
            <div id="gridWrapper"></div>
        </div>
    </div>
</div>
<script>
<?php echo file_get_contents(DIR_ADMIN_JS . 'app/system/route.js'); ?>

<?php echo file_get_contents(DIR_ADMIN_JS . 'app/utils/db.js'); ?>
<?php echo file_get_contents(DIR_ADMIN_JS . 'app/utils/connection.js'); ?>
<?php echo file_get_contents(DIR_ADMIN_JS . 'app/utils/task.js'); ?>
<?php echo file_get_contents(DIR_ADMIN_JS . 'app/utils/image.js'); ?>

<?php echo file_get_contents(DIR_ADMIN_JS . 'app/models/store/products.js'); ?>
<?php echo file_get_contents(DIR_ADMIN_JS . 'app/collections/store/products.js'); ?>
</script>
<?php echo $footer; ?>