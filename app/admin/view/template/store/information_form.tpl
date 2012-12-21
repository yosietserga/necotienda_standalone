<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background: url('image/information.png') 2px 9px no-repeat;"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <div class="htabs">
        <?php foreach ($languages as $language) { ?>
        <a  tab="#language<?php echo $language['language_id']; ?>"><imgsrc="image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"> <?php echo $language['name']; ?></a>
		<?php } ?>
      </div>
      <?php foreach ($languages as $language) { ?>
      <div id="language<?php echo $language['language_id']; ?>">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_title; ?><a title="<?php echo $help_title; ?>"> (?)</a></td>
            <td><input title="<?php echo $help_title; ?>" name="information_description[<?php echo $language['language_id']; ?>][title]" size="100" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['title'] : ''; ?>">
              <?php if (isset($error_title[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_description; ?><a title="<?php echo $help_description; ?>"> (?)</a></td>
            <td><textarea title="<?php echo $help_description; ?>" name="information_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['description'] : ''; ?></textarea>
              <?php if (isset($error_description[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
              <?php } ?></td>
          </tr>
        </table>
      </div>
	  <?php } ?>
      <table class="form">
        <tr>
          <td><?php echo $entry_keyword; ?><a title="<?php echo $help_keyword; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_keyword; ?>" type="text" name="keyword" value="<?php echo $keyword; ?>"></td>
        </tr>
		<tr>
            <td><?php echo $entry_status; ?><a title="<?php echo $help_status; ?>"> (?)</a></td>
            <td><select title="<?php echo $help_status; ?>" name="status">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?><a title="<?php echo $help_sort_order; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_sort_order; ?>" type="number" name="sort_order" value="<?php echo $sort_order; ?>" size="1"></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script type="text/javascript" src="javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language["language_id"]; ?>', {
	filebrowserBrowseUrl: 'index.php?r=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?r=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?r=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?r=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?r=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?r=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
</script>
<script type="text/javascript">
$.tabs('.htabs a'); 
</script>
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
	jQuery('#excel_button img').attr('src','image/menu/excel_off.png');
	jQuery('#csv_button img').attr('src','image/menu/csv_off.png');
})
</script>
<?php echo $footer; ?>