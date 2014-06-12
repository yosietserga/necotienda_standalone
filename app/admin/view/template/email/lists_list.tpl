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
    <h1 style="background-image: url('view/image/order.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $delete; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
  </div>
  <div class="content">
    <form action="" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align: center;"><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"></td>
            <td class="right"><?php if ($sort == 'list_id') { ?>
              <a href="<?php echo $sort_list; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_list; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_list; ?>"><?php echo $column_list; ?></a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } ?></td>
            <td class="right"><?php if ($sort == 'subscribe_count') { ?>
              <a href="<?php echo $sort_subscribe_count; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_subscribe_count; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_subscribe_count; ?>"><?php echo $column_subscribe_count; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td align="right"><input type="text" name="filter_list_id" value="<?php echo $filter_list_id; ?>" size="4" style="text-align: right;"></td>
            <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>"></td>
            <td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date"></td>
            <td align="right"><input type="text" name="filter_subscribe_count" value="<?php echo $filter_subscribe_count; ?>" size="4" style="text-align: right;"></td>
            <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
          </tr>
          <?php if ($lists) { ?>
          <?php foreach ($lists as $list) { ?>
          <tr>
            <td style="text-align: center;"><?php if ($list['selected']) { ?>
              <input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $list['list_id']; ?>" checked="checked">
              <?php } else { ?>
              <input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $list['list_id']; ?>">
              <?php } ?></td>
            <td class="right"><?php echo $list['list_id']; ?></td>
            <td class="left"><?php echo $list['name']; ?></td>
            <td class="left"><?php echo $list['date_added']; ?></td>
            <td class="right"><?php echo $list['subscribe_count']; ?></td>
            <td class="right"><?php foreach ($list['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
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
        	$content = "$column_list\t$column_name\t$column_date_added\t$column_subscribe_count\t\n";
            if ($lists) { 
        		foreach ($lists as $list) { 
          			$content .= $list['list_id']."\t".$list['name']."\t".$list['date_added']."\t".$list['subscribe_count']."\t\n";
        		} 
			} 
        ?>
</div>
<form action="index.php?route=tool/excel&token=<?php echo $token; ?>" name="excel_form" id="excel_form" method="post">
	<input type='hidden' value='<?php echo $content; ?>' name='excel_data' id='excel_data'>
</form>
<script type="text/javascript">
function excel() {
	jQuery('#excel_form').submit();
}
</script>
<script type="text/javascript">
function filter() {
	url = 'index.php?route=email/lists&token=<?php echo $token; ?>';
	
	var filter_order_id = $('input[name=\'filter_list_id\']').attr('value');
	
	if (filter_order_id) {
		url += '&filter_list_id=' + encodeURIComponent(filter_order_id);
	}
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_subscribe_count = $('input[name=\'filter_subscribe_count\']').attr('value');

	if (filter_subscribe_count) {
		url += '&filter_subscribe_count=' + encodeURIComponent(filter_subscribe_count);
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