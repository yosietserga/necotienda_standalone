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
    <h1 style="background-image: url('image/customer.png');"><?php echo $heading_title; ?></h1>
  </div>
  <div class="content">
    <form action="" method="post" enctype="multipart/form-data" id="form">
      <table class="list">
        <thead>
          <tr>
            <td width="1" style="text-align: center;"><input title="Seleccionar Todos" type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);"></td>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a  href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
              <a  href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'email') { ?>
              <a  href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
              <?php } else { ?>
              <a  href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
              <?php } ?></td>       
            <td class="left"><?php if ($sort == 'date_added') { ?>
              <a  href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
              <a  href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr class="filter">
            <td></td>
            <td><input  type="text" name="filter_name" value="<?php echo $filter_name; ?>"></td>
            <td><input  type="text" name="filter_email" value="<?php echo $filter_email; ?>"></td>
            <td><input  type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date"></td>
            <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
          </tr>
          <?php if ($members) { ?>
          <?php foreach ($members as $member) { ?>
          <tr>
            <td style="text-align: center;"><?php if ($member['selected']) { ?>
              <input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $member['customer_id']; ?>" checked="checked">
              <?php } else { ?>
              <input title="Seleccionar para una acci&oacute;n" type="checkbox" name="selected[]" value="<?php echo $member['customer_id']; ?>">
              <?php } ?>
            </td>
            <td class="left"><?php echo $member['name']; ?></td>
            <td class="left"><?php echo $member['email']; ?></td>
            <td class="left"><?php echo $member['date_added']; ?></td>
            <td class="right"><?php foreach ($member['action'] as $action) { ?>
              [ <a  href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
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
    <div class="pagination"><?php if(isset($pagination)) echo $pagination; ?></div>
  </div>
</div>
<form action="index.php?r=tool/excel&token=<?php echo $_GET['token']; ?>" name="excel_form" id="excel_form" method="post">
	<input  type='hidden' value='<?php echo $content_excel; ?>' name='excel_data' id='excel_data'>
</form>
<form action="index.php?r=tool/csv&token=<?php echo $_GET['token']; ?>" name="csv_form" id="csv_form" method="post">
	<input  type='hidden' value='<?php echo $content_csv; ?>' name='csv_data' id='csv_data'>
</form>
<form action="index.php?r=tool/vcard&token=<?php echo $_GET['token']; ?>" name="vcard_form" id="vcard_form" method="post">
	<input  type='hidden' value='<?php echo $content_vcard; ?>' name='vcard_data' id='vcard_data'>
</form>
<script type="text/javascript">
function excel() {
	jQuery('#excel_form').submit();
}
function csv() {
	jQuery('#csv_form').submit();
}
function vcard() {
	jQuery('#vcard_form').submit();
}
</script>
<script type="text/javascript">
function filter() {
	url = 'index.php?r=marketing/member&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_email = $('input[name=\'filter_email\']').attr('value');
	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
	var filter_newsletter = $('select[name=\'filter_newsletter\']').attr('value');
	
	if (filter_newsletter != '*') {
		url += '&filter_newsletter=' + encodeURIComponent(filter_newsletter); 
	}	
	
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location = url;
}
</script>
<script type="text/javascript">
$(function() {
	$('.date').datepicker({dateFormat: 'dd-mm-yy'});
});
</script>
<?php echo $footer; ?>