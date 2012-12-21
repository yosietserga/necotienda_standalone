<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
	    <div class="column_left">
        <table class="form2">
          <tr>
            <td><?php echo $entry_name; ?></td>
            <td><a href="<?php echo $customer; ?>"><?php echo $name; ?></a></td>
          </tr>
          <tr>
            <td><?php echo $entry_email; ?></td>
            <td><?php echo $email; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_telephone; ?></td>
            <td><?php echo $telephone; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_fax; ?></td>
            <td><?php if (!empty($fax)) echo $fax; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_website; ?></td>
            <td>
          <?php if (!empty($website)) echo $website; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_blog; ?></td>
            <td>
          <?php if (!empty($blog)) echo $blog; ?></td>
          </tr>
        <tr>
        </table>
        </div>
        <div class="column_right">
        <table class="form2">
          <tr>
            <td><?php echo $entry_facebook; ?></td>
            <td><?php if (!empty($facebook))echo $facebook; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_twitter; ?></td>
            <td><?php if (!empty($twitter)) echo $twitter; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_msn; ?></td>
            <td><?php if (!empty($msn)) echo $msn; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_gmail; ?></td>
            <td><?php if (!empty($gmail)) echo $gmail; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_yahoo; ?></td>
            <td><?php if (!empty($yahoo)) echo $yahoo; ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_skype; ?></td>
            <td> <?php if (!empty($skype)) echo $skype; ?></td>
          </tr>
        </table>
        </div>
        <div style="float:left"><a onclick="jQuery('.form .on').slideDown();">Mostrar Todos</a>&nbsp;&nbsp;<a onclick="jQuery('.form .on').slideUp();">Ocultar Todos</a></div><div style="float:right"><a onclick="addMemberToAllLists()">Agregar a Todos&nbsp;<img src="image/add.png"></a>&nbsp;&nbsp;<a onclick="deleteMemberFromAllLists()">Eliminar a Todos&nbsp;<img src="image/delete.png"></a></div>
        <table class="form">
          <tr onMouseOver="jQuery(this).css({'background':'none'});">
            <td><h2>Listas Agregadas</h2></td>
          </tr>
          <?php $b = 1; ?>
          <?php foreach ($lists as $list) { ?>
          <input type="hidden" name="id_<?php echo $b; ?>_d" value="<?php echo $list['list_id']; ?>">
          <tr class="lists">
            <td style="width:70%"><a id="id_<?php echo $b; ?>" onclick="showIntereses(this);"><?php echo ucwords($list['list_name']); ?></a></td>
            <td style="float:right"><a onclick="deleteMemberFromList(this)" class="id_<?php echo $b; ?>_d"><img src="image/delete.png"></a></td>
          </tr>
          <tr id="id_<?php echo $b; ?>_i" class="on">
            <td colspan="2">              
                <h3>Categor&iacute;as</h3>
          	<?php if (isset($list[0])) { ?>
          	   <?php foreach ($list as $interes) { ?>
                <?php if (is_array($interes)) { ?>
              		  <div style="width:25%;float:left;"><img src="image/vineta.gif">&nbsp;<a style="text-decoration:none" onMouseOver="jQuery(this).css({'text-decoration':'underline'});" onMouseOut="jQuery(this).css({'text-decoration':'none'});" href="<?php echo $categoria.$interes['category_id']; ?>"><?php echo $interes['category_name']; ?></a></div>
                <?php } ?>
               <?php } ?>
             <?php } else { ?>
               <p>No posee categor&iacute;as asignadas. <a href="<?php echo $lista.$list['list_id']; ?>">&iquest;Desea asignar algunas ahora?</a></p>
             <?php } ?>
            </td>
          </tr>
          <?php $b++; ?>
           <?php } ?>
     </table>
     <table class="form">
     	  <tr onMouseOver="jQuery(this).css({'background':'none'});">
            <td><h2>Listas No Agregadas</h2></td>
          </tr>
          <?php $b = 10000; ?>
          <?php foreach ($other_lists as $other_list) { ?>
          <input type="hidden" name="id_<?php echo $b; ?>" value="<?php echo $other_list['list_id']; ?>">
          <tr  class="other_lists">
            <td style="width:70%"><a id="id_<?php echo $b; ?>" onclick="showIntereses(this);"><?php echo ucwords($other_list['list_name']); ?></a></td>
            <td style="float:right"><a onclick="addMemberToList(this)" class="id_<?php echo $b; ?>"><img src="image/add.png"></a></td>
          </tr>
          <tr id="id_<?php echo $b; ?>_i" class="on">
            <td colspan="2"> 
             <h3>Categor&iacute;as</h3>
             <?php if (isset($other_list[0])) { ?>
          	   <?php foreach ($other_list as $interes) { ?>
                <?php if (is_array($interes)) { ?>
              		  <div style="width:25%;float:left;"><img src="image/vineta.gif">&nbsp;<a style="text-decoration:none" onMouseOver="jQuery(this).css({'text-decoration':'underline'});" onMouseOut="jQuery(this).css({'text-decoration':'none'});" href="<?php echo $categoria.$interes['category_id']; ?>"><?php echo $interes['category_name']; ?></a></div>
                <?php } ?>
               <?php } ?>
             <?php } else { ?>
               <p>No posee categor&iacute;as asignadas. <a href="<?php echo $lista.$other_list['list_id']; ?>">&iquest;Desea asignar algunas ahora?</a></p>
             <?php } ?>
            </td>
          </tr>
          <?php $b++; ?>
           <?php } ?>
     </table>
    </div>
