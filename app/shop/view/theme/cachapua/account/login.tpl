<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/messages.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/feature-widgets.tpl"); ?>

    <div class="large-12 medium-12 small-12 columns break">
        <span id="loginAction"></span>
        <span id="registerAction"></span>
        <div class="account-heading">
            <h1><?php echo $Language->get('text_account'); ?></h1>
        </div>
        <ul class="account-form-tabs tabs" data-tabs="account">
            <li class="tab login-tab">
                <a href="javascript:;" data-show="login" class="tab-item"><?php echo $Language->get('text_returning_customer'); ?></a>
            </li>
            <li class="tab register-tab">
                <a href="javascript:;" data-show="register" class="tab-item"><?php echo $Language->get('text_i_am_new_customer'); ?></a>
            </li>
        </ul>
        <div class="access-actions">
            <div id="loginForm" data-section="login" class="access-action simple-form">
                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="login">
                    <?php echo isset($fkey)? $fkey : ''; ?>
                        <div class="login-entry form-entry">
                            <input type="text" name="email" id="email" placeholder="Email" />
                        </div>
                        <div class="password-entry form-entry">
                            <input type="password" name="password" id="password" autocomplete="off" placeholder="Contrase&ntilde;a" />
                        </div>

                    <?php if (isset($_GET['ri'])) { ?>
                    <div class="property">
                        <script type="text/javascript" src="http://www.google.com/recaptcha/api/challenge?k=6Le5f8cSAAAAANKTNJfbv88ufw7p06EJn32gzm8I"></script>
                        <div class="field">
                            <noscript>
                               <iframe src="http://www.google.com/recaptcha/api/noscript?k=6Le5f8cSAAAAANKTNJfbv88ufw7p06EJn32gzm8I" height="300" width="500" frameborder="0"></iframe><br />
                               <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
                               <input type="hidden" name="recaptcha_response_field" value="manual_challenge" />
                            </noscript>
                            <div id="ntCaptcha"></div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="action-button action-login">
                        <a title="<?php echo $Language->get('button_login'); ?>" onclick="$('#login').submit();"><?php echo $Language->get('button_login'); ?></a>
                    </div>
                    <a class="action-forgotten" title="<?php echo $Language->get('text_forgotten_password'); ?>" href="<?php echo str_replace('&', '&amp;', $forgotten); ?>"><?php echo $Language->get('text_forgotten_password'); ?></a>
                    <?php if ($redirect) { ?>
                        <input type="hidden" name="redirect" value="<?php echo str_replace('&', '&amp;', $redirect); ?>" />
                    <?php } ?>
                </form>

                <?php if ($facebook_app_id) { ?>
                <a class="socialButton facebookButton" href="<?php echo $Url::createUrl("api/facebook",array('redirect'=>'login')); ?>"><?php echo $Language->get('button_login_with_facebook'); ?></a>
                <?php } ?>

                <?php if ($twitter_oauth_token_secret) { ?>
                <a class="socialButton twitterButton" href="<?php echo $Url::createUrl("api/twitter",array('redirect'=>'login')); ?>"><?php echo $Language->get('button_login_with_twitter'); ?></a>
                <?php } ?>

                <?php if ($google_client_id) { ?>
                <a class="socialButton googleButton" href="<?php echo $Url::createUrl("api/google",array('redirect'=>'login')); ?>"><?php echo $Language->get('button_login_with_google'); ?></a>
                <?php } ?>

                <?php if ($live_client_id) { ?>
                <a class="socialButton liveButton" href="<?php echo $Url::createUrl("api/live",array('redirect'=>'login')); ?>"><?php echo $Language->get('button_login_with_live'); ?></a>
                <?php } ?>
            </div>
            <div id="registerForm" data-section="register" class="access-action">
                <form action="<?php echo str_replace('&', '&amp;', $Url::createUrl('account/register')); ?>" method="post" enctype="multipart/form-data" id="create">
                    <div class="info-form">
                        <fieldset>
                            <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
                                <div class="heading-title">
                                    <h3>
                                        <i class="icon heading-icon fa fa-file-text fa-2x"></i>
                                        <?php echo $Language->get('text_your_details'); ?>

                                    </h3>
                                </div>
                            </div>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/email.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/name.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/lastname.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/company.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/rif.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/birthday.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/telephone.tpl"); ?>
                        </fieldset>
                    </div>

                    <div class="info-form">
                        <fieldset>
                            <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
                                <div class="heading-title">
                                    <h3>
                                        <i class="icon heading-icon fa fa-home fa-2x"></i>
                                        <?php echo $Language->get('text_your_address'); ?>

                                    </h3>
                                </div>
                            </div>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/country.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/zone.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/city.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/street.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/postcode.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/extra-address.tpl"); ?>
                        </fieldset>
                    </div>
                    <div class="info-form">
                        <fieldset>
                            <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
                                <div class="heading-title">
                                    <h3>
                                        <i class="icon heading-icon fa fa-lock fa-2x"></i>
                                        <?php echo $Language->get('text_your_password'); ?>
                                    </h3>
                                </div>
                            </div>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/password.tpl"); ?>
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/confirm.tpl"); ?>
                        </fieldset>
                    </div>

                    <p class="reminder">
                        <?php echo sprintf($Language->get('text_agree'));?>
                        <a href='<?php echo $Url::createUrl("content/page", array("page_id"=>$page_legal_terms_id)); ?>'> Legales y de
                        &nbsp;<a href='<?php echo $Url::createUrl("content/page", array("page_id"=>$page_privacy_terms_id)); ?>'>Privacidad</a>
                    </p>

                    <input type="hidden" name="activation_code" value="<?php echo md5(rand(1000000,99999999)); ?>" />
                </form>
            </div>
        </div>
    </div>
  <!--/IMPLEMENTS MOBILE-DETECTED TO HANDLE NAVS-->
</section>
<script type="text/javascript">
$(function(){
    var $accountTabs;
    if (!$.fn.ntForm) {
        $(document.createElement('script')).attr({
            'src':'<?php echo HTTP_JS; ?>necojs/neco.form.js',
            'type':'text/javascript',
            'async':1
        }).appendTo('head');

    }
    if (!$.fn.ui) {
        $(document.createElement('script')).attr({
            'src':'<?php echo HTTP_JS; ?>vendor/jquery-ui.min.js',
            'type':'text/javascript',
            'async':1
        }).appendTo('head');
        
        $(document.createElement('link')).attr({
            'href':'<?php echo HTTP_CSS; ?>jquery-ui/jquery-ui.min.css',
            'rel':'stylesheet',
            'media':'all'
        }).appendTo('head');
    }
    
    $('#login input').keydown(function(e) {
    	if (e.keyCode == 13) {
            if ($('#email').val().length > 0 && $('#password').val().length > 0) {
                $('#login').submit();
            }
    	}
    });
    
    $('#create').ntForm({
        lockButton:false,
        url:'<?php echo str_replace('&', '&amp;', $Url::createUrl('account/register')); ?>'
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

    var targetCache = {target: null};

    $accountTabs = $("*[data-tabs='account']");
    $accountTabs.on('click', function (e) {
        e.stopPropagation();
        var target = e.target;
        var $target = $(target);
        var show = target.dataset.show;
        var $sections = $("*[data-section]");

        if (targetCache[target]) {
           $(targetCache[target]).removeClass("active")
        }
        if (show) {
            $sections.each(function (i, section) {
                var $section = $(section);
                if (section.dataset.section === show) {
                    $section.css('display', 'block');
                } else {
                    $section.css('display', 'none');
                }
            });
            $target.addClass("active");
            targetCache[target] = target;
        }
    });

});
</script>
<?php echo $footer; ?>