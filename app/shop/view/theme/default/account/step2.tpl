
    <ul class="panel">
      <li class="done"><a onclick="$('#formWrapper').load('<?php echo $personal; ?>')" title=""><b>Datos Personales</b><p>Queremos saber m&aacute;s de ti</p></a></li>
      <li class="current"><b>Socializaci&oacute;n</b><p>Queremos socializar contigo</p></li>
      <li><b>Compartir</b><p>Com&eacute;ntale a tus amigos sobre nosotros</p></li>
      <li><b>&iexcl;Gracias!</b><p>Gracias por registrarte con nosotros!</p></li>
    </ul>
    
<?php if (isset($mostrarError)) echo $mostrarError; ?>
            <div class="clear"></div>
            <h2>Contactos y Redes Sociales</h2>
            
            <div class="grid_10">
                <form id="form" method="post">
            
                    <?php echo isset($fkey)? $fkey : ''; ?>
                    <fieldset>
                        <div class="legend">Contactos</div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_msn; ?></div>
                            <div class="field">
                                <input type="text" name="msn" value="<?php echo isset($msn)?$msn:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checkmsn" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_msn) { ?>
                              <span class="error" id="error_msn"><?php echo $error_msn; ?></span>
                              <script>
                				  $("#msn").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkmsn").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_yahoo; ?></div>
                            <div class="field">
                                <input type="text" name="yahoo" value="<?php echo isset($yahoo)?$yahoo:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checkyahoo" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_yahoo) { ?>
                              <span class="error" id="error_yahoo"><?php echo $error_yahoo; ?></span>
                              <script>
                				  $("#yahoo").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkyahoo").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_gmail; ?></div>
                            <div class="field">
                                <input type="text" name="gmail" value="<?php echo isset($gmail)?$gmail:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checkgmail" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_gmail) { ?>
                              <span class="error" id="error_gmail"><?php echo $error_gmail; ?></span>
                              <script>
                				  $("#gmail").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkgmail").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_skype; ?></div>
                            <div class="field">
                                <input type="text" name="skype" value="<?php echo isset($skype)?$skype:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checkskype" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_skype) { ?>
                              <span class="error" id="error_skype"><?php echo $error_skype; ?></span>
                              <script>
                				  $("#skype").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkskype").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_facebook; ?></div>
                            <div class="field">
                                <input type="text" name="facebook" value="<?php echo isset($facebook)?$facebook:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checkfacebook" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_facebook) { ?>
                              <span class="error" id="error_facebook"><?php echo $error_facebook; ?></span>
                              <script>
                				  $("#facebook").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkfacebook").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_twitter; ?></div>
                            <div class="field">
                                <input type="text" name="twitter" value="<?php echo isset($twitter)?$twitter:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checktwitter" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_twitter) { ?>
                              <span class="error" id="error_twitter"><?php echo $error_twitter; ?></span>
                              <script>
                				  $("#twitter").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checktwitter").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_website; ?></div>
                            <div class="field">
                                <input type="text" name="website" value="<?php echo isset($website)?$website:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checkwebsite" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_website) { ?>
                              <span class="error" id="error_website"><?php echo $error_website; ?></span>
                              <script>
                				  $("#website").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkwebsite").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                        <div class="property">
                            <div class="label"><?php echo $entry_blog; ?></div>
                            <div class="field">
                                <input type="text" name="blog" value="<?php echo isset($blog)?$blog:""; ?>" />
                                <span class="required">*</span>
                                <img class="chequea" id="checkblog" src="<?php echo HTTP_IMAGE; ?>check.png" />
                            </div>
                            <div class="msg_error">
                            <?php if ($error_blog) { ?>
                              <span class="error" id="error_blog"><?php echo $error_blog; ?></span>
                              <script>
                				  $("#blog").css({"border": "2px inset #F00","background":"#F66"});
                				  $("#checkblog").attr("src","image/unchecked.png");
                                </script>
                              <?php } ?>
                            </div>
                        </div>
                        
                    </fieldset>
                    
                </form>
            </div>
            <div class="grid_5">
                <h1>Social&iacute;zate!</h1>

                <p>Ingresa tus nombres de usuarios de las redes sociales y ampl&iacute;a tus oportunidades de negocios</p>

            </div>
            
        <?php if ($prev) {  ?>
        <a title="Atr&aacute;s" class="button" onclick="$('#formWrapper').html('<img src=\'<?php echo HTTP_IMAGE; ?>nt_loader.gif\' alt=\'Cargando...\' />');$('#formWrapper').load('<?php echo $prev; ?>')">Atr&aacute;s</a>
        <?php } ?>
        <?php if ($next) {  ?>
        <a title="Omitir" class="button" onclick="$('#formWrapper').html('<img src=\'<?php echo HTTP_IMAGE; ?>nt_loader.gif\' alt=\'Cargando...\' />');$('#formWrapper').load('<?php echo $next; ?>')">Omitir Este Paso</a>
        <?php } ?>
        <a title="Guardar" class="button" onclick="$('#formWrapper').html('<img src=\'<?php echo HTTP_IMAGE; ?>nt_loader.gif\' alt=\'Cargando...\' />');$.post('<?php echo $save; ?>',$('#form').serialize(),function(data){if (data>0) {$('#formWrapper').load('<?php echo $next; ?>')} })">Guardar</a>
