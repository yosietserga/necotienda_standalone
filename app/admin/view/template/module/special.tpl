<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/module.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><?php echo $entry_limit; ?><a title="<?php echo $help_limit; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_limit; ?>" type="number" name="special_limit" value="<?php echo $special_limit; ?>"></td>
        </tr>
        <tr>
          <td><?php echo $entry_position; ?><a title="<?php echo $help_position; ?>"> (?)</a></td>
          <td><select name="special_position">
              <?php foreach ($positions as $position) { ?>
              <?php if ($special_position == $position['position']) { ?>
              <option value="<?php echo $position['position']; ?>" selected="selected"><?php echo $position['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $position['position']; ?>"><?php echo $position['title']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?><a title="<?php echo $help_status; ?>"> (?)</a></td>
          <td><select name="special_status">
              <?php if ($special_status) { ?>
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
          <td><input title="<?php echo $help_sort_order; ?>" type="number" name="special_sort_order" value="<?php echo $special_sort_order; ?>"></td>
        </tr>
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