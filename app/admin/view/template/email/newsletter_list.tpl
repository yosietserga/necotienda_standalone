<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/customer.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="location = '<?php echo $create; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $delete; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
  </div>
  <div class="content">
    <form action="" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'subject') { ?>
              <a href="<?php echo $sort_subject; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_subject; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_subject; ?>"><?php echo $column_subject; ?></a>
              <?php } ?></td>  
              <td class="left"><?php if ($sort == 'active') { ?>
              <a href="<?php echo $sort_active; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_active; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_active; ?>"><?php echo $column_active; ?></a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>"></td>
            <td><input type="text" name="filter_subject" value="<?php echo $filter_subject; ?>"></td>
            <td>
              <select name="filter_active">
                <option value="*">Todos</option>
                <?php if ($filter_active) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <?php } ?>
                <?php if (!is_null($filter_active) && !$filter_active) { ?>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
            </td>
            <td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date"></td>
            <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
          </tr>
          <?php if ($newsletters) { ?>
          <?php foreach ($newsletters as $newsletter) { ?>
          <tr>
            <td class="left"><?php echo $newsletter['name']; ?></td>
            <td class="left"><?php echo $newsletter['subject']; ?></td>
            <td class="left"><?php echo $newsletter['active']; ?></td>
            <td class="left"><?php echo $newsletter['date_added']; ?></td>
            <td class="right"><?php foreach ($newsletter['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
<div id="oculto">
    	<?php 
        function clear_string($strText) {
        	$strText = str_replace('&aacute;','a',$strText);
            $strText = str_replace('&eacute;','e',$strText);
            $strText = str_replace('&iacute;','i',$strText);
            $strText = str_replace('&oacute;','o',$strText);
            $strText = str_replace('&uacute;','u',$strText);
            $strText = str_replace('&Aacute;','A',$strText);
            $strText = str_replace('&Eacute;','E',$strText);
            $strText = str_replace('&Iacute;','I',$strText);
            $strText = str_replace('&Oacute;','O',$strText);
            $strText = str_replace('&Uacute;','U',$strText);
            $strText = str_replace('&ntilde;','ñ',$strText);
            $strText = str_replace('&Ntilde;','Ñ',$strText);
            return $strText;
        }
        	$content = $column_name."\t$column_subject\t$column_active\t$column_archive\t".clear_string($column_date_added)."\t\n";
            if ($newsletters) { 
        		foreach ($newsletters as $newsletter) { 
          			$content .= $newsletter['name']."\t".$newsletter['subject']."\t".$newsletter['active']."\t".$newsletter['archive']."\t".$newsletter['date_added']."\t\n";
        		} 
			} 
        ?>
</div>
<form action="index.php?route=tool/excel&token=<?php echo $_GET['token']; ?>" name="excel_form" id="excel_form" method="post">
	<input type='hidden' value='<?php echo $content; ?>' name='excel_data' id='excel_data'>
</form>
<script type="text/javascript">
function excel() {
	jQuery('#excel_form').submit();
}
</script>
<script type="text/javascript">
function filter() {
	url = 'index.php?route=email/newsletter&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_subject = $('input[name=\'filter_subject\']').attr('value');
	
	if (filter_subject) {
		url += '&filter_subject=' + encodeURIComponent(filter_subject);
	}
	
	var filter_active = $('input[name=\'filter_active\']').attr('value');
	
	if (filter_active) {
		url += '&filter_active=' + encodeURIComponent(filter_active);
	}
	
	var filter_archive = $('input[name=\'filter_archive\']').attr('value');
	
	if (filter_archive) {
		url += '&filter_archive=' + encodeURIComponent(filter_archive);
	}
	
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location = url;
}
</script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<?php echo $footer; ?>