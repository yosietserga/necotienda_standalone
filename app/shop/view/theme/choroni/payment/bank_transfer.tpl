<div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;"><?php echo $text_instruction; ?><br>
  <br>
  <?php echo $bank; ?><br>
  <br>
  <?php echo $text_payment; ?></div>
<div class="buttons">
  <table>
    <tr>
      <td><a title="<?php echo $button_back; ?>" onClick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
      <td class="tdTopRight"><a title="<?php echo $button_confirm; ?>" id="checkout" class="button"><span><?php echo $button_confirm; ?></span></a></td>
    </tr>
  </table>
</div>
<script type="text/javascript">
$('#checkout').click(function() {
	$.ajax({ 
		type: 'GET',
		url: 'index.php?route=payment/bank_transfer/confirm',
		success: function() {
			location = '<?php echo $continue; ?>';
		}		
	});
});
</script>