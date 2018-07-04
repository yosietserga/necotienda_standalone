<div class="coupon-entry form-entry">
    <input data-label="<?php echo $Language->get('Apply A Coupon'); ?>" type="text" id="input-coupon" name="coupon" value="" placeholder="<?php echo $Language->get('Apply A Coupon'); ?>"/>
    <div class="action-step" id="apply-coupon-button"><?php echo $Language->get('Apply A Coupon'); ?></div>
</div>
<script>
    (function ($) {
        $('#apply-coupon-button').on('click', function () {
            $(this).text('<?php echo $Language->get('Loading...'); ?>');
            var that = this;
            $.post('<?php echo $Url::createUrl("total/coupon/coupon"); ?>',
            {
                coupon:$('input[name="coupon"]').val()
            }).done(function(resp){
                var json = $.parseJSON(resp);
                $(that).text('<?php echo $Language->get('Apply A Coupon'); ?>');
                if (json['error']) {
                    $('.coupon-entry').append('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
                if (json['redirect']) {
                    $(that).text('<?php echo $Language->get('Refreshing...'); ?>');
                    location = json['redirect'];
                }
            });
        });
    })(jQuery);
</script>