<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

    <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="form">
        <div class="info-form">
            <fieldset>
                <div class="heading widget-heading feature-heading form-heading" id="<?php echo $widgetName; ?>Header">
                  <div class="heading-title">
                      <h3>
                        <i class="icon heading-icon icon-user">
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/user.tpl"); ?>
                        </i>
                          <?php echo $Language->get('text_legend_personal_data');?>
                      </h3>
                    </div>
                </div>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/name.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/lastname.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/company.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/rif.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/birthday.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/telephone.tpl"); ?>
                <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/fields/gender.tpl"); ?>
            </fieldset>
        </div>

        <div class="info-form">
            <fieldset>
                <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
                    <div class="heading widget-heading feature-heading form-heading" id="<?php echo $widgetName; ?>Header">
                        <div class="heading-title">
                            <h3>
                                <i class="heading-icon icon icon-folder-open">
                                    <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/newspaper.tpl"); ?>
                                </i>
                                <?php echo $Language->get('text_legend_social_web');?>
                           </h3>
                        </div>
                     </div>
                </div>
                <div class="entry-twitter form-entry">
                    <label>Twitter:</label>
                    <input type="text" name="twitter" id="twitter" title="Coloca tu nombre de twitter" value="<?php echo $twitter; ?>"  placeholder="<?php echo $Language->get('text_twitter');?>" />
                </div>
                <div class="entry-facebook form-entry">
                    <label>Facebook:</label>
                    <input type="text" name="facebook" id="facebook" title="Coloca tu nombre de facebook o ID del perfil" value="<?php echo $facebook; ?>" placeholder="<?php echo $Language->get('text_facebook');?>" />
                </div>

                <div class="entry-hotmail form-entry">
                    <label>Hotmail:</label>
                    <input type="email" name="msn" id="msn" title="Coloca tu email de Hotmail o MSN" value="<?php echo $msn; ?>" placeholder="<?php echo $Language->get('text_hotmail');?>"/>
                </div>

                <div class="entry-gmail form-entry">
                    <label>Gmail:</label>
                    <input type="email" name="gmail" id="gmail" title="Coloca tu email de Gmail" value="<?php echo $gmail; ?>" placeholder="<?php echo $Language->get('text_gmail');?>"/>
                </div>

                <div class="entry-yahoo form-entry">
                    <label>Yahoo:</label>
                    <input type="email" name="yahoo" id="yahoo" title="Coloca tu email de Yahoo" value="<?php echo $yahoo; ?>" placeholder="<?php echo $Language->get('text_yahoo');?>" />
                </div>

                <div class="entry-skype form-entry">
                    <label>Skype:</label>
                    <input type="text" name="skype" id="skype" title="Coloca tu usuario de Skype" value="<?php echo $skype; ?>" placeholder="<?php echo $Language->get('text_skype');?>"/>
                </div>
            </fieldset>
        </div>

        <div class="info-form">
            <fieldset>
                <div class="heading widget-heading feature-heading" id="<?php echo $widgetName; ?>Header">
                  <div class="heading widget-heading feature-heading form-heading" id="<?php echo $widgetName; ?>Header">
                      <div class="heading-title">
                          <h3>
                              <i class="heading-icon icon icon-magic-wand">
                                 <?php include(DIR_TEMPLATE. $this->config->get('config_template') . "/shared/icons/magic-wand.tpl"); ?>
                              </i>
                              <?php echo $Language->get('tab_profesionales'); ?>
                          </h3>
                      </div>
                    </div>
                </div>

                <div class="entry-website form-entry">
                    <label>Website:</label>
                    <input type="url" name="website" id="website" value="<?php echo $website; ?>" title="Ingresa la direcci&oacute;n de tu website o el website de la empresa. P. ej. http://www.miweb.com/" placeholder="<?php echo $Language->get('text_website');?>"/>
                </div>

                <div class="entry-blog form-entry">
                    <label>Blog:</label>
                    <input type="url" name="blog" id="blog" value="<?php echo $blog; ?>" title="Ingresa la direcci&oacute;n de tu blog personal. P. ej. http://www.miblog.com/" placeholder="<?php echo $Language->get('text_blog'); ?>" />
                </div>

                <div class="entry-ta form-entry">
                    <label><?php echo $Language->get('select_option_academic_title');?></label>

                    <select name="titulo" title="Selecciona tu &uacute;tlimo t&iacute;tulo acad&eacute;mico obtenido">
                        <?php if (!empty($titulo)) { ?>
                        <option value="<?php echo $titulo; ?>" selected="selected"><?php echo $titulo; ?></option>
                        <?php } ?>
                          <option value=""><?php echo $Language->get('select_option_title');?></option>
                          <option value="<?php echo $Language->get('select_option_bechiller');?>"><?php echo $Language->get('select_option_bechiller');?></option>
                          <option value="<?php echo $Language->get('select_option_medico');?>"><?php echo $Language->get('select_option_medico');?></option>
                          <option value="<?php echo $Language->get('select_option_tecnico');?>"><?php echo $Language->get('select_option_tecnico');?></option>
                          <option value="<?php echo $Language->get('select_option_ingeniero');?>"><?php echo $Language->get('select_option_ingeniero');?></option>
                          <option value="<?php echo $Language->get('select_option_licenciado');?>"><?php echo $Language->get('select_option_licenciado');?></option>
                          <option value="<?php echo $Language->get('select_option_postgrado');?>"><?php echo $Language->get('select_option_postgrado');?></option>
                          <option value="<?php echo $Language->get('select_option_especializacion');?>"><?php echo $Language->get('select_option_especializacion');?></option>
                          <option value="<?php echo $Language->get('select_option_maestria');?>"><?php echo $Language->get('select_option_maestria');?></option>
                          <option value="<?php echo $Language->get('select_option_doctorado');?>"><?php echo $Language->get('select_option_doctorado');?></option>
                        </select>
                </div>

                <div class="entry-profesion form-entry">
                    <label><?php echo $Language->get('text_profesion');?></label>
                    <select name="profesion" title="Selecciona el &aacute;rea donde te desempe&ntilde;as o laboras">
                        <?php if (!empty($profesion)) { ?>
                            <option value="<?php echo $profesion; ?>" selected="selected"><?php echo $profesion; ?></option>
                        <?php } ?>
                            <option value=""><?php echo $Language->get('select_option_profesion');?></option>
                            <option value="<?php echo $Language->get('select_option_estudiante');?>"><?php echo $Language->get('select_option_estudiante');?></option>
                            <option value="<?php echo $Language->get('select_option_agronomia');?>"><?php echo $Language->get('select_option_agronomia');?></option>
                            <option value="<?php echo $Language->get('select_option_antropologia');?>"><?php echo $Language->get('select_option_antropologia');?></option>
                            <option value="<?php echo $Language->get('select_option_arqueologia');?>"><?php echo $Language->get('select_option_arqueologia');?></option>
                            <option value="<?php echo $Language->get('select_option_arquitectura');?>"><?php echo $Language->get('select_option_arquitectura');?></option>
                            <option value="<?php echo $Language->get('select_option_artista');?>"><?php echo $Language->get('select_option_artista');?></option>
                            <option value="<?php echo $Language->get('select_option_asesoria');?>"><?php echo $Language->get('select_option_asesoria');?></option>
                            <option value="<?php echo $Language->get('select_option_astrologia');?>"><?php echo $Language->get('select_option_astrologia');?></option>
                            <option value="<?php echo $Language->get('select_option_astronomia');?>"><?php echo $Language->get('select_option_astronomia');?></option>
                            <option value="<?php echo $Language->get('select_option_biologia');?>"><?php echo $Language->get('select_option_biologia');?></option>
                            <option value="<?php echo $Language->get('select_option_cardiologia');?>"><?php echo $Language->get('select_option_cardiologia');?></option>
                            <option value="<?php echo $Language->get('select_option_construccion');?>"><?php echo $Language->get('select_option_construccion');?></option>
                            <option value="<?php echo $Language->get('select_option_contratista');?>"><?php echo $Language->get('select_option_contratista');?></option>
                            <option value="<?php echo $Language->get('select_option_criminalista');?>"><?php echo $Language->get('select_option_criminalista');?></option>
                            <option value="<?php echo $Language->get('select_option_decoracion');?>"><?php echo $Language->get('select_option_decoracion');?></option>
                            <option value="<?php echo $Language->get('select_option_demografia');?>"><?php echo $Language->get('select_option_decoracion');?></option>
                            <option value="<?php echo $Language->get('select_option_derechos');?>"><?php echo $Language->get('select_option_derechos');?></option>
                            <option value="<?php echo $Language->get('select_option_dermatologia');?>"><?php echo $Language->get('select_option_dermatologia');?></option>
                            <option value="<?php echo $Language->get('select_option_diseño_grafico');?>"><?php echo $Language->get('select_option_diseño_grafico');?></option>
                            <option value="<?php echo $Language->get('select_option_diseño_web');?>"><?php echo $Language->get('select_option_diseño_web');?></option>
                            <option value="<?php echo $Language->get('select_option_economia');?>"><?php echo $Language->get('select_option_economia');?></option>
                            <option value="<?php echo $Language->get('select_option_educacion');?>"><?php echo $Language->get('select_option_educacion');?></option>
                            <option value="<?php echo $Language->get('select_option_electricidad');?>"><?php echo $Language->get('select_option_electricidad');?></option>
                            <option value="<?php echo $Language->get('select_option_electronica');?>"><?php echo $Language->get('select_option_electronica');?></option>
                            <option value="<?php echo $Language->get('select_option_filosofia');?>"><?php echo $Language->get('select_option_filosofia');?></option>
                            <option value="<?php echo $Language->get('select_option_fisica');?>"><?php echo $Language->get('select_option_fisica');?></option>
                            <option value="<?php echo $Language->get('select_option_fotografia');?>"><?php echo $Language->get('select_option_fotografia');?></option>
                            <option value="<?php echo $Language->get('select_option_geografia');?>"><?php echo $Language->get('select_option_geografia');?></option>
                            <option value="<?php echo $Language->get('select_option_geologia');?>"><?php echo $Language->get('select_option_geologia');?></option>
                            <option value="<?php echo $Language->get('select_option_historia');?>"><?php echo $Language->get('select_option_historia');?></option>
                            <option value="<?php echo $Language->get('select_option_informatica');?>"><?php echo $Language->get('select_option_informatica');?></option>
                            <option value="<?php echo $Language->get('select_option_internet');?>"><?php echo $Language->get('select_option_internet');?></option>
                            <option value="<?php echo $Language->get('select_option_invenciones');?>"><?php echo $Language->get('select_option_invenciones');?></option>
                            <option value="<?php echo $Language->get('select_option_inversiones');?>"><?php echo $Language->get('select_option_inversiones');?></option>
                            <option value="<?php echo $Language->get('select_option_jardineria');?>"><?php echo $Language->get('select_option_jardineria');?></option>
                            <option value="<?php echo $Language->get('select_option_matematica');?>"><?php echo $Language->get('select_option_matematica');?></option>
                            <option value="<?php echo $Language->get('select_option_aeroespacial');?>"><?php echo $Language->get('select_option_aeroespacial');?></option>
                            <option value="<?php echo $Language->get('select_option_aeronautica');?>"><?php echo $Language->get('select_option_aeronautica');?></option>
                            <option value="<?php echo $Language->get('select_option_automotriz');?>"><?php echo $Language->get('select_option_automotriz');?></option>
                            <option value="<?php echo $Language->get('select_option_industrial');?>"><?php echo $Language->get('select_option_industrial');?></option>
                            <option value="<?php echo $Language->get('select_option_naval');?>"><?php echo $Language->get('select_option_naval');?></option>
                            <option value="<?php echo $Language->get('select_option_medicina');?>"><?php echo $Language->get('select_option_medicina');?></option>
                            <option value="<?php echo $Language->get('select_option_metalurgica');?>"><?php echo $Language->get('select_option_metalurgica');?></option>
                            <option value="<?php echo $Language->get('select_option_meteorologia');?>"><?php echo $Language->get('select_option_meteorologia');?></option>
                            <option value="<?php echo $Language->get('select_option_odontologia');?>"><?php echo $Language->get('select_option_odontologia');?></option>
                            <option value="<?php echo $Language->get('select_option_periodismo');?>"><?php echo $Language->get('select_option_periodismo');?></option>
                            <option value="<?php echo $Language->get('select_option_psicologia');?>"><?php echo $Language->get('select_option_psicologia');?></option>
                            <option value="<?php echo $Language->get('select_option_psicoterapia');?>"><?php echo $Language->get('select_option_psicoterapia');?></option>
                            <option value="<?php echo $Language->get('select_option_psiquiatria');?>"><?php echo $Language->get('select_option_psiquiatria');?></option>
                            <option value="<?php echo $Language->get('select_option_publicidad');?>"><?php echo $Language->get('select_option_publicidad');?></option>
                            <option value="<?php echo $Language->get('select_option_quimica');?>"><?php echo $Language->get('select_option_quimica');?></option>
                            <option value="<?php echo $Language->get('select_option_quiropractica');?>"><?php echo $Language->get('select_option_quiropractica');?></option>
                            <option value="<?php echo $Language->get('select_option_redes');?>"><?php echo $Language->get('select_option_redes');?></option>
                            <option value="<?php echo $Language->get('select_option_robotica');?>"><?php echo $Language->get('select_option_robotica');?></option>
                            <option value="<?php echo $Language->get('select_option_seguridad');?>"><?php echo $Language->get('select_option_seguridad');?></option>
                            <option value="<?php echo $Language->get('select_option_sexologia');?>"><?php echo $Language->get('select_option_sexologia');?></option>
                            <option value="<?php echo $Language->get('select_option_sismologia');?>"><?php echo $Language->get('select_option_sismolougia');?></option>
                            <option value="<?php echo $Language->get('select_option_socialogia');?>"><?php echo $Language->get('select_option_socialogia');?></option>
                            <option value="<?php echo $Language->get('select_option_tecnico');?>"><?php echo $Language->get('select_option_tecnico');?></option>
                            <option value="<?php echo $Language->get('select_option_veterinaria');?>"><?php echo $Language->get('select_option_veterinaria');?></option>
                            <option value="<?php echo $Language->get('select_option_zoologia');?>"><?php echo $Language->get('select_option_zoologia');?></option>
                    </select>
                </div>
            </fieldset>
        </div>
        <div class="necoform-actions" data-actions="necoform"></div>
    </form>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
</section>
<?php echo $footer; ?>