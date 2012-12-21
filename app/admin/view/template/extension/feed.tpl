<?php echo $header; ?> 
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php if ($error) { ?>
<div class="warning"><?php echo $error; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/feed.png');"><?php echo $heading_title; ?></h1>
  </div>
  <div class="content">
    <table id="list"  class="list">
      <thead>
        <tr>
          <td class="left"><?php echo $column_name; ?></td>
          <td class="left"><?php echo $column_status; ?></td>
          <td class="right"><?php echo $column_action; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php if ($extensions) { ?>
        <?php foreach ($extensions as $extension) { ?>
        <tr id="tr_<?php echo $extension['extension']; ?>-<?php echo $extension['pos']; ?>">
          <td class="left"><?php echo $extension['name']; ?></td>
          <td class="left"><?php echo $extension['status'] ?></td>
          <td class="right"><?php foreach ($extension['action'] as $action) { ?>
            <?php 
                if ($action['action'] == "install") {
                    $href = "href='" . $action['href'] ."'";
                    $jsfunction = "";
                    $img_id = "img_install_" . $customer['customer_id'];
                } elseif ($action['action'] == "activate") {
                    $jsfunction = "activate(". $customer['customer_id'] .")";
                    $href = $action['href'];
                    $img_id = "img_activate_" . $customer['customer_id'];
                } elseif ($action['action'] == "edit") {
                    $href = "href='" . $action['href'] ."'";
                    $jsfunction = "";
                    $img_id = "img_edit_" . $customer['customer_id'];
                } 
            ?>
              <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="<?php echo $img_id; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
              <?php } ?></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
          <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<script>
$(function(){    
	jQuery('#pdf_button img').attr('src','image/menu/pdf_off.png');
	jQuery('#excel_button img').attr('src','image/menu/excel_off.png');
	jQuery('#csv_button img').attr('src','image/menu/csv_off.png');
})
</script>
<script>
$(function(){
    $( "#list tbody" ).sortable({
        opacity: 0.6, 
        cursor: 'move',
        update: function() {
            $.ajax({
                'type':'post',
                'dateType':'json',
                'url':'index.php?r=extension/module/sortable&token=<?php echo $_GET['token']; ?>',
                'data': $(this).sortable("serialize"),
                'success': function(data) {
                    // mostramos mensajes
                    if (data > 0) {
                        var msj = "<div class='success'>Se han ordenado los objetos correctamente</div>";
                    } else {
                        var msj = "<div class='warning'>Hubo un error al intentar ordenar los objetos, por favor intente más tarde</div>";
                    }
                    $("#msg").append(msj).delay(3600).fadeOut();
                }
            });
        }
    }).disableSelection();
    $( "#list .move" ).css('cursor','move');
});
</script>
<?php echo $footer; ?>