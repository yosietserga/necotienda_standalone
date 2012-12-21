<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
      <h1><?php echo $heading_title; ?></h1>

  <div class="middle">
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <b style="margin-bottom: 2px; display: block;"><?php echo $text_address_book; ?></b>
    <?php foreach ($addresses as $result) { ?>
    <div class="content">
      <table>
        <tr>
          <td><?php echo $result['address']; ?></td>
          <td style="text-align: right;width:200px;"><a title="<?php echo $button_edit; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $result['update']); ?>'" class="button"><span><?php echo $button_edit; ?></span></a>&nbsp;<a title="<?php echo $button_delete; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $result['delete']); ?>'" class="button"><span><?php echo $button_delete; ?></span></a></td>
        </tr>
      </table>
    </div>
    <?php } ?>
    <div class="buttons">
      <table>
        <tr>
          <td><a title="<?php echo $button_back; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
          <td class="tdTopRight"><a title="<?php echo $button_new_address; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $insert); ?>'" class="button"><span><?php echo $button_new_address; ?></span></a></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php echo $footer; ?> 