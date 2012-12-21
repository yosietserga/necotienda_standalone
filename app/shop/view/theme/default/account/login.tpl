<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
    <h1><?php echo $heading_title; ?></h1>
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <?php if ($error) { ?>
    <div class="warning"><?php echo $error; ?></div>
    <?php } ?>
    <div id="loginForm">
        <h2><?php echo $text_returning_customer; ?></h2>
        <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="login">            
            <?php echo isset($fkey)? $fkey : ''; ?>
            
            <div class="property">
                <div class="label"><?php echo $entry_email; ?></div>
                <div class="field"><input type="text" name="email" id="email" /></div>
            </div>
            
            <div class="property">
                <div class="label"><?php echo $entry_password; ?></div>
                <div class="field"><input type="password" name="password" id="password" autocomplete="off" /></div>
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
    <div class="clear"></div>
    <div id="registerForm">
      <h2><?php echo $text_i_am_new_customer; ?></h2>
      <a title="<?php echo $button_continue; ?>" href="<?php echo $register; ?>" class="button"><?php echo $button_continue; ?></a>
    </div>
  </div>

</div>
<script type="text/javascript">
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
</script>
<?php echo $footer; ?> 