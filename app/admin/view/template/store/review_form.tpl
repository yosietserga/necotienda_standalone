<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/review.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_author; ?></td>
          <td><input  type="text" name="author" value="<?php echo $author?>">
            <?php if ($error_author) { ?>
            <span class="error"><?php echo $error_author; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_product; ?></td>
          <td><select id="category" style="margin-bottom: 5px;" onChange="getProducts();">
              <option value="0"><?php echo $text_select; ?></option>
              <?php foreach ($categories as $category) { ?>
              <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
              <?php } ?>
            </select>
            <br>
            <div id="product_select">
            <select name="product_id" id="product"></select>
            </div>
            <?php if ($error_product) { ?>
            <span id="product_error" class="error"><?php echo $error_product; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_text; ?></td>
          <td><textarea name="text" cols="60" rows="8"><?php echo $text; ?></textarea>
            <?php if ($error_text) { ?>
            <span class="error"><?php echo $error_text; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_rating; ?></td>
          <td><b class="rating"><?php echo $entry_bad; ?></b>&nbsp;
            <?php if ($rating == 1) { ?>
            <input  type="radio" name="rating" value="1" checked>
            <?php } else { ?>
            <input  type="radio" name="rating" value="1">
            <?php } ?>
            &nbsp;
            <?php if ($rating == 2) { ?>
            <input  type="radio" name="rating" value="2" checked>
            <?php } else { ?>
            <input  type="radio" name="rating" value="2">
            <?php } ?>
            &nbsp;
            <?php if ($rating == 3) { ?>
            <input  type="radio" name="rating" value="3" checked>
            <?php } else { ?>
            <input  type="radio" name="rating" value="3">
            <?php } ?>
            &nbsp;
            <?php if ($rating == 4) { ?>
            <input  type="radio" name="rating" value="4" checked>
            <?php } else { ?>
            <input  type="radio" name="rating" value="4">
            <?php } ?>
            &nbsp;
            <?php if ($rating == 5) { ?>
            <input  type="radio" name="rating" value="5" checked>
            <?php } else { ?>
            <input  type="radio" name="rating" value="5">
            <?php } ?>
            &nbsp; <b class="rating"><?php echo $entry_good; ?></b>
            <?php if ($error_rating) { ?>
            <span class="error"><?php echo $error_rating; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?></td>
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
    </form>
  </div>
</div>
<script type="text/javascript">

	$('#product').hide();
function getProducts() {
	$.ajax({
	    type: 'get',
		url: 'index.php?r=store/recategory&token=<?php echo $token; ?>&category_id=' + $('#category').attr('value'),
		dataType: 'html',
        beforeSend: function() {
            $('#product').fadeOut();
            $('#product').remove();
            $('#add_product').remove();
            $('#product_error').remove();
        },
		success: function(data) {
		  data = data.substr(2);
		  data = $.trim(data);      
            if (data == 1) {                
                $('#product_select').append('<p id="add_product">No hay productos en esta categor&iacute;a. <a href="<?php echo HTTP_HOME; ?>index.php?r=store/product&token=<?php echo $_GET['token']; ?>">&iquest;Desea agregar alguno ahora?</a></p>');
            } else {
                $('#product_select').append('<select name="product_id" id="product"></select>');
                $('#product').append(data);
            }
		}
	});
}
</script>
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
	jQuery('#excel_button img').attr('src','image/menu/excel_off.png');
	jQuery('#csv_button img').attr('src','image/menu/csv_off.png');
})
</script>
<?php echo $footer; ?>