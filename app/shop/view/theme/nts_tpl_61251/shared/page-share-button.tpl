<div class="share-buttons">
    <ul class="rrssb-buttons clearfix">
        <li class="rrssb-facebook">
            <a onclick="popupWindow('https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($Url::createUrl("content/page",array('page_id'=>$page['page_id']))); ?>', 'Facebook', 600 , 480); return false;"
               href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($Url::createUrl("content/page",array('page_id'=>$page['page_id']))); ?>">
                <i class="rrssb-icon">
                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/facebook3.tpl"); ?>
                </i>
                <span class="rrssb-text">facebook</span>
            </a>
        </li>
        <li class="rrssb-twitter">
            <a href="https://twitter.com/home?status=<?php echo urlencode($Url::createUrl("content/page",array('page_id'=>$page['page_id']))); ?>" class="popup">
                <i class="rrssb-icon">
                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/twitter3.tpl"); ?>
                </i>
                <span class="rrssb-text">twitter</span>
            </a>
        </li>
        <li class="rrssb-googleplus">
            <a href="https://plus.google.com/share?url=<?php echo urlencode($Url::createUrl("content/page",array('page_id'=>$page['page_id']))); ?>" class="popup">
                <i class="rrssb-icon">
                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/google-plus3.tpl"); ?>
                </i>
                <span class="rrssb-text">google+</span>
            </a>
        </li>
    </ul>
</div>