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
    
    <div class="box">
        <h1><?php echo $Language->get('heading_title'); ?></h1>
        <div class="buttons">
            <a id="necoBoy" style="margin: 0px 10px;" title="NecoBoy ay&uacute;dame!"><img src="<?php echo HTTP_IMAGE; ?>necoBoy.png" alt="NecoBoy" /></a>
            <a onclick="saveAndExit();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_exit'); ?></a>
            <a onclick="saveAndKeep();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_keep'); ?></a>
            <a onclick="saveAndNew();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_new'); ?></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $Language->get('button_cancel'); ?></a>
        </div>
        
        <div class="clear"></div>
        
        <ol id="stepsForm" class="joyRideTipContent" style="display:none">
            <li data-button="<?php echo $Language->get('button_next'); ?>">
                <h2><?php echo $Language->get('heading_joyride_begin'); ?></h2>
                <p><?php echo $Language->get('help_joyride_begin'); ?></p>
            </li>
            <li data-button="<?php echo $Language->get('button_next'); ?>">
                <h2><?php echo $Language->get('heading_joyride_01'); ?></h2>
                <p><?php echo $Language->get('help_joyride_01'); ?></p>
            </li>
            <li data-class="htabs" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_02'); ?></h2>
                <p><?php echo $Language->get('help_joyride_02'); ?></p>
            </li>
            <li data-class="necoName" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_03'); ?></h2>
                <p><?php echo $Language->get('help_joyride_03'); ?></p>
            </li>
            <li data-class="necoImage" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_04'); ?></h2>
                <p><?php echo $Language->get('help_joyride_04'); ?></p>
            </li>
            <li data-class="necoQuantity" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_05'); ?></h2>
                <p><?php echo $Language->get('help_joyride_05'); ?></p>
            </li>
            <li data-class="necoStore" data-button="<?php echo $Language->get('button_next'); ?>" data-options="tipLocation:right">
                <h2><?php echo $Language->get('heading_joyride_06'); ?></h2>
                <p><?php echo $Language->get('help_joyride_06'); ?></p>
            </li>
            <li data-button="<?php echo $Language->get('button_close'); ?>">
                <h2><?php echo $Language->get('heading_joyride_final'); ?></h2>
                <p><?php echo $Language->get('help_joyride_final'); ?></p>
            </li>
        </ol>
        <script type="text/javascript" src="<?php echo HTTP_ADMIN_JS; ?>vendor/joyride/jquery.joyride-2.1.js"></script>
        <script>
            $(window).load(function() {
                $(document.createElement('link')).attr({
                    'href':'<?php echo HTTP_ADMIN_CSS; ?>joyride.css',
                    'rel':'stylesheet',
                    'media':'screen'
                }).appendTo('head');
            });
            $(function(){
                $('#necoBoy').on('click', function(e){
                    $('#stepsForm').joyride({
                        autoStart : true,
                        modal:false,
                        expose:true
                    });
                });
            });
        </script>
        
        <div class="clear"></div>
        
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <div id="languages" class="htabs">
                <?php foreach ($languages as $language) { ?>
                    <a tab="#language<?php echo $language['language_id']; ?>" class="htab"><img src="image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                <?php } ?>
                <?php foreach ($languages as $language) { ?>
                    <div id="language<?php echo $language['language_id']; ?>">
                    
                        <div class="row">
                            <label><?php echo $Language->get('entry_name'); ?></label>
                            <input id="download_description<?php echo $language['language_id']; ?>_name" name="download_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($download_description[$language['language_id']]) ? $download_description[$language['language_id']]['name'] : ''; ?>" required="true" style="width:40%" class="necoName" />
                        </div>
                        
                    </div>
            <?php } ?>
            </div>
            
            <div class="clear"></div>
            
            <div class="row">
                <label><?php echo $Language->get('entry_filename'); ?></label>
                <?php if (!empty($filename)) { ?>
                <input type="text" id="preview" value="<?php echo str_replace("data/","",$filename); ?>" disabled="disabled" style="width:40%" />
                <input type="hidden" name="download" id="download" value="<?php echo $filename; ?>" />
                <div class="clear"></div>
                <?php } else { ?>
                <a class="button necoImage" id="preview" onclick="file_upload('download', 'preview');">Seleccionar Archivo</a>
                <input type="hidden" name="download" id="download" value="" />
                <?php } ?>
                <br />
                <a onclick="file_upload('download', 'preview');" style="margin-left: 220px;color:#FFA500;font-size:10px">[ Cambiar ]</a>
                <a onclick="file_delete('download', 'preview');" style="color:#FFA500;font-size:10px">[ Quitar ]</a>
            </div>
            
            <div class="clear"></div>
            
            <div class="row">
                <label><?php echo $Language->get('entry_remaining'); ?></label>
                <input type="necoNumber" name="remaining" id="remaining" value="<?php echo $remaining; ?>" title="<?php echo $Language->get('help_remaining'); ?>" size="6" class="necoQuantity" />
            </div>
            
            <div class="clear"></div>
            
            <?php if ($show_update) { ?>
            <div class="row">
                <label><?php echo $Language->get('entry_update'); ?></label>
                <input title="<?php echo $Language->get('help_update'); ?>" type="checkbox" name="update" value="1"<?php if ($update) { ?> checked="checked"<?php } ?> />
            </div>
            
            <div class="clear"></div>
            <?php } ?>
                   
            <?php if ($stores) { ?>
            <div class="clear"></div>
            <div class="row">
                <label><?php echo $Language->get('entry_store'); ?></label><br />
                <input type="text" title="Filtrar listado de tiendas y sucursales" value="" name="q" id="q" placeholder="Filtrar Tiendas" />
                <div class="clear"></div>
                <a onclick="$('#storesWrapper input[type=checkbox]').attr('checked','checked');">Seleccionar Todos</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a onclick="$('#storesWrapper input[type=checkbox]').removeAttr('checked');">Seleccionar Ninguno</a>
                <div class="clear"></div>
                <ul id="storesWrapper" class="scrollbox necoStore">
                    <li class="stores">
                        <input type="checkbox" name="stores[]" value="0"<?php if (in_array(0, $_stores)) { ?> checked="checked"<?php } ?> showquick="off" />
                        <b><?php echo $Language->get('text_default'); ?></b>
                        <div class="clear"></div>
                    </li>
                <?php foreach ($stores as $store) { ?>
                    <li class="stores">
                        <input type="checkbox" name="stores[]" value="<?php echo (int)$store['store_id']; ?>"<?php if (in_array($store['store_id'], $_stores)) { ?> checked="checked"<?php } ?> showquick="off" />
                        <b><?php echo $store['name']; ?></b>
                        <div class="clear"></div>
                    </li>
                <?php } ?>
                </ul>
            </div> 
            <?php } else { ?>
                <input type="hidden" name="stores[]" value="0" />
            <?php } ?>
            
            <div class="clear"></div><br />
        </form>
    </div>
</div>
<div class="sidebar" id="feedbackPanel">
    <div class="tab"></div>
    <div class="content">
        <h2>Sugerencias</h2>
        <p style="margin: -10px auto 0px auto;">Tu opini&oacute;n es muy importante, dinos que quieres cambiar.</p>
        <form id="feedbackForm">
            <textarea name="feedback" id="feedback" cols="60" rows="10"></textarea>
            <input type="hidden" name="account_id" id="account_id" value="<?php echo C_CODE; ?>" />
            <input type="hidden" name="domain" id="domain" value="<?php echo HTTP_DOMAIN; ?>" />
            <input type="hidden" name="server_ip" id="server_ip" value="<?php echo $_SERVER['SERVER_ADDR']; ?>" />
            <input type="hidden" name="remote_ip" id="remote_ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
            <input type="hidden" name="server" id="server" value="<?php echo serialize($_SERVER); ?>" />
            <div class="clear"></div>
            <br />
            <div class="buttons"><a class="button" onclick="sendFeedback()">Enviar Sugerencia</a></div>
        </form>
    </div>
</div>
<div class="sidebar" id="toolPanel">
    <div class="tab"></div>
    <div class="content">
        <h2>Herramientas</h2>
        <p>S&aacute;cale provecho a NecoTienda y aumenta tus ventas.</p>
        <ul>
            <li><a onclick="$('#addsWrapper').slideDown();$('html, body').animate({scrollTop:$('#addsWrapper').offset().top}, 'slow');">Agregar Productos</a></li>
            <li><a class="trends" data-fancybox-type="iframe" href="http://www.necotienda.com/index.php?route=api/trends&q=samsung&geo=VE">Evaluar Palabras Claves</a></li>
            <li><a>Eliminar Esta Categor&iacute;a</a></li>
        </ul>
        <div class="toolWrapper"></div>
    </div>
</div>
<div class="sidebar" id="helpPanel">
    <div class="tab"></div>
    <div class="content">
        <h2>Ayuda</h2>
        <p>No entres en p&aacute;nico, todo tiene una soluci&oacute;n.</p>
        <ul>
            <li><a>&iquest;C&oacute;mo se come esto?</a></li>
            <li><a>&iquest;C&oacute;mo relleno este formulario?</a></li>
            <li><a>&iquest;Qu&eacute; significan las figuritas al lado de los campos?</a></li>
            <li><a>&iquest;C&oacute;mo me desplazo a trav&eacute;s de las pesta&ntilde;as?</a></li>
            <li><a>&iquest;Pierdo la informaci&oacute;n si me cambio de pesta&ntilde;a?</a></li>
            <li><a>Preguntas Frecuentes</a></li>
            <li><a>Manual de Usuario</a></li>
            <li><a>Videos Tutoriales</a></li>
            <li><a>Auxilio, por favor ay&uacute;denme!</a></li>
        </ul>
    </div>
</div>
<?php echo $footer; ?>