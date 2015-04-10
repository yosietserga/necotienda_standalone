<div class="email-entry form-entry">
    <label><?php echo $Language->get('entry_email'); ?></label>
    <input type="email" name="email" id="email" title="Ingrese su email, &eacute;ste ser&aacute; verificado contra su servidor para validarlo" required="required" placeholder="Ingrese su email. E.j: miemail@xxx.com"/>
    <?php if ($error_email) { ?><span class="error" id="error_email"><?php echo $error_email; ?></span><?php } ?>
</div>