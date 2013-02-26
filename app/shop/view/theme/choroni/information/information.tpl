<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
  <h1><?php echo $heading_title; ?></h1>
  <div class="middle"><?php echo $description; ?>
    <div class="buttons">
      <table>
        <tr>
          <td class="tdTopRight"><a title="<?php echo $button_continue; ?>" onClick="location = '<?php echo str_replace('&', '&amp;', $continue); ?>'" class="button"><span><?php echo $button_continue; ?></span></a></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php echo $footer; ?> 