</div>    
</form>
<script type="text/javascript">
$(document).ready(function() {
	jQuery('input[type=text]').css({'width':'250px'});
	jQuery('select').css({'width':'250px'});
	if (jQuery('#process_bounce:checked').val() != null) {
		jQuery("#bounce_process").show();
	} else {
		jQuery("#bounce_process").hide();
	}
	if (jQuery('#bounce_extraoption:checked').val() != null) {
		jQuery("#bounce_extra_sttings").show();
	} else {
		jQuery("#bounce_extra_sttings").hide();
	}
});
function showIntereses(e) {
	jQuery('.form #'+jQuery(e).attr('id')+'_i').slideToggle();
}
function other_setting(){
	if (jQuery('#extramail_others:checked').val() != null) {
		jQuery('#other').attr('disabled',false); 
	} else {
		jQuery('#other').attr('disabled',true); 
		jQuery('#other').val() = '';
	}
}
function show_bounce_settings() {
	var check = jQuery('#process_bounce:checked').val();
	if (jQuery('#process_bounce:checked').val() != null) {
		jQuery("#bounce_process").fadeIn();
	} else {
		jQuery("#bounce_process").fadeOut();
	}
}
jQuery("#bounce_extraoption").bind('click',function() {
	var check = jQuery('#bounce_extraoption:checked').val();
	if (jQuery('#bounce_extraoption:checked').val() != null) {
		jQuery("#bounce_extra_sttings").fadeIn();
	} else {
		jQuery("#bounce_extra_sttings").fadeOut();
	}
});
function bounce() {
	jQuery("#cmdTestBounce").fancybox({
				'width'				: '50%',
				'height'			: '50%',
				'autoScale'			: false,
				'type'				: 'ajax',
				'showCloseButton'   : true,
				'hideOnOverlayClick': false,
				'href'				: 'index.php?r=marketing/bounce/test&token=<?php echo $token; ?>&bounce_server=' + encodeURIComponent(jQuery("input[name='bounce_server']").val()) 
				+ '&bounce_username=' + encodeURIComponent(jQuery("input[name='bounce_username']").val()) 
				+ '&bounce_password=' + encodeURIComponent(jQuery("input[name='bounce_password']").val()) 
				+ '&imap_account=' + encodeURIComponent(jQuery("input[name='imap_account']").val()) 
				+ '&extra_mail_nossl=' + a("input[name='extra_mail_nossl']") 
				+ '&extra_mail_notls=' + a("input[name='extra_mail_notls']") 
				+ '&extra_mail_novalidate=' + a("input[name='extra_mail_novalidate']")
				+ '&extra_mail_others=' + encodeURIComponent(jQuery("input[name='extra_mail_others']").val())
				+ '&agree_delete=' + encodeURIComponent(jQuery("input[name='agree_delete']").val())
			});
}
function a(e) {
	if (jQuery(e+":checked").val() != null) {
		return encodeURIComponent(jQuery(e+":checked").val());
	} else {
		return '';
	}
}
function addMemberToList(e) {
	jQuery.ajax({
		type: 'POST',
		url: 'index.php?r=marketing/member/addMemberToList&token=<?php echo $_GET["token"]; ?>',
		data: {
			'list_id':jQuery("input[name='"+jQuery(e).attr('class')+"']").val(),
			'member_id':'<?php echo $_GET["member_id"]; ?>',
			'email':'<?php echo $email; ?>'
			},
		success:function() {
			window.location.reload();
		}
	});
}
function addMemberToAllLists() {
	jQuery.ajax({
		type: 'POST',
		url: 'index.php?r=marketing/member/addMemberToAllLists&token=<?php echo $_GET["token"]; ?>',
		data: {
			'member_id':'<?php echo $_GET["member_id"]; ?>',
			'email':'<?php echo $email; ?>'
			},
		success:function() {
			window.location.reload();
		}
	});
}
function deleteMemberFromList(e) {
	jQuery.ajax({
		type: 'POST',
		url: 'index.php?r=marketing/member/deleteMemberFromList&token=<?php echo $_GET["token"]; ?>',
		data: {
			'member_id':'<?php echo $_GET["member_id"]; ?>',
			'list_id': jQuery("input[name='"+jQuery(e).attr('class')+"']").val()			
			},
		success:function() {
			window.location.reload();
		}
	});
}
function deleteMemberFromAllLists() {
	jQuery.ajax({
		type: 'POST',
		url: 'index.php?r=marketing/member/deleteMemberFromAllLists&token=<?php echo $_GET["token"]; ?>',
		data: {'member_id':'<?php echo $_GET["member_id"]; ?>'},
		beforeSend: function() {
			if (confirm("¿Está seguro que desea eliminar este miembro de todas las listas?")) {
				return true;	
			} else {
				return false;
			}
		},
		success:function() {
			window.location.reload();
		}
	});
}
</script>
<?php echo $footer; ?>