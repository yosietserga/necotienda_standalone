<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/customer.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <div style="display: inline-block; width: 100%;">
      <div id="vtabs" class="vtabs"><a  tab="#tab_general"><?php echo $tab_general; ?></a>
        <?php $address_row = 1; ?>
        <?php foreach ($addresses as $address) { ?>
        <a  id="address_<?php echo $address_row; ?>" tab="#tab_address_<?php echo $address_row; ?>"><?php echo $tab_address . ' ' . $address_row; ?><span title="Eliminar Direcci&oacute;n" onclick="$('#vtabs a:first').trigger('click'); $('#address_<?php echo $address_row; ?>').remove(); $('#tab_address_<?php echo $address_row; ?>').remove();" class="remove">&nbsp;</span></a>
        <?php $address_row++; ?>
        <?php } ?>
        <span title="Agregar Direcci&oacute;n" id="address_add" onclick="addAddress();" class="add" style="float: right; margin-right: 14px; font-size: 13px; font-weight: bold;">Agregar&nbsp;</span></div>
      <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab_general" class="vtabs_page">
          <table class="form">
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_rif; ?></span><a title="<?php echo $help_rif; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_rif; ?>" type="text" name="rif" id="rif" value="<?php echo $rif; ?>">
                <?php if ($error_rif) { ?>
                <span class="error"><?php echo $error_rif; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_company; ?></span><a title="<?php echo $help_company; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_company; ?>" type="text" name="company" id="company" value="<?php echo $company; ?>">
                <?php if ($error_company) { ?>
                <span class="error"><?php echo $error_company; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_firstname; ?></span><a title="<?php echo $help_firstname; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_firstname; ?>" name="firstname" value="<?php echo $firstname; ?>">
                <?php if ($error_firstname) { ?>
                <span class="error"><?php echo $error_firstname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_lastname; ?></span><a title="<?php echo $help_lastname; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_lastname; ?>" name="lastname" value="<?php echo $lastname; ?>">
                <?php if ($error_lastname) { ?>
                <span class="error"><?php echo $error_lastname; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_email; ?><a title="<?php echo $help_email; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_email; ?>" type="email" name="email" value="<?php echo $email; ?>">
                <?php if ($error_email) { ?>
                <span class="error"><?php echo $error_email; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_sexo; ?><a title="<?php echo $help_sexo; ?>"> (?)</a></td>
              <td><select name="sexo" title="<?php echo $help_sexo; ?>">
                <option value="false"><?php echo $text_sexo; ?></option>
                <?php if ($sexo == 'm') { ?>
                    <option value="m" selected="selected"><?php echo $text_man; ?></option>                    
                <?php } else { ?>
                    <option value="m"><?php echo $text_man; ?></option>                     
                <?php } ?>
                <?php if ($sexo == 'f') { ?>
                    <option value="f" selected="selected"><?php echo $text_woman; ?></option>                    
                <?php } else { ?>
                    <option value="f"><?php echo $text_woman; ?></option>                    
                <?php } ?>
              </select>
                <?php if ($error_sexo) { ?>
                <span class="error"><?php echo $error_sexo; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <?php echo $entry_telephone; ?><a title="<?php echo $help_telephone; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_telephone; ?>" name="telephone" value="<?php echo $telephone; ?>">
                <?php if ($error_telephone) { ?>
                <span class="error"><?php echo $error_telephone; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_fax; ?><a title="<?php echo $help_fax; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_fax; ?>" type="text" name="fax" value="<?php echo $fax; ?>"></td>
            </tr>
            <tr>
              <td><span class="required">*</span><?php echo $entry_password; ?><a title="<?php echo $help_password; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_password; ?>" type="password" name="password" value="<?php echo $password; ?>">
                <br>
                <?php if ($error_password) { ?>
                <span class="error"><?php echo $error_password; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span><?php echo $entry_confirm; ?><a title="<?php echo $help_confirm; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_confirm; ?>" type="password" name="confirm" value="<?php echo $confirm; ?>">
                <?php if ($error_confirm) { ?>
                <span class="error"><?php echo $error_confirm; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_facebook; ?><a title="<?php echo $help_facebook; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_facebook; ?>" name="facebook" value="<?php echo $facebook; ?>"></td>
            </tr>
            <tr>
              <td><?php echo $entry_twitter; ?><a title="<?php echo $help_twitter; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_twitter; ?>" name="twitter" value="<?php echo $twitter; ?>"></td>
            </tr>
            <tr>
              <td><?php echo $entry_msn; ?><a title="<?php echo $help_msn; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_msn; ?>" type="email" name="msn" value="<?php echo $msn; ?>"></td>
            </tr>
            <tr>
              <td><?php echo $entry_yahoo; ?><a title="<?php echo $help_yahoo; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_yahoo; ?>" type="email" name="yahoo" value="<?php echo $yahoo; ?>"></td>
            </tr>
            <tr>
              <td><?php echo $entry_gmail; ?><a title="<?php echo $help_gmail; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_gmail; ?>" type="email" name="gmail" value="<?php echo $gmail; ?>"></td>
            </tr>
            <tr>
              <td><?php echo $entry_skype; ?><a title="<?php echo $help_skype; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_skype; ?>" name="skype" value="<?php echo $skype; ?>"></td>
            </tr>
            <tr>
              <td><?php echo $entry_profesion; ?><a title="<?php echo $help_profesion; ?>"> (?)</a></td>
              <td>
              	<select name="profesion" class="select" title="<?php echo $help_profesion; ?>">
                <?php if (!empty($profesion)) { //TODO: colocar las profesiones y los titulos en variables de idiomas ?>
                  <option value="<?php echo $profesion; ?>"><?php echo $profesion; ?></option>
                <?php } ?>
                  <option value="">Seleccione una profesi&oacute;n</option>
                  <option value="Estudiante">Estudiante</option>
                  <option value="Agronom&iacute;a">Agronom&iacute;a</option>
                  <option value="Antropolog&iacute;a">Antropolog&iacute;a</option>
                  <option value="Arqueolog&iacute;a">Arqueolog&iacute;a</option>
                  <option value="Arquitectura">Arquitectura</option>
                  <option value="Artista">Artista</option>
                  <option value="Asesor&iacute;a y Consultor&iacute;a">Asesor&iacute;a y Consultor&iacute;a</option>
                  <option value="Astrolog&iacute;a">Astrolog&iacute;a</option>
                  <option value="Astronom&iacute;a">Astronom&iacute;a</option>
                  <option value="Biolog&iacute;a">Biolog&iacute;a</option>
                  <option value="Cardiolog&iacute;a">Cardiolog&iacute;a</option>
                  <option value="Construcci&oacute;n">Construcci&oacute;n</option>
                  <option value="Contratista">Contratista</option>
                  <option value="Criminalista">Criminalista</option>
                  <option value="Decoraci&oacute;n">Decoraci&oacute;n</option>
                  <option value="Demograf&iacute;a">Demograf&iacute;a</option>
                  <option value="Derechos y Leyes">Derechos y Leyes</option>
                  <option value="Dermatolog&iacute;a">Dermatolog&iacute;a</option>
                  <option value="Dise&ntilde;o de Interiores">Dise&ntilde;o de Interiores</option>
                  <option value="Dise&ntilde;o Gr&aacute;fico">Dise&ntilde;o Gr&aacute;fico</option>
                  <option value="Dise&ntilde;o Web">Dise&ntilde;o Web</option>
                  <option value="Econom&iacute;a">Econom&iacute;a</option>
                  <option value="Educaci&oacute;n">Educaci&oacute;n</option>
                  <option value="Electricidad">Electricidad</option>
                  <option value="Electr&oacute;nica">Electr&oacute;nica</option>
                  <option value="Filosof&iacute;a">Filosof&iacute;a</option>
                  <option value="F&iacute;sica">F&iacute;sica</option>
                  <option value="Fotograf&iacute;a">Fotograf&iacute;a</option>
                  <option value="Geograf&iacute;a">Geograf&iacute;a</option>
                  <option value="Geolog&iacute;a">Geolog&iacute;a</option>
                  <option value="">Historia</option>
                  <option value="Historia">Inform&aacute;tica</option>
                  <option value="Internet">Internet</option>
                  <option value="Invenciones">Invenciones</option>
                  <option value="Inversiones">Inversiones</option>
                  <option value="Jardiner&iacute;a">Jardiner&iacute;a</option>
                  <option value="Matem&aacute;tica">Matem&aacute;tica</option>
                  <option value="Mec&aacute;nica Aeroespacial">Mec&aacute;nica Aeroespacial</option>
                  <option value="Mec&aacute;nica Aeron&aacute;utica">Mec&aacute;nica Aeron&aacute;utica</option>
                  <option value="Mec&aacute;nica Automotriz">Mec&aacute;nica Automotriz</option>
                  <option value="Mec&aacute;nica Industrial">Mec&aacute;nica Industrial</option>
                  <option value="Mec&aacute;nica Naval">Mec&aacute;nica Naval</option>
                  <option value="Medicina">Medicina</option>
                  <option value="Medico">Medico</option>
                  <option value="Metal&uacute;rjica">Metal&uacute;rjica</option>
                  <option value="Meteorolog&iacute;a">Meteorolog&iacute;a</option>
                  <option value="M&uacute;sica">M&uacute;sica</option>
                  <option value="Odontolog&iacute;a">Odontolog&iacute;a</option>
                  <option value="Periodismo">Periodismo</option>
                  <option value="Psicolog&iacute;a">Psicolog&iacute;a</option>
                  <option value="Psicopedagog&iacute;a">Psicopedagog&iacute;a</option>
                  <option value="Psicoterapia">Psicoterapia</option>
                  <option value="Psiquiatr&iacute;a">Psiquiatr&iacute;a</option>
                  <option value="Publicidad">Publicidad</option>
                  <option value="Qu&iacute;mica">Qu&iacute;mica</option>
                  <option value="Quiropr&aacute;ctica">Quiropr&aacute;ctica</option>
                  <option value="Redes y Telecomunicaciones">Redes y Telecomunicaciones</option>
                  <option value="Rob&oacute;tica">Rob&oacute;tica</option>
                  <option value="Seguridad">Seguridad</option>
                  <option value="Sexolog&iacute;a">Sexolog&iacute;a</option>
                  <option value="Sismolog&iacute;a">Sismolog&iacute;a</option>
                  <option value="Sociolog&iacute;a">Sociolog&iacute;a</option>
                  <option value="T&eacute;cnico">T&eacute;cnico</option>
                  <option value="Terapia">Terapia</option>
                  <option value="Veterinaria">Veterinaria</option>
                  <option value="Zoolog&iacute;a">Zoolog&iacute;a</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_titulo; ?><a title="<?php echo $help_titulo; ?>"> (?)</a></td>
              <td>
              	<select name="titulo" class="select" title="<?php echo $help_titulo; ?>">
                <?php if (!empty($titulo)) { //TODO: colocar las profesiones y los titulos en variables de idiomas ?>
                  <option value="<?php echo $titulo; ?>"><?php echo $titulo; ?></option>
                <?php } ?>
                  <option value="">Seleccione su t&iacute;tulo</option>
                  <option value="Bachiller">Bachiller</option>
                  <option value="T&eacute;cnico Medio">T&eacute;cnico Medio</option>
                  <option value="T&eacute;cnico Superior">T&eacute;cnico Superior</option>
                  <option value="Ingeniero">Ingeniero</option>
                  <option value="Licenciado">Licenciado</option>
                  <option value="Postgrado">Postgrado</option>
                  <option value="Especializaci&oacute;n">Especializaci&oacute;n</option>
                  <option value="Maestr&iacute;a">Maestr&iacute;a</option>
                  <option value="Doctorado">Doctorado</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_blog; ?><a title="<?php echo $help_blog; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_blog; ?>" type="url" name="blog" value="<?php echo $blog; ?>"></td>
            </tr>
            <tr>
              <td><?php echo $entry_website; ?><a title="<?php echo $help_website; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_website; ?>" type="url" name="website" value="<?php echo $website; ?>"></td>
            </tr>            
            <tr>
              <td><?php echo $entry_newsletter; ?><a title="<?php echo $help_newsletter; ?>"> (?)</a></td>
              <td><select name="newsletter">
                  <?php if ($newsletter) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_customer_group; ?><a title="<?php echo $help_customer_group; ?>"> (?)</a></td>
              <td><select name="customer_group_id">
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?><a title="<?php echo $help_status; ?>"> (?)</a></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
          </table>
        </div>
        <?php $address_row = 1; ?>
        <?php foreach ($addresses as $address) { ?>
        <div id="tab_address_<?php echo $address_row; ?>" class="vtabs_page">
          <table class="form">
          <input  type="hidden" name="addresses[<?php echo $address_row; ?>][firstname]" value="<?php echo $firstname; ?>">
          <input  type="hidden" name="addresses[<?php echo $address_row; ?>][lastname]" value="<?php echo $lastname; ?>">
          <input  type="hidden" name="addresses[<?php echo $address_row; ?>][company]" value="<?php echo $company; ?>">
            <tr>
              <td><?php echo $entry_address_1; ?><a title="<?php echo $help_address_1; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_address_1; ?>" name="addresses[<?php echo $address_row; ?>][address_1]" value="<?php echo $address['address_1']; ?>" size="100"></td>
            </tr>
            <tr>
              <td><?php echo $entry_address_2; ?><a title="<?php echo $help_address_2; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_address_2; ?>" name="addresses[<?php echo $address_row; ?>][address_2]" value="<?php echo $address['address_2']; ?>" size="100"></td>
            </tr>
            <tr>
              <td><?php echo $entry_city; ?><a title="<?php echo $help_city; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_city; ?>" name="addresses[<?php echo $address_row; ?>][city]" value="<?php echo $address['city']; ?>"></td>
            </tr>
            <tr>
              <td><?php echo $entry_postcode; ?><a title="<?php echo $help_postcode; ?>"> (?)</a></td>
              <td><input title="<?php echo $help_postcode; ?>" name="addresses[<?php echo $address_row; ?>][postcode]" value="<?php echo $address['postcode']; ?>"></td>
            </tr>
            <tr>
              <td><?php echo $entry_country; ?><a title="<?php echo $help_country; ?>"> (?)</a></td>
              <td><select name="addresses[<?php echo $address_row; ?>][country_id]" id="addresses[<?php echo $address_row; ?>][country_id]" onChange="$('select[name=\'addresses[<?php echo $address_row; ?>][zone_id]\']').load('index.php?r=sale/customer/zone&token=<?php echo $token; ?>&country_id=' + this.value + '&zone_id=<?php echo $address['zone_id']; ?>');">
                  <option value="false"><?php echo $text_select; ?></option>
                  <?php foreach ($countries as $country) { ?>
                  <?php if ($country['country_id'] == $address['country_id']) { ?>
                  <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                <?php if ($error_country) { ?>
                <span class="error"><?php echo $error_country; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_zone; ?><a title="<?php echo $help_zone; ?>"> (?)</a></td>
              <td><select name="addresses[<?php echo $address_row; ?>][zone_id]">
                </select>
                <?php if ($error_zone) { ?>
                <span class="error"><?php echo $error_zone; ?></span>
                <?php } ?></td>
            </tr>
          </table>
          <script type="text/javascript">
		  $('select[name=\'addresses[<?php echo $address_row; ?>][zone_id]\']').load('index.php?r=sale/customer/zone&token=<?php echo $token; ?>&country_id=<?php echo $address["country_id"]; ?>&zone_id=<?php echo $address["zone_id"]; ?>');
		  </script> 
        </div>
        <?php $address_row++; ?>
        <?php } ?>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
var address_row = <?php echo $address_row; ?>;

function addAddress() {	
	html  = '<div id="tab_address_' + address_row + '" class="vtabs_page">';
	html += '<table class="form">'; 
    html += '<input  type="hidden" name="addresses[' + address_row + '][firstname] value="<?php echo $firstname; ?>">';
    html += '<input  type="hidden" name="addresses[' + address_row + '][lastname]" value="<?php echo $lastname; ?>">';
    html += '<input  type="hidden" name="addresses[' + address_row + '][company]" value="<?php echo $company; ?>">';
    html += '<tr>';
    html += '<td><?php echo $entry_address_1; ?><a title="Ingrese la direcci&oacute;n principal del cliente"> (?)</a></td>';
    html += '<td><input  type="text" name="addresses[' + address_row + '][address_1]" value=""></td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td><?php echo $entry_address_2; ?><a title="Ingrese la direcci&oacute;n alterna del cliente"> (?)</a></td>';
    html += '<td><input  type="text" name="addresses[' + address_row + '][address_2]" value=""></td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td><?php echo $entry_city; ?><a title="Ingrese la ciudad de residencia del cliente"> (?)</a></td>';
    html += '<td><input  type="text" name="addresses[' + address_row + '][city]" value=""></td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td><?php echo $entry_postcode; ?><a title="Ingrese el c&oacute;digo postal de residencia del cliente"> (?)</a></td>';
    html += '<td><input  type="text" name="addresses[' + address_row + '][postcode]" value=""></td>';
    html += '</tr>';
    html += '<td><?php echo $entry_country; ?><a title="Seleccione el pa&iacute;s de residencia del cliente"> (?)</a></td>';
    html += '<td>';
    html += '<select name="addresses[' + address_row + '][country_id]" onchange="$(\'select[name=\\\'addresses[' + address_row + '][zone_id]\\\']\').load(\'index.php?r=sale/customer/zone&token=<?php echo $token; ?>&country_id=\' + this.value + \'&zone_id=0\');">';
    html += '<option value="false"><?php echo $text_select; ?></option>';
    <?php foreach ($countries as $country) { ?>
    html += '<option value="<?php echo $country["country_id"]; ?>"><?php echo addslashes($country["name"]); ?></option>';
    <?php } ?>
    html += '</select>';
    <?php if ($error_country) { ?>
    html += '<span class="error"><?php echo $error_country; ?></span>';
    <?php } ?>
    html += '</td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td><?php echo $entry_zone; ?><a title="Seleccione el Estado/Provincia/Departamento del cliente"> (?)</a></td>';
    html += '<td>';
    html += '<select name="addresses[" + address_row + "][zone_id]"><option value="false"><?php echo $this->language->get("text_none"); ?></option></select>';
    <?php if ($error_zone) { ?>
    html += '<span class="error"><?php echo $error_zone; ?></span>';
    <?php } ?>  
    html += '</td>';
    html += '</tr>';
    html += '</table>';
    html += '</div>';
	
	$('#form').append(html);
	
	$('#address_add').before('<a  id="address_' + address_row + '" tab="#tab_address_' + address_row + '"><?php echo $tab_address; ?> ' + address_row + '<span title="Eliminar Direcci&oacute;n" onclick="$(\'#vtabs a:first\').trigger(\'click\'); $(\'#address_' + address_row + '\').remove(); $(\'#tab_address_' + address_row + '\').remove();" class="remove">&nbsp;</span></a>');
		
	$.tabs('.vtabs a', address_row);
	
	$('#address_' + address_row).trigger('click');
	
	address_row++;
}
</script> 
<script type="text/javascript">
$.tabs('.vtabs a');
</script> 
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('input[type=text]').css({'width':'250px'});
	jQuery('select').css({'width':'250px'});
});
jQuery(function($){
   jQuery("#telephone").mask("+589999999999",{placeholder:" "});
   jQuery("#nacimiento").mask("99/99/9999",{placeholder:" "});
   jQuery.mask.definitions['b']='[JGVEjgve]';
   jQuery("#rif").mask("b-99999999-9",{placeholder:" "});
});
jQuery('#firstname').capitalize();
jQuery('#lastname').capitalize();
jQuery('#company').capitalize();
jQuery('#city').capitalize();
</script> 
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
	jQuery('#excel_button img').attr('src','image/menu/excel_off.png');
	jQuery('#csv_button img').attr('src','image/menu/csv_off.png');
})
</script>
<?php echo $footer; ?>