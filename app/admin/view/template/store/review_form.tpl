<?php echo $header; ?>
<?php if ($error_warning) { ?><div class="grid_24"><div class="message warning"><?php echo $error_warning; ?></div></div><?php } ?>
<div class="box">
        <h1><?php echo $heading_title; ?></h1>
        <div class="buttons">
            <a onclick="saveAndExit();$('#form').submit();" class="button"><?php echo $button_save_and_exit; ?></a>
            <a onclick="saveAndKeep();$('#form').submit();" class="button"><?php echo $button_save_and_keep; ?></a>
            <a onclick="saveAndNew();$('#form').submit();" class="button"><?php echo $button_save_and_new; ?></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
        </div>
        
        <div class="clear"></div>
                                
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

            <div class="row">
                <label><?php echo $entry_author; ?></label>
                <input id="author" name="author" value="<?php echo $author; ?>" required="true" style="width:40%" />
            </div>
                        
            <div class="clear"></div>
                            
            <div class="row">
                <label><?php echo $entry_product; ?></label>
                <b id="product_name"><?php echo $product; ?></b>
                <input type="hidden" name="product_id" id="product_id" value="<?php echo (int)$product_id; ?>" />
            </div>
            
            <div class="clear"></div>
            
            <div class="row">
                <label><?php echo $entry_text; ?></label>
                <textarea id="text" name="text" style="width:40%"><?php echo $text; ?></textarea>
            </div>
                   
            <div class="clear"></div><br />
            
            <div class="row">
                <label><?php echo $entry_rating; ?></label>
                <b class="rating" style="float: left;"><?php echo $entry_bad; ?></b>&nbsp;
                <input type="radio" name="rating" value="1" showquick="off" style="margin-right:10px;width:10px;height:10px;"<?php if ($rating == 1) { ?> checked="checked"<?php } ?> />&nbsp;
                <input type="radio" name="rating" value="2" showquick="off" style="margin-right:10px;width:10px;height:10px;"<?php if ($rating == 2) { ?> checked="checked"<?php } ?> />&nbsp;
                <input type="radio" name="rating" value="3" showquick="off" style="margin-right:10px;width:10px;height:10px;"<?php if ($rating == 3) { ?> checked="checked"<?php } ?> />&nbsp;
                <input type="radio" name="rating" value="4" showquick="off" style="margin-right:10px;width:10px;height:10px;"<?php if ($rating == 4) { ?> checked="checked"<?php } ?> />&nbsp;
                <input type="radio" name="rating" value="5" showquick="off" style="margin-right:10px;width:10px;height:10px;"<?php if ($rating == 5) { ?> checked="checked"<?php } ?> />&nbsp;
                <b class="rating" style="float: left;"><?php echo $entry_good; ?></b>
            </div>
                   
            <div class="clear"></div><br />
            
            <div class="row">
                <label><?php echo $entry_status; ?></label>
                <select name="status">
                      <option value="1"<?php if ($status) { ?> selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                      <option value="0"<?php if (!$status) { ?> selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                </select>
            </div>
                   
            <div class="clear"></div><br />
            
            <div id="addProductsPanel"><b>Agregar / Modificar Producto Asociado</b></div>
            <div id="addProductsWrapper"><div id="gridPreloader"></div></div>
            
            <div class="clear"></div><br />
            
        </form>
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
            <li><a onclick="$('#addProductsWrapper').slideDown();$('html, body').animate({scrollTop:$('#addProductsWrapper').offset().top}, 'slow');">Agregar Productos</a></li>
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