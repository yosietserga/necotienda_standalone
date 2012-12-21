
    <ul class="panel">
      <li class="current"><b>Datos Personales</b><p>Queremos saber m&aacute;s de ti</p></li>
      <li><b>Socializaci&oacute;n</b><p>Queremos socializar contigo</p></li>
      <li><b>Compartir</b><p>Com&eacute;ntale a tus amigos sobre nosotros</p></li>
      <li><b>&iexcl;Gracias!</b><p>Gracias por registrarte con nosotros!</p></li>
    </ul>
    
<?php if (isset($mostrarError)) echo $mostrarError; ?>
             <div class="clear"></div>
            <h2>Datos Personales</h2>

            <div class="grid_10">
                <form id="form" method="post">
            
                    <?php echo isset($fkey)? $fkey : ''; ?>
                    <fieldset>
                        <div class="legend">Datos Personales</div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_firstname; ?></div>
                            <div class="field">
                                <input type="text" name="firstname" value="<?php echo isset($firstname)?$firstname:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checkfirstname" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_firstname) { ?>
                              <span class="error" id="error_firstname"><?php echo $error_firstname; ?></span>
                              <script>
                				  $("#firstname").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkfirstname").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_lastname; ?></div>
                            <div class="field">
                                <input type="text" name="lastname" value="<?php echo isset($lastname)?$lastname:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checklastname" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_lastname) { ?>
                              <span class="error" id="error_lastname"><?php echo $error_lastname; ?></span>
                              <script>
                				  $("#lastname").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checklastname").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_telephone; ?></div>
                            <div class="field">
                                <input type="text" name="telephone" value="<?php echo isset($telephone)?$telephone:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checktelephone" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_telephone) { ?>
                              <span class="error" id="error_telephone"><?php echo $error_telephone; ?></span>
                              <script>
                				  $("#telephone").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checktelephone").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_sexo; ?></div>
                            <div class="field">
                                <select name="sexo">
                                    <option value="">Selecciona tu sexo</option>
                                    <?php if (isset($sexo) && $sexo == 'm') { ?>
                                    <option value="m" selected="selected">Hombre</option>
                                    <option value="f">Mujer</option>
                                    <?php } elseif (isset($sexo) && $sexo == 'f') { ?>
                                    <option value="m">Hombre</option>
                                    <option value="f" selected="selected">Mujer</option>
                                    <?php } else { ?>
                                    <option value="m">Hombre</option>
                                    <option value="f">Mujer</option>
                                    <?php } ?>
                                </select>
                                <span class="required">*</span>
                                <img class="chequea" id="checksexo" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_sexo) { ?>
                              <span class="error" id="error_sexo"><?php echo $error_sexo; ?></span>
                              <script>
                				  $("#sexo").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checksexo").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_nacimiento; ?></div>
                            <div class="field">
                                <select name="dia">
                                    <option value="">D&iacute;a</option>
                                    <?php $i = 1; ?>
                                    <?php $dia = substr($nacimiento,0,2); ?>
                                    <?php while ($i <= 31) { ?>
                                        <?php if ($dia == $i) { ?>
                                            <option value="<?php echo $dia; ?>" selected="selected"><?php echo $dia; ?></option>
                                        <?php } else { ?>
                                            <?php if ($i < 10) $i = "0".$i; ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php }  ?>
                                        <?php $i++; ?>
                                    <?php } ?>
                                </select>
                                &nbsp;/&nbsp;
                                <select name="mes">
                                    <option value="">Mes</option>
                                    <?php $i = 1; ?>
                                    <?php $mes = substr($nacimiento,3,2); ?>
                                    <?php while ($i <= 12) { ?>
                                        <?php if ($mes == $i) { ?>
                                            <option value="<?php echo $mes; ?>" selected="selected"><?php echo $mes; ?></option>
                                        <?php } else { ?>
                                            <?php if ($i < 10) $i = "0".$i; ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php }  ?>
                                        <?php $i++; ?>
                                    <?php } ?>
                                </select>
                                &nbsp;/&nbsp;
                                <select name="ano">
                                    <option value="">A&ntilde;o</option>
                                    <?php $i = date('Y') - 18; ?>
                                    <?php $c = date('Y') - 150; ?>
                                    <?php $ano = substr($nacimiento,6,4); ?>
                                    <?php while ($i != $c) { ?>
                                        <?php if ($ano == $i) { ?>
                                            <option value="<?php echo $ano; ?>" selected="selected"><?php echo $ano; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php }  ?>
                                        <?php $i--; ?>
                                    <?php } ?>
                                </select>
                                <span class="required">*</span>
                                <img class="chequea" id="checknacimiento" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_nacimiento) { ?>
                              <span class="error" id="error_nacimiento"><?php echo $error_nacimiento; ?></span>
                              <script>
                				  $("#nacimiento").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checknacimiento").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        
                    </fieldset>
                    
                    <fieldset>
                        <div class="legend">Direcci&oacute;n</div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_country; ?></div>
                            <div class="field">
                                <select name="country_id" id="country_id" onchange="$('#zone_id').load('index.php?r=account/complete_activation/zone&country_id=' + this.value + '&zone_id=<?php echo $zone_id; ?>');" title="Seleccione un pa&iacute;s">
                                    <option value=""><?php echo $text_select; ?></option>
                                    <?php foreach ($countries as $country) { ?>
                                        <?php if ($country['country_id'] == $country_id) { ?>
                                        <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <span class="required">*</span>
                                <img class="chequea" id="checkcountry" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_country) { ?>
                              <span class="error" id="error_country"><?php echo $error_country; ?></span>
                              <script>
                				  $("#country").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkcountry").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_zone; ?></div>
                            <div class="field">
                                <select name="zone_id" id="zone_id" title="Seleccione el estado donde reside"></select>
                                <span class="required">*</span>
                                <img class="chequea" id="checkzone" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_zone) { ?>
                              <span class="error" id="error_zone"><?php echo $error_zone; ?></span>
                              <script>
                				  $("#zone").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkzone").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_city; ?></div>
                            <div class="field">
                                <input type="text" name="city" value="<?php echo isset($city)?$city:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checkcity" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_city) { ?>
                              <span class="error" id="error_city"><?php echo $error_city; ?></span>
                              <script>
                				  $("#city").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkcity").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_address_1; ?></div>
                            <div class="field">
                                <input type="text" name="address_1" value="<?php echo isset($address_1)?$address_1:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checkaddress_1" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_address_1) { ?>
                              <span class="error" id="error_address_1"><?php echo $error_address_1; ?></span>
                              <script>
                				  $("#address_1").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkaddress_1").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                    </fieldset>
                </form>
            </div>

            <div class="grid_5">
                <h1>Bienvenido</h1>

                <p>Para completar la activaci&oacute;n de su cuenta, por favor rellene los siguientes campos con la informaci&oacute;n correspondiente.</p>

                <p>Para hacer todo m&aacute;s f&aacute;cil lo guiaremos durante el proceso.</p>

                <p><img src="image/no_image.gif" alt="no image" /></p>
            </div>
        <?php if ($prev) {  ?>
        <a title="Atr&aacute;s" class="button" onclick="$('#formWrapper').html('<img src=\'<?php echo HTTP_IMAGE; ?>nt_loader.gif\' alt=\'Cargando...\' />');$('#formWrapper').load('<?php echo $prev; ?>')">Atr&aacute;s</a>
        <?php } ?>
        <?php if ($next) {  ?>
        <a title="Omitir" class="button" onclick="$('#formWrapper').html('<img src=\'<?php echo HTTP_IMAGE; ?>nt_loader.gif\' alt=\'Cargando...\' />');$('#formWrapper').load('<?php echo $next; ?>')">Omitir Este Paso</a>
        <?php } ?>
        <a title="Guardar" class="button" onclick="$.post('<?php echo $save; ?>',$('#form').serialize(),function(data){if (data>0) {$('#formWrapper').load('<?php echo $next; ?>')} })">Guardar</a>

  <script type="text/javascript"><!--
$('select[name=\'zone_id\']').load('index.php?r=account/complete_activation/zone&country_id=<?php echo $country_id; ?>&zone_id=<?php echo $zone_id; ?>');
//--></script>