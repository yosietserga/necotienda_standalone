<?php echo $header; ?>
<?php echo $navigation; ?>
    <section id="maincontent" class="row">

        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/message.tpl"); ?>

        <h1><?php echo $Language->get('heading_text'); ?></h1>
        <div class="simple-form">
            <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="passwordConfirmForm">
                <div class="entry-password form-entry">
                    <label for="password"><?php echo $Language->get('entry_password'); ?></label>
                    <input type="password" name="password" id="password" value="" autocomplete="off" title="Ingrese una contrase&ntilde;a que empiece con letra, tenga una longitud m&iacute;nima de 6 caracteres, contenga al menos 1 may&uacute;scula,  1 min&uacute;scula,  1 n&uacute;mero y 1 caracter especial. Le recomendamos que no utilice fechas personales ni familiares, tampoco utilice iniciales de su nombre o familiares" required="required" />
                <?php if ($error_password) { ?><div class="msg_error"><span class="error" id="error_password"><?php echo $error_password; ?></span></div><?php } ?>
                </div>

                <div class="entry-comfirm form-entry">
                    <label for="confirm"><?php echo $Language->get('entry_confirm'); ?></label>
                    <input type="password" name="confirm" id="confirm" value="" autocomplete="off" title="Vuelva a escribir la contrase&ntilde;a" />
                    <?php if ($error_confirm) { ?><div class="msg_error"><span class="error" id="error_confirm"><?php echo $error_confirm; ?></span></div><?php } ?>
                </div>
                <div class="action-button action-update">
                    <a href="javascript:void(0)">Actualizar</a>
                </div>
            </form>
        </div>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>