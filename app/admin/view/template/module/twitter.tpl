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
      <input  name="twitter_search_limit" type="hidden" value="<?php echo $twitter_search_limit ?>">
      <input  name="twitter_search_rate" type="hidden" value="<?php echo $twitter_search_rate ?>">
      <input  name="twitter_time_refresh" type="hidden" value="<?php echo $twitter_time_limit ?>">
      <input  name="twitter_time_limit" type="hidden" value="<?php echo $twitter_time_limit ?>">
      <input  name="twitter_time_mode" type="hidden" value="<?php echo $twitter_time_mode ?>">
      <input  name="twitter_position" type="hidden" value="<?php echo $twitter_position ?>">
      <table class="form">
        <tr>    
        <td><?php echo $entry_twitter_search; ?><a title="<?php echo $help_twitter_search; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_twitter_search; ?>" name="twitter_search" type="text" size="20" value="<?php echo $twitter_search ?>"><span class="required">*</span>
             <?php if ($error_twitter_search); { ?>
            <span class="error"><?php echo $error_twitter_search;?></span>
            <?php } ?></td>
        </tr>
        <td><?php echo $entry_twitter_time; ?><a title="<?php echo $help_twitter_time; ?>"> (?)</a></td>
          <td><input title="<?php echo $help_twitter_time; ?>" name="twitter_time" type="text" value="<?php echo $twitter_time ?>"><span class="required">*</span> 
             <?php if ($error_twitter_time); { ?>
            <span class="error"><?php echo $error_twitter_time;?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?><a title="<?php echo $help_status; ?>"> (?)</a></td>
          <td><select name="twitter_status">
              <?php if ($twitter_status) { ?>
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
          <td><input title="<?php echo $help_sort_order; ?>" type="number" name="twitter_sort_order" value="<?php echo $twitter_sort_order; ?>" size="1"></td>
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