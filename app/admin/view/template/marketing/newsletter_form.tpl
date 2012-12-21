<?php echo $header; ?>
<?php if ($error_warning) { ?><div class="warning"><?php echo $error_warning; ?></div><?php } ?>
<div class="box">
        <h1><?php echo $heading_title; ?></h1>
        <div class="buttons">
            <a onclick="saveAndExit();$('#form').submit();" class="button"><?php echo $button_save_and_exit; ?></a>
            <a onclick="saveAndKeep();$('#form').submit();" class="button"><?php echo $button_save_and_keep; ?></a>
            <a onclick="saveAndNew();$('#form').submit();" class="button"><?php echo $button_save_and_new; ?></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
        </div>
        
        <div class="clear"></div>
        <p><b>NOTA:</b> Para disfrutar de las nuevas virtudes de la aplicaci&oacute;n, debes utilizar <a href="http://www.mozilla.org/es-ES/download/?product=firefox-16.0.2&os=win&lang=es-ES" title="Descargar Mozilla" target="_blank">Mozilla Firefox</a> o <a href="https://www.google.com/intl/es/chrome/browser/?hl=es" title="Descargar Google Chrome" target="_blank">Google Chrome</a> en sus &uacute;ltimas versiones.</p>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        
            <div class="row">
                <label><?php echo $entry_name; ?></label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>" required="required" style="width:40%" />
            </div>
            
            <div class="row">
                <label><?php echo $entry_template; ?></label>
                <select name="email_template" id="email_template" size="10" onchange="readPremadeTemplate();" style="width:40%;height:150px;">
                <?php foreach ($templates as $key => $template) { ?>                    
                    <?php if (is_array($template)) { ?>
                        <optgroup label="<?php echo $key; ?>">
                        <?php foreach ($template as $tpl) { ?>
                            <option value="<?php echo $key .'.'. $tpl; ?>"><?php echo $tpl; ?></option>
                        <?php } ?>
                       </optgroup>
                    <?php } else { ?>
                        <option value="<?php echo $template; ?>"<?php if ($template == $config_template) { ?> selected="selected"<?php } ?>><?php echo $template; ?></option>
                   <?php } ?>
                   
                <?php } ?>
                </select>
            </div>
            
            <div class="row">
                <label><?php echo $entry_category; ?></label>
                <select name="category" onchange="getProducts()" style="width:40%">
                    <option value="">Selecciona un categor&iacute;a</option>
                    <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                    <?php } ?>
                </select>
                <div id="products"></div>
            </div>
            
            <div class="row">
                <label><?php echo $entry_html_content; ?></label>
                <div class="clear"></div><br />
                <textarea name="htmlbody" id="htmlbody" required="required"><?php if (isset($htmlbody)) echo $htmlbody; ?></textarea>
            </div>
            
            <div class="row">
                <label><?php echo $entry_text_content; ?></label>
                <div class="clear"></div><br />
                <textarea name="textbody" id="textbody" rows="15" style="width:80%" required="required"><?php if (isset($textbody)) echo $textbody; ?></textarea>
            </div>
            
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