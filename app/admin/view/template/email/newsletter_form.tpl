<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if (isset($mostrarError)) {
    echo $mostrarError;
} ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/product.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="if (confirm('Se borrar&aacute;n todos los cambios que no hayan sido guardados. &iquest;Est&aacute; seguro que desea salir?')) { location = '<?php echo $cancel; ?>'; }" class="button"><span><?php echo $button_exit; ?></span></a></div>
  </div>
  <div class="content">
    <div id="tabs" class="htabs"><a tab="#tab_general"><?php echo $tab_general; ?></a><a tab="#tab_content"><?php echo $tab_content; ?></a><a tab="#tab_check"><?php echo $tab_check; ?></a><a tab="#tab_send"><?php echo $tab_send; ?></a></div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div id="tab_general">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?><a title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante"> (?)</a></td>
            <td colspan="2"><input title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante" type="text" name="name" value="<?php echo $name; ?>">
              <?php if (isset($error_name)) { ?>
              <span class="error"><?php echo $error_name; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_description; ?><a title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante"> (?)</a></td>
            <td colspan="2"><input title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante" type="text" name="description" value="<?php echo $description; ?>">
              <?php if (isset($error_description)) { ?>
              <span class="error"><?php echo $error_description; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_format; ?><a title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante"> (?)</a></td>
            <td colspan="2">
               <select name="format" id="format" value="<?php echo $format; ?>">
            	 <?php echo $format_list; ?>
               </select>
            </td>
          </tr>
          <tr id="trtpl">
            <td><?php echo $entry_template; ?><a title="Selecciona la plantilla de tu tienda. Esta modifica completamente la intefaz de la tienda para tus clientes"> (?)</a></td>
            <td><select name="email_template" id="email_template" size="10" onChange="$('#template').load('index.php?route=email/newsletter/template&token=<?php echo $token; ?>&template=' + encodeURIComponent(this.value));">
            <?php if ($my_templates) echo $my_templates; ?>
                <?php foreach ($templates as $key => $template) { ?>
                <?php if ($template == $config_template) { ?>
                <option value="<?php echo $template; ?>" selected="selected"><?php echo $template; ?></option>
                <?php } else { 
                   if (is_array($template)) { ?>
                   <optgroup label="<?php echo $key; ?>">
                    <?php foreach ($template as $tpl) { ?>
                <option value="<?php echo $key .'-'. $tpl; ?>"><?php echo $tpl; ?></option>
                   <?php } ?>
                   </optgroup>
                <?php } else  { ?>
                <option value="<?php echo $template; ?>"><?php echo $template; ?></option>
                <?php } ?>
                <?php } ?>
                <?php } ?>
              </select>
  			  </td>
              <td  style="height:250px" id="template"></td>
          </tr>
            <tr id="trtplbtn"><td colspan="3" style="text-align:center">
              <div class="buttons"><a onclick="readPremadeTemplate(this)" class="button"><span><?php echo $button_generate; ?></span></a></div></td>
           </tr>
           </tr>
        </table>
        </div>
      <div id="tab_content">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_subject; ?><a title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante"> (?)</a></td>
            <td><input title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante" type="text" name="subject" id="subject" value="<?php echo $subject; ?>">
              <?php if (isset($error_subject)) { ?>
              <span class="error"><?php echo $error_subject; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_category; ?><a title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores"> (?)</a></td>
            <td>
              <select name="category" onChange="getProducts()">
                 <option value="">Selecciona un categor&iacute;a</option>
                <?php foreach ($categories as $category) { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                <?php } ?>
                </select>
              </td>
          </tr>
          <tr>
            <td id="products" colspan="2"></td>
          </tr>
          <tr id="trhtml">
            <td style="vertical-align:top"><span class="required">*</span> <?php echo $entry_html_content; ?><a title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante"> (?)</a></td>
            <td id="htmleditor"><textarea title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante" name="htmlbody" id="htmlbody"><?php if (isset($htmlbody)) echo $htmlbody; ?></textarea>            </td>
            <textarea style="display:none" name="htmlbody_" id="htmlbody_"><?php if (isset($htmlbody)) echo $htmlbody; ?></textarea>
          </tr>
          <tr id="trtext">
            <td style="vertical-align:top"><span class="required">*</span> <?php echo $entry_text_content; ?><a title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante"> (?)</a></td>
            <td id="texteditor"><textarea title="Ingrese el modelo del producto, le recomendamos que se base en el mismo modelo establecido por el fabricante" name="textbody" id="textbody" cols="150" rows="15"><?php if (isset($textbody)) echo $textbody; ?></textarea>
            </td>
          </tr>
        </table>
      </div>
      <div id="tab_check">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_from_name; ?><a title="Ingrese el nombre del cup&oacute;n. Le recomendamos 	que utilice nombres descriptivos y que hagan referencia a alguna promoci&oacute;n"> (?)</a></td>
            <td><input type="text" name="from_name" id="from_name" value="<?php echo $from_name; ?>">
              <?php if (isset($error_from_name)) { ?>
              <span class="error"><?php echo $error_from_name; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_from_email; ?><a title="Ingrese la descripci&oacute;n del cup&oacute;n, enti&eacute;ndase que es lo mismo que un descuento"> (?)</a></td>
            <td><input type="email" name="from_email" id="from_email" value="<?php echo $from_email; ?>">
              <?php if (isset($error_from_email)) { ?>
              <span class="error"><?php echo $error_from_email; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_replyto_email; ?><a title="Ingrese la descripci&oacute;n del cup&oacute;n, enti&eacute;ndase que es lo mismo que un descuento"> (?)</a></td>
            <td><input type="email" name="replyto_email" id="replyto_email" value="<?php echo $replyto_email; ?>">
              <?php if (isset($error_replyto_email)) { ?>
              <span class="error"><?php echo $error_replyto_email; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span><?php echo $entry_bounce_email; ?><a title="Ingrese la descripci&oacute;n del cup&oacute;n, enti&eacute;ndase que es lo mismo que un descuento"> (?)</a></td>
            <td><input type="email" name="bounce_email" id="bounce_email" value="<?php echo $bounce_email; ?>">
              <?php if (isset($error_bounce_email)) { ?>
              <span class="error"><?php echo $error_bounce_email; ?></span>
              <?php } ?></td>
          </tr>
          <tr id="trlists">
            <td><?php echo $entry_lists; ?><a title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores"> (?)</a></td>
            <?php if (isset($_GET['newsletter_id'])) { ?>
            <td>Seleeccionar Todos&nbsp;<input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'list_id\']').attr('checked', this.checked);">
            <div class="scrollbox">
                <?php $class = 'odd'; ?>
                <?php foreach ($lists as $list) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <?php if (in_array($list['list_id'], $list_id)) { ?>
                  <input title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores" type="checkbox" name="list_id[]" value="<?php echo $list['list_id']; ?>" checked="checked">
                  <?php echo $list['name'].' ('.$list['total'].')'; ?>
                  <?php  } else {  ?>
                  <input title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores" type="checkbox" name="list_id[]" value="<?php echo $list['list_id']; ?>">
                  <?php echo $list['name'].' ('.$list['total'].')'; ?>
                  <?php } ?>
                </div>
                <?php } ?>
              </div>
              <div style="margin:5px 0 0 150px"><a id="btn_list" class="button"><span>listo</span></a></div>
              <?php if (isset($error_lists)) { ?>
              <span class="error"><?php echo $error_lists; ?></span>
              <?php } ?>
             </td>
             <?php } else { ?>
             <td><h1>Primero debe guardar esta campa&ntilde;a para poder selecionar las listas de miembros</h1></td>
             <?php } ?>
          </tr>              
          <tr id="trmembers">
            <td><?php echo $entry_member; ?><a title="Seleccione en cuales categor&iacute;as desea que aparezca el producto. Hay casos en los que el mismo producto encaja en diferentes categor&iacute;as, por ejemplo un televisor de tercera generaci&oacute;n puede ser utilizado como monitor de un computador o como un simple televisor, por lo que estar&iacute;a en las categor&iacute;as monitores y televisores"> (?)</a></td>
            <td id="tdmembers"></td>
          </tr>
           <tr>
            <td><span class="required">*</span> <?php echo $entry_trace_open; ?><a title="Ingrese la descripci&oacute;n del cup&oacute;n, enti&eacute;ndase que es lo mismo que un descuento"> (?)</a></td>
            <td><?php if ($trace_email == 1) { ?>
                <input type="checkbox" name="trace_email" value="1" checked="checked">
                <?php } else { ?>
                <input type="checkbox" name="trace_email" value="1">
                <?php } ?></td>
          </tr>
           <tr>
            <td><span class="required">*</span> <?php echo $entry_trace_click; ?><a title="Ingrese la descripci&oacute;n del cup&oacute;n, enti&eacute;ndase que es lo mismo que un descuento"> (?)</a></td>
            <td><?php if ($trace_click == 1) { ?>
                <input type="checkbox" name="trace_click" value="1" checked="checked">
                <?php } else { ?>
                <input type="checkbox" name="trace_click" value="1">
                <?php } ?>
          </tr>
        </table>
      </div>
      <div id="tab_send">
        <table class="form">
          <tr>
            <?php if (isset($_GET['newsletter_id'])) { ?>
            <td style="border-color:#FC0">
              <div class="buttons" id="check_email"><a id="btn_check_email" class="button"><span>Chequear Campa&ntilde;a</span></a></div>
            </td>            
             <?php } else { ?>
             <td><h1>Primero debe guardar esta campa&ntilde;a para poder enviarla</h1></td>
             <?php } ?>
          </tr>
        </table>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace('htmlbody',{
	height: 500,
	});
function readPremadeTemplate() {
	jQuery.ajax({
		type: 'GET',
		url: 'index.php?route=email/newsletter/readPremadeTemplate&token=<?php echo $token; ?>&template=' + encodeURIComponent($('select[name=\'email_template\']').val()),
		beforeSend: function() {},
		success: function(data){
			CKEDITOR.instances.htmlbody.setData(data);
			jquery("#htmlbody_").val(data);
			CKEDITOR.config.fullPage = true;
		}
	});	
}
function getProducts() {
	jQuery('#products').load('index.php?route=email/newsletter/products&token=<?php echo $token; ?>&category_id=' + encodeURIComponent($('select[name=\'category\']').val()));
}





</script>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("#htmleditor").droppable({
		drop: function(event, ui) {
			jQuery.ajax({
				type: 'GET',
				url: 'index.php?route=email/newsletter/getProduct&token=<?php echo $token; ?>&product_id=' + encodeURIComponent($('input[name=\'pid\']').val()),
				beforeSend: function() {
					
				},
				success: function(data){
					CKEDITOR.instances.htmlbody.insertHtml(data);
				}
			});	
		}
	});
	jQuery("#texteditor").droppable({
		drop: function(event, ui) {
			jQuery.ajax({
				type: 'GET',
				url: 'index.php?route=email/newsletter/getProduct&token=<?php echo $token; ?>&format=t&product_id=' + encodeURIComponent($('input[name=\'pid\']').val()),
				beforeSend: function() {
					
				},
				success: function(data){
					jQuery('#textbody').val(jQuery('#textbody').val()+data);
				}
			});	
		}
	});
	if ((jQuery('select[name=\'format\']').val() == 'h') || (jQuery('select[name=\'format\']').val() == 'a')) {
		jQuery('#trtpl').show();
		jQuery('#trtplbtn').show();	
		jQuery('#trhtml').show();jQuery('#trtext').hide();
		if (jQuery('select[name=\'format\']').val() == 'a') {
			jQuery('#trtext').show();
		}
	} else {
		jQuery('#trtpl').hide();
		jQuery('#trtplbtn').hide();
		jQuery('#trtext').show();
		jQuery('#trhtml').hide();
	}
		jQuery("#trmembers").hide();

});
jQuery('select[name=\'format\']').change(function() {
	if ((jQuery('select[name=\'format\']').val() == 'h') || (jQuery('select[name=\'format\']').val() == 'a')) {
		jQuery('#trtpl').fadeIn();
		jQuery('#trtplbtn').fadeIn();	
		jQuery('#trhtml').show();
		jQuery('#trtext').hide();
		if (jQuery('select[name=\'format\']').val() == 'a') {
			jQuery('#trtext').show();
		}
	} else {
		jQuery('#trtpl').fadeOut();
		jQuery('#trtplbtn').fadeOut();
		jQuery('#trtext').show();
		jQuery('#trhtml').hide();
	}
});
jQuery("#btn_list").click(function(){
	var list_id = jQuery("#form").serialize();
	jQuery.ajax({
		type: 'POST',
		url: 'index.php?route=email/newsletter/membersByList&token=<?php echo $token; ?>',
		dataType: 'html',
		data: 'list_id='+list_id+'&newsletter_id='+<?php echo $_GET["newsletter_id"]; ?>,
		beforeSend: function() {
			jQuery("#trmembers").hide();
		},
		success: function(data){
			if (data == '1') {
				jQuery("#tdmembers").remove();
				jQuery("#trmembers").append("<td id='tdmembers'><h3>A&uacute;n no ha seleccionado ninguna lista</h3></td>");
				jQuery("#trmembers").fadeIn();
			} else {
				jQuery("#trlists").hide();
				jQuery("#tdmembers").remove();
				var html = '';
			    html += "<td id='tdmembers'>Seleeccionar Todos&nbsp;<input title='Seleccionar Todos' type='checkbox' onclick=\"$('input[name*=member_id]').attr('checked', this.checked);\">";
				html += data;
				html += "<div style='margin:5px 0 0 150px'><a id='btn_back' class='button' onclick='jQuery(\"#trmembers\").hide();jQuery(\"#trlists\").fadeIn();'><span>Atr&aacute;s</span></a><a id='btn_member' class='button'><span>Guardar Destinatarios</span></a></div></td>";
				html += '<script>';
				html += 'jQuery("#btn_member").click(function(){';
				html += 'var lists_members = jQuery("#form").serialize();';
				html += 'jQuery.ajax({';
				html += 'type:"POST",dataType:"html",url:"index.php?route=email/newsletter/saveMembers&token=<?php echo $token; ?>",data:"members="+encodeURIComponent(lists_members)+"&newsletter_id="+<?php echo $_GET["newsletter_id"]; ?>,';
				html += 'success:function(data){if (data == "1") {alert("Debe seleccionar al menos un miembro");} else {alert("Los miembros destinatarios han sido registrado satisfactoriamente");}}';
				html += '});';
				html += '});';
				html += "<\/script>";
				jQuery("#trmembers").append(html);
				jQuery("#trmembers").fadeIn();
			}
		}
	});	
});

jQuery("#btn_check_email").click(function(){
    var htmlbody = CKEDITOR.instances.htmlbody.getData();
    var textbody = jQuery('#textbody').val();
    var format = jQuery('#format').val();
	jQuery.ajax({
		type: 'POST',
		url: 'index.php?route=email/newsletter/checkEmail&token=<?php echo $token; ?>',
		dataType: 'html',
		data: 'format='+format+'&textbody='+encodeURIComponent(textbody)+'&htmlbody='+encodeURIComponent(htmlbody)+'&tkn=<?php echo $token; ?>&newsletter_id='+<?php echo isset($_GET["newsletter_id"]) ? $_GET["newsletter_id"] : ''; ?>,
		beforeSend: function() {
			jQuery("#checkEmailResult").fadeOut();
            jQuery("#send_error").remove();
			jQuery("#btn_check_email").after("<p id='unMomento'>Un momento por favor...</p>");
		},
		success: function(data){
			jQuery("#unMomento").remove();
    		jQuery("#check_email").after(data);
            jQuery("#checkEmailResult").hide();
            jQuery("#checkEmailResult").fadeIn();
		}
	});	
});
</script>
<script type="text/javascript">
$.tabs('#tabs a'); 
</script>
<?php echo $footer; ?>