<li class="nt-editable invite-friend-widgets<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
<?php if ($heading_title) { ?>
    <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
        <div class="heading-title">
            <h3>
                <i class="icon heading-icon fa fa-heart fa-2x"></i>
                <?php echo $heading_title; ?>
            </h3>
        </div>
    </div>
    <?php } ?>
    <div class="widget-content" id="<?php echo $widgetName; ?>Content">
        <div class="actions">
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