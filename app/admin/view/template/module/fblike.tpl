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
        <td><span class="required">*</span><?php echo $entry_pageid; ?><a title="<?php echo $help_pageid; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_pageid; ?>" name="fblike_pageid" size="20" maxlength="20" value="<?php echo $fblike_pageid ?>"> 
             <?php if ($error_pageid); { ?>
            <span class="error"><?php echo $error_pageid;?></span>
            <?php } ?></td>
        </tr>
        <tr>    
        <td><span class="required">*</span> <?php echo $entry_totalconnection ?><a title="<?php echo $help_totalconnection ?>"> (?)</a></td>
          <td><input title="<?php echo $help_totalconnection ?>" name="fblike_totalconnection" type="number" size="5" maxlength="5" value="<?php echo $fblike_totalconnection ?>"> 
             <?php if ($error_totalconnection); { ?>
            <span class="error"><?php echo $error_totalconnection;?></span>
            <?php } ?></td>
        </tr>
        <tr>    
        <td><span class="required">*</span> <?php echo $entry_width?><a title="<?php echo $help_width?>"> (?)</a></td>
          <td><input title="<?php echo $help_width?>" name="fblike_width" type="number" size="5" maxlength="5" value="<?php echo $fblike_width ?>"> 
             <?php if ($error_totalconnection); { ?>
            <span class="error"><?php echo $error_width;?></span>
            <?php } ?></td>
        </tr>
        <td><span class="required">*</span> <?php echo $entry_height?><a title="<?php echo $help_height?>"> (?)</a></td>
          <td><input title="<?php echo $help_height?>" name="fblike_height" type="number" size="5" maxlength="5" value="<?php echo $fblike_height ?>"> 
             <?php if ($error_height); { ?>
            <span class="error"><?php echo $error_height;?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_stream; ?><a title="<?php echo $help_stream; ?>"> (?)</a></td>
          <td><select name="fblike_stream">
              <?php if ($fblike_stream) { ?>
              <option value="1" selected="selected"><?php echo $text_true; ?></option>
              <option value="0"><?php echo $text_false; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_true; ?></option>
              <option value="0" selected="selected"><?php echo $text_false; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_header; ?><a title="<?php echo $help_header; ?>"> (?)</a></td>
          <td><select name="fblike_header">
              <?php if ($fblike_header) { ?>
              <option value="1" selected="selected"><?php echo $text_true; ?></option>
              <option value="0"><?php echo $text_false; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_true; ?></option>
              <option value="0" selected="selected"><?php echo $text_false; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_position; ?><a title="<?php echo $help_position; ?>"> (?)</a></td>
          <td><select title="<?php echo $help_position; ?>" name="fblike_position">
              <?php if ($fblike_position) { ?>
              <option value="<?php echo $fblike_position; ?>" selected="selected"><?php echo $fblike_position; ?></option>
              <?php } ?>
              <option value="home">Inicio</option>
              <option value="left"><?php echo $text_left; ?></option>
              <option value="right"><?php echo $text_right; ?></option>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?><a title="<?php echo $help_status; ?>"> (?)</a></td>
          <td><select title="<?php echo $help_status; ?>" name="fblike_status">
              <?php if ($fblike_status) { ?>
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
          <td><input title="<?php echo $help_sort_order; ?>" type="number" name="fblike_sort_order" value="<?php echo $fblike_sort_order; ?>" size="5"></td>
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