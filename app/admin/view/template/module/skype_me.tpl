<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/module.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_code; ?></td>
          <td><br><br><br><textarea name="skype_me_code" cols="70" rows="7"><?php echo $skype_me_code; ?></textarea>
		  <?php if ($error_code) { ?>
            <span class="error"><?php echo $error_code; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_position; ?><a title="<?php echo $help_position; ?>"> (?)</a></td>
          <td><select name="skype_me_position">
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
          <td><select name="skype_me_status">
              <?php if ($skype_me_status) { ?>
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
          <td><input title="<?php echo $help_sort_order; ?>" type="number" name="skype_me_sort_order" value="<?php echo $skype_me_sort_order; ?>"></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>