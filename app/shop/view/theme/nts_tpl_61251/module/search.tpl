<li nt-editable="1" class="box searchWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

  <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 


  <div class="content" id="<?php echo $widgetName; ?>Content">
    <input id="<?php echo $widgetName; ?>Keyword" type="text" value="" autocomplete="off" placeholder="Buscar" />
    <a title="Buscar" class="button" onclick="moduleSearch($('#<?php echo $widgetName; ?>Keyword'));">
      <i class="fa fa-search"></i></a>
  </div>
  <div class="clear"></div><br />
</li>
<script>
  $(function () {
    $('#<?php echo $widgetName; ?>Keyword').on('keyup', function (e) {
      var code = e.keyCode || e.which;
      if ($(this).val().length > 0 && code == 13) {
        moduleSearch(this, $('#<?php echo $widgetName; ?>Category').val());
      }
    });
  });
</script>