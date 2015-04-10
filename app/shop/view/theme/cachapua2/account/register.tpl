<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/message.tpl"); ?>
    <div class="info-form">
        <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="create">
            <fieldset>
                <legend><?php echo $Language->get('text_your_details'); ?></legend>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/email.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/name.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/lastname.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/company.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/rif.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/birthday.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/telephone.tpl"); ?>
            </fieldset>

            <fieldset>
                <legend><?php echo $Language->get('text_your_address'); ?></legend>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/country.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/zone.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/city.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/street.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/postcode.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/extra-address.tpl"); ?>
            </fieldset>

            <fieldset>
                <legend><?php echo $Language->get('text_your_password'); ?></legend>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/password.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/confirm.tpl"); ?>
            </fieldset>

            <span class="terms">
                <?php  echo sprintf($Language->get('text_agree'));?>
                <a href="<?php $Url::createUrl('content/page',array('page_id'=>$page_legal_terms_id)); ?>">
                    Terminos legales
                </a>
                <a href="<?php $Url::createUrl("content/page",array('page_id'=>$page_privacy_terms_id));?>">
                    Terminos legales
                </a>
            </span>
            <input type="hidden" name="activation_code" value="<?php echo md5(rand(1000000,99999999)); ?>" />
        </form>
    </div>
    <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<script>
$(function(){
    $('#create').ntForm({
        lockButton:false
    });
    $('#email').on('change',function(e){
        $.post('". Url::createUrl("account/register/checkemail") ."', {email: $(this).val()},
            function(response){
                $('#tempLink').remove();
              	var data = $.parseJSON(response);
                if (typeof data.error != 'undefined') {
                    $('#email')
                    .removeClass('neco-input-success')
                    .addClass('neco-input-error')
                    .parent()
                        .find('.neco-form-error')
                        .attr({'title':"Este email ya existe!"});
                    $('#email')
                    .closest('.row')
                        .after('<p id="tempLink" class="error">'+ data.msg +'</p>');
                } else {
                    $('#email')
                    .addClass('neco-input-success')
                    .removeClass('neco-input-error')
                    .parent().find('.neco-form-error')
                        .attr({'title':"No hay errores en este campo"});
                    $('#tempLink').remove();
          		}
            });
        }
    );
    $('#firstname,#lastname').on('change',function(e){
        if (($('#firstname').val().length != 0) && ($('#lastname').val().length != 0) && ($('#company').val().length == 0)) {
            $('#company').val($('#firstname').val() +' '+ $('#lastname').val());
        }
    });
});
</script>
<?php echo $footer; ?>