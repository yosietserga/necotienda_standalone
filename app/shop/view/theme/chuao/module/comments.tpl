<li nt-editable="1" class="comments-widget<?php echo ($settings['class']) ? ' '. $settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php include("comments_". $settings['view'] .'.tpl'); ?>
</li>

<script>
    window.nt.review = window.nt.review || {};
    window.nt.review.txtButtonContinue = '<?php echo $Language->get('button_continue'); ?>';
    window.nt.review.txtConfirmDelete = '<?php echo $Language->get('text_confirm_delete'); ?>';
    window.nt.review.txtWait = '<?php echo $Language->get('text_wait'); ?>';
    window.nt.review.txtSuccess = '<?php echo $Language->get('text_success'); ?>';
    window.nt.review.txtErrorText = '<?php echo $Language->get('error_text'); ?>';
    window.nt.review.txtErrorLogin = '<?php echo $Language->get('error_login'); ?>';

    window.nt.review.oid = '<?php echo $oid; ?>';
    window.nt.review.ot = '<?php echo $ot; ?>';
    window.nt.review.widgetName = '<?php echo $widgetName; ?>';
    window.nt.review.isLogged = '<?php echo $this->customer->isLogged(); ?>';

    $(function(){
        $('#<?php echo $widgetName; ?>_review').load('<?php echo $Url::createUrl("store/review") ."&wid=$widgetName&object_type=$ot&object_id=$oid"; ?>');
        $('#<?php echo $widgetName; ?>_comment').load('<?php echo $Url::createUrl("store/review/comment")  ."&wid=$widgetName&object_type=$ot&object_id=$oid" ?>');
    });
</script>