<?php echo $header; ?>
<div id="login">
    <h1><a href="http://www.necotienda.com/" title="NecoTienda.com"><img src="image/logo.png" alt="NecoTienda" /></a></h1>
    <div class="box">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <label><?php echo $entry_username; ?></label>
            <input type="text" name="username" value="<?php echo $username; ?>" />
            
            <div class="clear"></div>
            
            <label><?php echo $entry_password; ?></label>
            <input type="password" name="password" value="<?php echo $password; ?>" />
            
            <div class="clear"></div>
            
            <a onclick="$('#form').submit();" class="button"><?php echo $button_login; ?></a>
            
            <div class="clear"></div>
            <a href="#" title="Haga click aqu&iacute; si olvid&oacute; su contrase&ntilde;a">&iquest;Olvid&oacute; su contrase&ntilde;a?</a>
            <?php if ($redirect) { ?>
            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
            <?php } ?>
        </form>
    </div>
</div>
<?php echo $footer; ?> 