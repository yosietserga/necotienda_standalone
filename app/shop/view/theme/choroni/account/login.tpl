<?php echo $header; ?>
<?php echo $navigation; ?>

<section id="maincontent">

    
    
    <section id="content">
    
        <div class="grid_13">
        
            <h1><?php echo $heading_title; ?></h1>
            <?php if ($success) { ?><div class="success"><?php echo $success; ?></div><?php } ?>
            <?php if ($error) { ?><div class="warning"><?php echo $error; ?></div><?php } ?>
              
            <div class="clear"></div>
            
            <div class="box">
                <div class="content">
                    <div id="loginForm" class="grid_7">
                    <h2><?php echo $text_returning_customer; ?></h2>
                    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="login">            
                        <?php echo isset($fkey)? $fkey : ''; ?>
                        
                        <div class="property">
                            <div class="field"><input type="text" name="email" id="email" placeholder="Email" /></div>
                        </div>
                        
                        <div class="property">
                            <div class="field"><input type="password" name="password" id="password" autocomplete="off" placeholder="Contrase&ntilde;a" /></div>
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
                        
                        <div class="property">
                            <div class="label">&nbsp;</div>
                            <div class="field">
                                <a title="<?php echo $text_forgotten_password; ?>" href="<?php echo str_replace('&', '&amp;', $forgotten); ?>"><?php echo $text_forgotten_password; ?></a>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label">&nbsp;</div>
                            <div class="field">
                                <a title="<?php echo $button_login; ?>" onclick="$('#login').submit();" class="button"><?php echo $button_login; ?></a>
                            </div>
                        </div>
                        <?php if ($redirect) { ?>
                            <input type="hidden" name="redirect" value="<?php echo str_replace('&', '&amp;', $redirect); ?>" />
                        <?php } ?>
                    </form>
                </div>
                
                <div class="grid_5">
                    <ul class="socialLogin">
                        <?php if ($facebook_app_id) { ?><li><a href="<?php echo $Url::createUrl("api/facebook"); ?>" title="Iniciar Sesi&oacute;n con Facebook" style="background-image: url(<?php echo HTTP_IMAGE; ?>data/social_login.png);background-position: left top;"></a></li><?php } ?>
                        <?php if ($twitter_oauth_token_secret) { ?><li><a href="<?php echo $Url::createUrl("api/twitter"); ?>" title="Iniciar Sesi&oacute;n con Twitter" style="background-image: url(<?php echo HTTP_IMAGE; ?>data/social_login.png);background-position: left center;"></a></li><?php } ?>
                        <?php if ($google_client_id) { ?><li><a id="gSigninButton">
                              <span class="g-signin"
                                data-scope="https://www.googleapis.com/auth/plus.login"
                                data-clientid="<?php echo $google_client_id; ?>"
                                data-redirecturi="postmessage"
                                data-accesstype="offline"
                                data-cookiepolicy="single_host_origin"
                                data-height="tall"
                                data-width="wide"
                                data-callback="signInCallback">
                              </span>
                            </a>
                        </li><?php } ?>
                    </ul>
                </div>


                <div class="clear"></div>
                
                <div id="registerForm">
                  <h2><?php echo $text_i_am_new_customer; ?></h2>
                  <a title="<?php echo $button_continue; ?>" href="<?php echo $register; ?>" class="button"><?php echo $button_continue; ?></a>
                </div>
                </div>
            </div>

        </div>
        
        <aside id="column_right"><?php echo $column_right; ?></aside>
        
    </section>
    
</section>
<script type="text/javascript">
$(function(){
    $('#login input').keydown(function(e) {
    	if (e.keyCode == 13) {
            if ($('#email').val().length > 0 && $('#password').val().length > 0) {
                $('#login').submit();
            }
    	}
    });
});
</script>
<?php echo $footer; ?>