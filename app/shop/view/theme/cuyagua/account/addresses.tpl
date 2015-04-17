<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/messages.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>

    <h1><?php echo $heading_title; ?></h1>

    <?php foreach ($addresses as $result) { ?>

    <div class="address-data data">
      <ul>
          <li class="address-info"><span><?php echo $result['address']; if ($result['default']) { echo " (Predeterminada)"; } ?></span></li>
          <li>
              <div class="actions actions-pad action-update">
                  <div class="action-button">
                      <a title="<?php echo $button_edit; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $result['update']); ?>'">
                          <?php echo $button_edit; ?>
                      </a>
                  </div>
                  <div class="action-button action-delete">
                      <a title="<?php echo $button_delete; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $result['delete']); ?>'">
                          <?php echo $button_delete; ?>
                      </a>
                  </div>
              </div>
          </li>
      </ul>
    </div>

    <?php } ?>
    <div class="action-button action-new">
        <a title="<?php echo $button_new_address; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $insert); ?>'"><?php echo $button_new_address; ?></a>
    </div>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>