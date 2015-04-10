<li class="nt-editable subscribe-widget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
    <?php if ($heading_title) { ?>
        <div class="header" id="<?php echo $widgetName; ?>Header">
            <h3><?php echo $heading_title; ?></h3>
        </div>
    <?php } ?>
    <div class="slogan">
        <span><?php echo $Language->get('text_slogan'); ?></span>
    </div>
    <div class="widget-content" id="<?php echo $widgetName; ?>Content" >
        <div class="action-input">
            <form name="subscribe" id="<?php echo $widgetName; ?>_subscribe_form" class="subscribe-form">
                <div class="row collapse">
                    <div class="input-newsletter large-11 medium-11 small-11 columns">
                        <input type="email" name="subscribe_email" id="<?php echo $widgetName; ?>_subscribe_email" value="" placeholder="Ingresa tu email" />
                    </div>
                    <div class="large-1 medium-1 small-1 columns">
                        <a id="<?php echo $widgetName; ?>_submit_subscribe"><i class="fa fa-envelope"></i></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</li>
<script>
$(function(){
    $('#<?php echo $widgetName; ?>_submit_subscribe').on('click',function(event){
        $.post('<?php echo $Url::createUrl("module/subscribe/subscribe"); ?>',
        $('#<?php echo $widgetName; ?>_subscribe_form').serialize(),
        function(response){
            $('#temp').remove();
            $('#<?php echo $widgetName; ?>_subscribe_email').removeClass('neco-input-error');
            
            try {
               data = $.parseJSON(response);
            } catch(error) {
                data = response;
            }
            
            if (typeof data.success != 'undefined') {
                $('#<?php echo $widgetName; ?>_subscribe_form input').val('');
                $('#<?php echo $widgetName; ?>_subscribe_email').after('<div class="message success" id="temp">'+ data.msg +'</div>');
            }
            
            if (typeof data.error != 'undefined') {
                $('#<?php echo $widgetName; ?>_subscribe_email').addClass('neco-input-error').after('<div class="message warning" id="temp">'+ data.msg +'</div>');
            }
        });
    });
});
</script>