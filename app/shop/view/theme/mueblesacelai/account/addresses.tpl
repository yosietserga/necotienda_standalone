<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?> 
    <?php foreach ($addresses as $result) { ?> 
      <div class="address-data data">
         <ul>
            <li class="address-info"><span>
                     <?php echo $result['address']; if ($result['default']) {?>
                        <?php echo $Language->get('text_default'); ?>
                     <?php } ?>
               </span>
            </li>
            <li>
               <div class="group group--btn" role="group">
                     <div class="btn btn-edit btn--primary" aria-label="Edit" role="button">
                        <a title="<?php echo $button_edit; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $result['update']); ?>'">
                           <?php echo $button_edit; ?>
                        </a>
                     </div>
                     <div class="btn btn-delete btn--primary" aria-label="Delete" role="button">
                        <a title="<?php echo $button_delete; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $result['delete']); ?>'">
                           <?php echo $button_delete; ?>
                        </a>
                     </div>
               </div>
            </li>
         </ul>
      </div> 
    <?php } ?>
    <div class="btn btn-new btn--primary" aria-label="New" role="button">
        <a title="<?php echo $button_new_address; ?>" onclick="location = '<?php echo str_replace('&', '&amp;', $insert); ?>'"><?php echo $button_new_address; ?></a>
    </div>
    
    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>