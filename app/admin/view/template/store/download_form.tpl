<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/download.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <?php foreach ($languages as $language) { ?>
        <?php if ($language['status']) { ?>
		<tr>
          <td><span class="required">*</span> <?php echo $entry_name; ?><a title="<?php echo $help_name; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_name; ?>" name="download_description[<?php echo $language['language_id']; ?>][name]" size="100" value="<?php echo isset($download_description[$language['language_id']]) ? $download_description[$language['language_id']]['name'] : ''; ?>">
            <imgsrc="image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>">
            <?php if (isset($error_name[$language['language_id']])) { ?>
            <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br>
            <?php } ?>
			<?php } ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_filename; ?><a title="<?php echo $help_filename; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_filename; ?>" type="file" name="download" value="">
            <br><span class="help" style="font-style: italic;"><?php echo $filename; ?></span>
            <?php if ($error_download) { ?>
            <span class="error"><?php echo $error_download; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_remaining; ?><a title="<?php echo $help_remaining; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_remaining; ?>" type="number" name="remaining" value="<?php echo $remaining; ?>" size="6"></td>
        </tr>
        <?php if ($show_update) { ?>
        <tr>
          <td><?php echo $entry_update; ?><a title="<?php echo $help_update; ?>"> (?)</a></td>
          <td>
          <?php if ($update) { ?>
          <input title="<?php echo $help_update; ?>" type="checkbox" name="update" value="1" checked="checked">
          <?php } else { ?>
          <input title="<?php echo $help_update; ?>" type="checkbox" name="update" value="1">
          <?php } ?>
          </td>
        </tr>
        <?php } ?>
      </table>
    </form>
  </div>
</div>
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
	jQuery('#excel_button img').attr('src','image/menu/excel_off.png');
	jQuery('#csv_button img').attr('src','image/menu/csv_off.png');
})
</script>
<?php echo $footer; ?>