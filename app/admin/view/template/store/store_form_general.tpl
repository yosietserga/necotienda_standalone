<div>
    <h2>General</h2>
    <div class="row">
        <label><?php echo $Language->get('entry_name'); ?></label>
        <input class="necoName<?php if (isset($error_name)) echo ' neco-input-error'; ?>" type="text" title="<?php echo $Language->get('help_name'); ?>" name="config_name" value="<?php echo $config_name; ?>" required="true" />
    </div>
                                          
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_rif'); ?></label>
        <input class="necoRif<?php if (isset($error_name)) echo ' neco-input-error'; ?>" type="text" title="<?php echo $Language->get('help_rif'); ?>" name="config_rif" value="<?php echo $config_rif; ?>" required="true" />
    </div>
                                      
    <div class="clear"></div>
           
    <div class="row">
        <label><?php echo $Language->get('entry_url'); ?></label>
        <input class="necoUrl<?php if (isset($error_name)) echo ' neco-input-error'; ?>" type="url" title="<?php echo $Language->get('help_url'); ?>" name="config_url" value="<?php echo $config_url; ?>" required="true" />
    </div>
                                  
    <div class="clear"></div>
    
    <div class="row">
        <label><?php echo $Language->get('entry_owner'); ?></label>
        <input class="necoCompany<?php if (isset($error_name)) echo ' neco-input-error'; ?>" type="text" title="<?php echo $Language->get('help_owner'); ?>" name="config_owner" value="<?php echo $config_owner; ?>" required="true" />
    </div>
                                     
    <div class="clear"></div>
               
    <div class="row">
        <label><?php echo $Language->get('entry_address'); ?></label>
        <textarea class="necoAddress<?php if (isset($error_name)) echo ' neco-input-error'; ?>" name="config_address" cols="40" rows="5" required="true"><?php echo $config_address; ?></textarea>
    </div>
                                          
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_email'); ?></label>
        <input class="necoEmail<?php if (isset($error_name)) echo ' neco-input-error'; ?>" type="email" title="<?php echo $Language->get('help_email'); ?>" name="config_email" value="<?php echo $config_email; ?>" required="true" />
    </div>
                                         
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_replyto_email'); ?></label>
        <input class="necoSender<?php if (isset($error_name)) echo ' neco-input-error'; ?>" type="email" title="<?php echo $Language->get('help_replyto_email'); ?>" name="config_replyto_email" value="<?php echo $config_replyto_email; ?>" />
    </div>
                                         
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_bounce_email'); ?></label>
        <input class="necoBounce<?php if (isset($error_name)) echo ' neco-input-error'; ?>" type="email" title="<?php echo $Language->get('help_bounce_email'); ?>" name="config_bounce_email" value="<?php echo $config_bounce_email; ?>" />
    </div>
                                         
    <div class="clear"></div>
                    
    <div class="row">
        <label><?php echo $Language->get('entry_telephone'); ?></label>
        <input class="necoTelePhone<?php if (isset($error_name)) echo ' neco-input-error'; ?>" type="text" title="<?php echo $Language->get('help_telephone'); ?>" name="config_telephone" value="<?php echo $config_telephone; ?>" required="true" />
    </div>  
</div>