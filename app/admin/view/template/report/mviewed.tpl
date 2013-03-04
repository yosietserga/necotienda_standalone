<?php echo $header; ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/report.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick=" if (confirm('Se borrar� toda la informaci�n. �Desea continuar?')) {location = '<?php echo $reset; ?>';}" class="button"><span><?php echo $button_reset; ?></span></a></div>  
  </div>
  <div class="content">  
            <label>Fecha Inicial:</label><input  type="date" name="filter_sdate" value="<?php echo $filter_sdate; ?>" id="sdate">
            <label>Fecha Final:</label><input  type="date" name="filter_fdate" value="<?php echo $filter_fdate; ?>" id="fdate">
    <table class="list">
    <thead>
          <tr>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a  href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
              <a  href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'viewed') { ?>
              <a  href="<?php echo $sort_viewed; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_tviewed; ?></a>
              <?php } else { ?>
              <a  href="<?php echo $sort_viewed; ?>"><?php echo $column_tviewed; ?></a>
              <?php } ?></td>
          <td class="right"><?php echo $column_viewed; ?></td>
          <td class="right"><?php echo $column_percent; ?></td>
          </tr>
        </thead>
      <tbody>
      <tr class="filter">
            <td><input  type="text" name="filter_name" value="<?php echo $filter_name; ?>"></td>
            <td></td>
            <td></td>
            <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
          </tr>
        <?php if ($manufacturers) { ?>
        <?php foreach ($manufacturers as $manufacturer) { ?>
        <?php if (empty($manufacturer['name'])) continue; ?>    
        <?php if ($manufacturer['viewed'] == 0) { ?>            
           <tr style="background: #FFF0F0;">
          <?php } else { ?>            
          <tr style="font-weight:bold;background: #F4FFF0">
          <?php } ?>     
          <td class="left"><a href="<?php echo HTTP_HOME."index.php?r=report/mviewedbycustomer&token=".$_GET['token']."&manufacturer_id=".$manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></a></td>
          <td class="right"><?php echo $manufacturer['tviewed']; ?></td>
          <?php if ($manufacturer['viewed'] == 0) { ?>            
          <td class="right"><?php echo $manufacturer['viewed']; ?></td>
          <?php } else { ?>            
          <td class="right"><b><?php echo $manufacturer['viewed']; ?></b></td>
          <?php } ?>
          <?php if ($manufacturer['percent'] == '0%') { ?>            
          <td class="right"><?php echo $manufacturer['percent']; ?></td>
          <?php } else { ?>            
          <td class="right"><b><?php echo $manufacturer['percent']; ?></b></td>
          <?php } ?>
        </tr>        
        <?php } ?>  
        <?php } else { ?>
        <tr>
          <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
</div>
<form action="index.php?r=tool/excel&token=<?php echo $_GET['token']; ?>" name="excel_form" id="excel_form" method="post">
	<input  type='hidden' value='<?php echo $content_excel; ?>' name='excel_data' id='excel_data'>
</form>
<form action="index.php?r=tool/csv&token=<?php echo $_GET['token']; ?>" name="csv_form" id="csv_form" method="post">
	<input  type='hidden' value='<?php echo $content_csv; ?>' name='csv_data' id='csv_data'>
</form>
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
})
</script>
<script type="text/javascript">
function excel() {
	jQuery('#excel_form').submit();
}
function csv() {
	jQuery('#csv_form').submit();
}
</script>
<script type="text/javascript">
function filter() {
	url = 'index.php?r=report/mviewed&token=<?php echo $_GET["token"]; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
    
	var filter_sdate = $('input[name=\'filter_sdate\']').attr('value');
	
	if (filter_sdate) {
		url += '&filter_sdate=' + encodeURIComponent(filter_sdate);
	}
    
	var filter_fdate = $('input[name=\'filter_fdate\']').attr('value');
	
	if (filter_fdate) {
		url += '&filter_fdate=' + encodeURIComponent(filter_fdate);
	}
		
	location = url;
}
</script>
<script type="text/javascript">
$(function() {    
    $('#sdate').datepicker({dateFormat: 'yy-mm-dd'});
    $("#fdate").datepicker({dateFormat: 'yy-mm-dd'});
})
</script>
<?php echo $footer; ?>