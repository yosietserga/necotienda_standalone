<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/messages.tpl"); ?>

    <div class="info-form">
        <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
            <fieldset>
                <legend>Datos Personales</legend>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/name.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/lastname.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/company.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/rif.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/birthday.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/telephone.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/gender.tpl"); ?>
            </fieldset>

            <fieldset>
                <legend>Redes Sociales</legend>
                <div class="entry-twitter">
                    <label>Twitter:</label>
                    <input type="text" name="twitter" id="twitter" title="Coloca tu nombre de twitter" value="<?php echo $twitter; ?>" />
                </div>
                <div class="entry-facebook">
                    <label>Facebook:</label>
                    <input type="text" name="facebook" id="facebook" title="Coloca tu nombre de facebook o ID del perfil" value="<?php echo $facebook; ?>" />
                </div>

                <div class="entry-hotmail">
                    <label>Correo Hotmail:</label>
                    <input type="email" name="msn" id="msn" title="Coloca tu email de Hotmail o MSN" value="<?php echo $msn; ?>" />
                </div>

                <div class="entry-gmail">
                    <label>Correo Gmail:</label>
                    <input type="email" name="gmail" id="gmail" title="Coloca tu email de Gmail" value="<?php echo $gmail; ?>" />
                </div>

                <div class="entry-yahoo">
                    <label>Correo Yahoo:</label>
                    <input type="email" name="yahoo" id="yahoo" title="Coloca tu email de Yahoo" value="<?php echo $yahoo; ?>" />
                </div>

                <div class="entry-skype">
                    <label>Skype:</label>
                    <input type="text" name="skype" id="skype" title="Coloca tu usuario de Skype" value="<?php echo $skype; ?>" />
                </div>
            </fieldset>

            <fieldset>
                <legend><?php echo $Language->get('tab_profesionales'); ?></legend>

                <div class="entry-website">
                    <label>Website:</label>
                    <input type="url" name="website" id="website" value="<?php echo $website; ?>" title="Ingresa la direcci&oacute;n de tu website o el website de la empresa. P. ej. http://www.miweb.com/" />
                </div>

                <div class="entry-blog">
                    <label>Blog:</label>
                    <input type="url" name="blog" id="blog" value="<?php echo $blog; ?>" title="Ingresa la direcci&oacute;n de tu blog personal. P. ej. http://www.miblog.com/" />
                </div>

                <div class="entry-ta">
                    <label>T&iacute;tulo Acad&eacute;mico:</label>
                    <select name="titulo" title="Selecciona tu &uacute;tlimo t&iacute;tulo acad&eacute;mico obtenido">
                        <?php if (!empty($titulo)) { ?>
                        <option value="<?php echo $titulo; ?>" selected="selected"><?php echo $titulo; ?></option>
                        <?php } ?>
                          <option value="">Seleccione su t&iacute;tulo</option>
                          <option value="Bachiller">Bachiller</option>
                          <option value="T&eacute;cnico Medio">T&eacute;cnico Medio</option>
                          <option value="T&eacute;cnico Superior">T&eacute;cnico Superior</option>
                          <option value="Ingeniero">Ingeniero</option>
                          <option value="Licenciado">Licenciado</option>
                          <option value="Postgrado">Postgrado</option>
                          <option value="Especializaci&oacute;n">Especializaci&oacute;n</option>
                          <option value="Maestr&iacute;a">Maestr&iacute;a</option>
                          <option value="Doctorado">Doctorado</option>
                        </select>
                </div>

                <div class="entry-profesion">
                    <label>Profesi&oacute;n:</label>
                    <select name="profesion" title="Selecciona el &aacute;rea donde te desempe&ntilde;as o laboras">
                            <?php if (!empty($profesion)) { ?>
                                <option value="<?php echo $profesion; ?>" selected="selected"><?php echo $profesion; ?></option>
                            <?php } ?>
                              <option value="">Seleccione una profesi&oacute;n</option>
                              <option value="Estudiante">Estudiante</option>
                              <option value="Agronom&iacute;a">Agronom&iacute;a</option>
                              <option value="Antropolog&iacute;a">Antropolog&iacute;a</option>
                              <option value="Arqueolog&iacute;a">Arqueolog&iacute;a</option>
                              <option value="Arquitectura">Arquitectura</option>
                              <option value="Artista">Artista</option>
                              <option value="Asesor&iacute;a y Consultor&iacute;a">Asesor&iacute;a y Consultor&iacute;a</option>
                              <option value="Astrolog&iacute;a">Astrolog&iacute;a</option>
                              <option value="Astronom&iacute;a">Astronom&iacute;a</option>
                              <option value="Biolog&iacute;a">Biolog&iacute;a</option>
                              <option value="Cardiolog&iacute;a">Cardiolog&iacute;a</option>
                              <option value="Construcci&oacute;n">Construcci&oacute;n</option>
                              <option value="Contratista">Contratista</option>
                              <option value="Criminalista">Criminalista</option>
                              <option value="Decoraci&oacute;n">Decoraci&oacute;n</option>
                              <option value="Demograf&iacute;a">Demograf&iacute;a</option>
                              <option value="Derechos y Leyes">Derechos y Leyes</option>
                              <option value="Dermatolog&iacute;a">Dermatolog&iacute;a</option>
                              <option value="Dise&ntilde;o de Interiores">Dise&ntilde;o de Interiores</option>
                              <option value="Dise&ntilde;o Gr&aacute;fico">Dise&ntilde;o Gr&aacute;fico</option>
                              <option value="Dise&ntilde;o Web">Dise&ntilde;o Web</option>
                              <option value="Econom&iacute;a">Econom&iacute;a</option>
                              <option value="Educaci&oacute;n">Educaci&oacute;n</option>
                              <option value="Electricidad">Electricidad</option>
                              <option value="Electr&oacute;nica">Electr&oacute;nica</option>
                              <option value="Filosof&iacute;a">Filosof&iacute;a</option>
                              <option value="F&iacute;sica">F&iacute;sica</option>
                              <option value="Fotograf&iacute;a">Fotograf&iacute;a</option>
                              <option value="Geograf&iacute;a">Geograf&iacute;a</option>
                              <option value="Geolog&iacute;a">Geolog&iacute;a</option>
                              <option value="Historia">Historia</option>
                              <option value="Inform&aacute;tica">Inform&aacute;tica</option>
                              <option value="Internet">Internet</option>
                              <option value="Invenciones">Invenciones</option>
                              <option value="Inversiones">Inversiones</option>
                              <option value="Jardiner&iacute;a">Jardiner&iacute;a</option>
                              <option value="Matem&aacute;tica">Matem&aacute;tica</option>
                              <option value="Mec&aacute;nica Aeroespacial">Mec&aacute;nica Aeroespacial</option>
                              <option value="Mec&aacute;nica Aeron&aacute;utica">Mec&aacute;nica Aeron&aacute;utica</option>
                              <option value="Mec&aacute;nica Automotriz">Mec&aacute;nica Automotriz</option>
                              <option value="Mec&aacute;nica Industrial">Mec&aacute;nica Industrial</option>
                              <option value="Mec&aacute;nica Naval">Mec&aacute;nica Naval</option>
                              <option value="Medicina">Medicina</option>
                              <option value="Medico">Medico</option>
                              <option value="Metal&uacute;rjica">Metal&uacute;rjica</option>
                              <option value="Meteorolog&iacute;a">Meteorolog&iacute;a</option>
                              <option value="M&uacute;sica">M&uacute;sica</option>
                              <option value="Odontolog&iacute;a">Odontolog&iacute;a</option>
                              <option value="Periodismo">Periodismo</option>
                              <option value="Psicolog&iacute;a">Psicolog&iacute;a</option>
                              <option value="Psicopedagog&iacute;a">Psicopedagog&iacute;a</option>
                              <option value="Psicoterapia">Psicoterapia</option>
                              <option value="Psiquiatr&iacute;a">Psiquiatr&iacute;a</option>
                              <option value="Publicidad">Publicidad</option>
                              <option value="Qu&iacute;mica">Qu&iacute;mica</option>
                              <option value="Quiropr&aacute;ctica">Quiropr&aacute;ctica</option>
                              <option value="Redes y Telecomunicaciones">Redes y Telecomunicaciones</option>
                              <option value="Rob&oacute;tica">Rob&oacute;tica</option>
                              <option value="Seguridad">Seguridad</option>
                              <option value="Sexolog&iacute;a">Sexolog&iacute;a</option>
                              <option value="Sismolog&iacute;a">Sismolog&iacute;a</option>
                              <option value="Sociolog&iacute;a">Sociolog&iacute;a</option>
                        <option value="T&eacute;cnico">T&eacute;cnico</option>
                        <option value="Terapia">Terapia</option>
                        <option value="Veterinaria">Veterinaria</option>
                        <option value="Zoolog&iacute;a">Zoolog&iacute;a</option>
                    </select>
                </div>
            </fieldset>
        </form>
    </div>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>