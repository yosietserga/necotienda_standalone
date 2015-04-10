<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    <section id="maincontent">
        <section id="content">
        <?php if ($column_left) { ?><aside id="column_left" class="grid_3"><?php echo $column_left; ?></aside><?php } ?>
        
        <?php if ($column_left && $column_right) { ?>
        <div class="grid_6">
        <?php } elseif ($column_left || $column_right) { ?>
        <div class="grid_9">
        <?php } else { ?>
        <div class="grid_12">
        <?php } ?>
            
        
            <h1><?php echo $heading_title; ?></h1>
            <?php if ($error_warning) { ?><div class="message warning"><?php echo $error_warning; ?></div><?php } ?>
              
            <div class="clear"></div>
            
            <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="create">
                <fieldset>
                    <legend><?php echo $Language->get('text_your_details'); ?></legend>
              
                    <div class="row">
                        <label><?php echo $Language->get('entry_email'); ?></label>
                        <input type="email" name="email" id="email" value="<?php echo $email; ?>" title="Ingrese su email, &eacute;ste ser&aacute; verificado contra su servidor para validarlo" required="required" />
                        <?php if ($error_email) { ?><div class="msg_error"><span class="error" id="error_email"><?php echo $error_email; ?></span></div><?php } ?>
                    </div>
                  
                    <div class="clear"></div>
                    
                    <div class="row">
                        <label><?php echo $Language->get('entry_firstname'); ?></label>
                        <input type="text" id="firstname" name="firstname" value="<?php echo $firstname; ?>" title="Ingrese sus nombres" required="required" />
                        <?php if ($error_firstname) { ?><div class="msg_error"><span class="error" id="error_firstname"><?php echo $error_firstname; ?></span></div><?php } ?>
                    </div>
                    
                    <div class="clear"></div>

                    <div class="row">
                        <label><?php echo $Language->get('entry_lastname'); ?></label>
                        <input type="text" id="lastname" name="lastname" value="<?php echo $lastname; ?>" title="Ingrese sus apellidos" required="required" />
                        <?php if ($error_lastname) { ?><div class="msg_error"><span class="error" id="error_lastname"><?php echo $error_lastname; ?></span></div><?php } ?>
                    </div>
                    
                    <div class="clear"></div>

                    <div class="row">
                        <label><?php echo $Language->get('entry_company'); ?></label>
                        <input type="text" id="company" name="company" value="<?php echo $company; ?>" title="Ingrese su nombre y apellido si es persona natural sino ingrese el nombre de su organizaci&oacute;n" required="required" />
                        <?php if ($error_company) { ?><div class="msg_error"><span class="error" id="error_company"><?php echo $error_company; ?></span></div><?php } ?>
                    </div>
                    
                    <div class="clear"></div>

                    <div class="row">
                        <label><?php echo $Language->get('entry_rif'); ?></label>
                        <select name="riftype" title="Selecciona el tipo de documentaci&oacute;n">
                            <option value="V">V</option>
                            <option value="J">J</option>
                            <option value="E">E</option>
                            <option value="G">G</option>
                        </select>
                        <input type="text" id="rif" name="rif" value="<?php echo $rif; ?>" title="Por favor ingrese su RIF. Si es persona natural y a&uacute;n no posee uno, ingrese su n&uacute;mero de c&eacute;dula con un n&uacute;mero cero al final" required="required" />
                        <?php if ($error_rif) { ?><div class="msg_error"><span class="error" id="error_rif"><?php echo $error_rif; ?></span></div><?php } ?>
                    </div>
                      
                    <div class="clear"></div>

                    <div class="row">
                        <label><?php echo $Language->get('entry_birthday'); ?></label>
                        <select name="bday" title="Selecciona el d&iacute;a de su nacimiento">
                        <?php
                        $day = 1;
                        $toDay = 31;
                        while ($toDay >= $day) { ?>
                        <?php $day = ($day < 10) ? '0'.$day : $day; ?>
                            <option value="<?php echo $day; ?>"<?php if ($day == $bday) { ?> selected="selected"<?php } ?>><?php echo $day; ?></option>
                        <?php
                            $day++; 
                        }
                        ?>
                        </select>
                        <select name="bmonth" title="Selecciona el mes de su nacimiento">
                        <?php
                        $month = 1;
                        $toMonth = 12;
                        while ($toMonth >= $month) { ?>
                        <?php $month = ($month < 10) ? '0'.$month : $month; ?>
                            <option value="<?php echo $month; ?>"<?php if ($month == $bmonth) { ?> selected="selected"<?php } ?>><?php echo $month; ?></option>
                        <?php
                            $month++; 
                        }
                        ?>
                        </select>
                        <select name="byear" title="Selecciona el a&ntilde;o de su nacimiento">
                        <?php
                        $currentYear = date('Y');
                        $fromYear = $currentYear - 100;
                        while ($fromYear < $currentYear) { ?>
                            <option value="<?php echo $currentYear; ?>"<?php if ($currentYear == $byear) { ?> selected="selected"<?php } ?>><?php echo $currentYear; ?></option>
                        <?php
                            $currentYear--; 
                        }
                        ?>
                        </select>
                    </div>
                      
                    <div class="clear"></div>

                    <div class="row">
                        <label><?php echo $Language->get('entry_telephone'); ?></label>
                        <input type="text" id="telephone" name="telephone" value="<?php echo $telephone; ?>" title="Ingrese su n&uacute;mero de tel&eacute;fono" required="required" />
                        <?php if ($error_telephone) { ?><div class="msg_error"><span class="error" id="error_telephone"><?php echo $error_telephone; ?></span></div><?php } ?>
                    </div>
                    
                    <div class="clear"></div>
                    
                    <div class="row">
                        <label><?php echo $Language->get('entry_referencedBy'); ?></label>
                        <input type="text" name="referencedBy" id="referencedBy" value="<?php echo $referencedBy; ?>" title="Ingrese el email del cliente que lo referenci&oacute;" />
                        <?php if ($error_referencedBy) { ?><div class="msg_error"><span class="error" id="error_referencedBy"><?php echo $error_referencedBy; ?></span></div><?php } ?>
                    </div>
                  
                </fieldset>
                    
                <fieldset>
                    <legend><?php echo $Language->get('text_your_address'); ?></legend>
                    <div class="row">
                        <label for="country_id"><?php echo $Language->get('entry_country'); ?></label>
                        <select name="country_id" id="country_id" title="Selecciona el pa&iaacute;s dodne reside" onchange="$('select[name=\'zone_id\']').load('index.php?r=account/register/zone&country_id=' + this.value + '&zone_id=<?php echo $zone_id; ?>');">
                            <option value="false">-- Por Favor Seleccione --</option>
                            <?php foreach ($countries as $country) { ?>
                            <option value="<?php echo $country['country_id']; ?>"<?php if ($country['country_id'] == $country_id) { ?> selected="selected"<?php } ?>><?php echo $country['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="clear"></div>

                    <div class="row">
                        <label for="zone_id"><?php echo $Language->get('entry_zone'); ?></label>
                        <select name="zone_id" id="zone_id" title="Selecciona el estado de tu residencia">
                            <option value="false">-- Seleccione un pa&iacute;s --</option>
                        </select>
                    </div>
                      
                    <div class="clear"></div>

                    <div class="row">
                        <label for="city"><?php echo $Language->get('entry_city'); ?></label>
                        <input type="text" id="city" name="city" value="<?php echo $city; ?>" required="required" title="Ingrese el nombre de la ciudad donde reside" />
                    </div>
                  
                    <div class="clear"></div>

                    <div class="row">
                        <label for="street"><?php echo $Language->get('entry_street'); ?></label>
                        <input type="text" id="street" name="street" value="<?php echo $street; ?>" required="required" title="Ingrese el nombre de la ciudad donde reside" />
                    </div>
                  
                    <div class="clear"></div>

                    <div class="row">
                        <label for="postcode"><?php echo $Language->get('entry_postcode'); ?></label>
                        <input type="necoNumber" id="postcode" name="postcode" value="<?php echo $postcode; ?>" required="required" title="Ingrese el c&oacute;digo postal de su residencia" />
                    </div>
                  
                    <div class="clear"></div>

                    <div class="row">
                        <label for="address_1"><?php echo $Language->get('entry_address_1'); ?></label>
                        <input type="text" id="address_1" name="address_1" value="<?php echo $address_1; ?>" required="required" title="Ingrese la direcci&oacute;n de habitaci&oacute;n" />
                    </div>
                        
                    <div class="clear"></div>
                    
                </fieldset>
                
                <fieldset>
                    <legend><?php echo $Language->get('text_your_password'); ?></legend>
                    <div class="row">
                        <label><?php echo $Language->get('entry_password'); ?></label>
                        <input type="password" name="password" id="password" value="" autocomplete="off" title="Ingrese una contrase&ntilde;a que empiece con letra, tenga una longitud m&iacute;nima de 6 caracteres, contenga al menos 1 may&uacute;scula,  1 min&uacute;scula,  1 n&uacute;mero y 1 caracter especial. Le recomendamos que no utilice fechas personales ni familiares, tampoco utilice iniciales de su nombre o familiares" required="required" />
                    <?php if ($error_password) { ?><div class="msg_error"><span class="error" id="error_password"><?php echo $error_password; ?></span></div><?php } ?>
                    </div>
                  
                    <div class="clear"></div>
                    
                    <div class="row">
                        <label><?php echo $Language->get('entry_confirm'); ?></label>
                        <input type="password" name="confirm" id="confirm" value="" autocomplete="off" title="Vuelva a escribir la contrase&ntilde;a" />
                    <?php if ($error_confirm) { ?><div class="msg_error"><span class="error" id="error_confirm"><?php echo $error_confirm; ?></span></div><?php } ?>
                    </div>
                  
                </fieldset>
                
                <p><?php echo sprintf($Language->get('text_agree'),
                $Url::createUrl("content/page",array('page_id'=>$page_legal_terms_id)),
                $Url::createUrl("content/page",array('page_id'=>$page_privacy_terms_id))); ?></p>
                
                <input type="hidden" name="activation_code" value="<?php echo md5(rand(1000000,99999999)); ?>" />
            </form>
            
            <div class="clear"></div>
            <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
            <div class="clear"></div>

            <div class="grid_12">
                <div id="featuredFooter">
                <ul class="widgets" data-position="featuredFooter"><?php if($featuredFooterWidgets) { foreach ($featuredFooterWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } } ?></ul>
                </div>
            </div>

            
        </div>
        
        <?php if ($column_right) { ?><aside id="column_right" class="grid_3"><?php echo $column_right; ?></aside><?php } ?>

        </section>
    </section>
</div>
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