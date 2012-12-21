<?php echo $header; ?>
<?php if ($error_warning) { ?><div class="grid_24"><div class="message warning"><?php echo $error_warning; ?></div></div><?php } ?>

<div class="grid_24">
    <div class="box">
        <h1><?php echo $heading_title; ?></h1>
        <div class="buttons">
            <a onclick="saveAndExit();" class="button"><?php echo $button_save_and_exit; ?></a>
            <a onclick="saveAndKeep();" class="button"><?php echo $button_save_and_keep; ?></a>
            <a onclick="saveAndNew();" class="button"><?php echo $button_save_and_new; ?></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
        </div>
    </div>
</div>

<div class="clear"></div>
        
<div class="grid_8">
    <div class="box">
        <h2>Datos del Men&uacute;</h2>
        <div class="row">
            <label class="neco-label">Nombre:</label>
            <input id="name" name="name" value="<?php echo $name; ?>" style="width:40%" />
        </div>
        <div class="row">
            <label class="neco-label">Ubicaci&oacute;n del Men&uacute;:</label>
            <select name="position">
                <option value="">Men&uacute; Principal</option>
                <option value="">Men&uacute; Usuario</option>
                <option value="">Men&uacute; Lateral</option>
                <option value="">Pie de P&aacute;gina Izquierda</option>
                <option value="">Pie de P&aacute;gina Centro</option>
                <option value="">Pie de P&aacute;gina Derecha</option>
                <option value="">Pie de P&aacute;gina General</option>
            </select>
        </div>
        <div class="row">
            <label class="neco-label">Estado:</label>
            <select name="status">
                <option value="1"<?php if ($status) { ?> selected="selected"<?php } ?>>Activado</option>
                <option value="0"<?php if (!$status) { ?> selected="selected"<?php } ?>>Desactivado</option>
            </select>
        </div>
    </div>
        
    <div class="clear"></div>
        
    <div class="box neco-form">
        <h2>Enlaces (URL)</h2>
        <div class="row">
            <label class="neco-label">Enlace</label>
            <input id="external_link" name="external_link" value="" style="width:40%" />
        </div>
        <div class="row">
            <label class="neco-label">Etiqueta</label>
            <input id="external_tag" name="external_tag" value="" style="width:40%" />
        </div>
        <div class="clear"></div>
        <a class="button" onclick="addLink('<?php echo $_GET['token']; ?>')">Agregar al men&uacute;</a>
    </div>
        
    <div class="clear"></div>
        
    <?php if ($pages) { ?>
    <div class="box">
        <h2>P&aacute;ginas</h2>
        <input name="qp" id="qp" value="Buscar..." onfocus="if (this.value=='Buscar...') {this.value=''}" onchange="ntSearch(this.value,'pagesWrapper')" />
        <div class="row">
            <ul id="pagesWrapper" class="scrollbox" style="width:96%;"><?php echo $pages; ?></ul>
        </div>
        <div class="clear"></div>
        <a class="button" onclick="addPage('<?php echo $_GET['token']; ?>')">Agregar al men&uacute;</a>
    </div>
        
    <div class="clear"></div>
    <?php } ?>
        
    <?php if ($categories) { ?>
    <div class="box">
        <h2>Categor&iacute;as de Productos</h2>
        <input name="qc" id="qc" value="Buscar..." onfocus="if (this.value=='Buscar...') {this.value=''}" onchange="ntSearch(this.value,'categoriesWrapper')" />
        <div class="row">
            <ul id="categoriesWrapper" class="scrollbox" style="width:96%;"><?php echo $categories; ?></ul>
        </div>
        <div class="clear"></div>
        <a class="button" onclick="addCategory('<?php echo $_GET['token']; ?>')">Agregar al men&uacute;</a>
    </div>
        
    <div class="clear"></div>
    <?php } ?>
    
    <?php if ($post_categories) { ?>
    <div class="box">
        <h2>Categor&iacute;as de Art&iacute;culos</h2>
        <input name="qpc" id="qpc" value="Buscar..." onfocus="if (this.value=='Buscar...') {this.value=''}" onchange="ntSearch(this.value,'post_categoriesWrapper')" />
        <div class="row">
            <ul id="post_categoriesWrapper" class="scrollbox" style="width:96%;"><?php echo $post_categories; ?></ul>
        </div>
        <div class="clear"></div>
        <a class="button" onclick="addPostCategory('<?php echo $_GET['token']; ?>')">Agregar al men&uacute;</a>
    </div>
        
    <div class="clear"></div>
    <?php } ?>
        
</div>

<div class="grid_15">
    <div class="box">
        <h2>Enlaces del Men&uacute;</h2>
        <form action="<?php echo $action; ?>" method="post" class="neco-form" id="formMenu">
            <ol class="items">
                <?php echo $links; ?>
            </ol>
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
