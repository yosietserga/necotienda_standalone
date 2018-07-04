<li nt-editable="1" class="invite-friend-widgets<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

  <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 

  <div class="widget-content" id="<?php echo $widgetName; ?>Content">
    <div class="group group--btn">
      <?php if ($google_client_id) { ?>
      <div class="action-button action-google">
        <a href="<?php echo $Url::createUrl("api/google",array('redirect'=>'invitefriends')); ?>">
           <?php echo $Language->get('text_google_invite'); ?>
      </a>
    </div>
    <?php } ?>
    <?php if ($live_client_id) { ?>
    <div class="action-button action-live">
      <a  href="<?php echo $Url::createUrl("api/live",array('redirect'=>'invitefriends')); ?>">
          <?php echo $Language->get('text_live_invite'); ?>
    </a>
  </div>
  <?php } ?>
  <?php if ($facebook_app_id) { ?>
  <div class="action-button action-facebook">
    <a href="<?php echo $Url::createUrl("api/facebook",array('redirect'=>'invitefriends')); ?>">
       <?php echo $Language->get('text_facebook_invite'); ?>
  </a>
</div>
<?php } ?>
<?php if ($twitter_oauth_token_secret) { ?>
<div class="action-button action-twitter">
  <a href="<?php echo $Url::createUrl("api/twitter",array('redirect'=>'invitefriends')); ?>">
     <?php echo $Language->get('text_twitter_invite'); ?>
</a>
</div>

<?php } ?>
</div>
</div>
</li>