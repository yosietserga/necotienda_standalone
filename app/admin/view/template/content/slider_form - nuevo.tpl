<?php echo $header; ?>
<?php if ($error_warning) { ?><div class="grid_24"><div class="message warning"><?php echo $error_warning; ?></div></div><?php } ?>
<div class="box">
        <h1><?php echo $heading_title; ?></h1>
        <div class="buttons">
            <a onclick="saveAndExit();$('#form').submit();" class="button"><?php echo $button_save_and_exit; ?></a>
            <a onclick="saveAndKeep();$('#form').submit();" class="button"><?php echo $button_save_and_keep; ?></a>
            <a onclick="saveAndNew();$('#form').submit();" class="button"><?php echo $button_save_and_new; ?></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
        </div>
        
        <div class="clear"></div>
                                
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        
            <div class="row">
                <label>Nombre del Banner</label>
                <input type="text" title="<?php echo $help_name; ?>" name="name" value="<?php echo $name; ?>" />
            </div>
            
            <div class="clear"></div>
            
            <div class="row">
                <label>Fecha Inicio de Publicaci&oacute;n</label>
                <input type="date" title="<?php echo $help_date_publish_start; ?>" name="date_publish_start" value="<?php echo $date_publish_start; ?>" size="12" />
            </div>
            
            <div class="clear"></div>
            
            <div class="row">
                <label>Fecha Final de Publicaci&oacute;n</label>
                <input type="date" title="<?php echo $help_date_publish_end; ?>" name="date_publish_end" value="<?php echo $date_publish_end; ?>" size="12" />
            </div>
            
            <div class="clear"></div><br />
            
            <div class="list">
                <div id="languages" class="htabs">
                <?php foreach ($languages as $language) { ?>
                    <a tab="#language<?php echo $language['language_id']; ?>" class="htab"><img src="image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
                <?php } ?>
                </div>
                <?php foreach ($languages as $language) { ?>
                <div id="language<?php echo $language['language_id']; ?>">
                        
                    <div class="row">
                        <label><?php echo $entry_title; ?></label>
                        <input type="text" id="slider_description<?php echo $language['language_id']; ?>_title" name="slider_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($slider_description[$language['language_id']]) ? $slider_description[$language['language_id']]['title'] : ''; ?>" required="true" style="width:40%" />
                        <?php if ($error_title) { ?>
                        <span class="error"><?php echo $error_title; ?></span>
                        <?php } ?>
                    </div>
                            
                    <div class="clear"></div>
                            
                    <div class="row">
                        <label><?php echo $entry_description; ?></label>
                        <textarea title="<?php echo $help_description; ?>" name="slider_description[<?php echo $language['language_id']; ?>][description]" cols="90" rows="10" style="width:40%"><?php echo isset($slider_description[$language['language_id']]) ? $slider_description[$language['language_id']]['description'] : ''; ?></textarea>
                        <?php if ($error_description) { ?>
                        <span class="error"><?php echo $error_description; ?></span>
                        <?php } ?>
                    </div>
                                              
                </div>
                <?php } ?>
                <!--
                <div class="row">
                    <label><?php echo $entry_store; ?></label>
                    <div class="scrollbox">
                    <?php $class = 'even'; ?>
                        <div class="<?php echo $class; ?>">
                        
                            <input title="<?php echo $help_store; ?>" type="checkbox" name="slider_store[]" value="0" showquick="off"<?php if (in_array(0, $slider_store)) { ?> checked="checked"<?php } ?> />
                            <?php echo $text_default; ?>
                        </div>
                        <?php foreach ($stores as $store) { ?>
                            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                            <div class="<?php echo $class; ?>">
                                
                                <input title="<?php echo $help_store; ?>" type="checkbox" name="slider_store[]" value="<?php echo $store['store_id']; ?>" showquick="off"<?php if (in_array($store['store_id'], $slider_store)) { ?> checked="checked"<?php } ?> />
                            </div>
                        <?php } ?>
                    </div>
                </div>
                            
                <div class="clear"></div>
                 -->      
                <div class="row">
                    <label><?php echo $entry_image; ?></label>
                    <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                    <img alt="Imagen de la categor&iacute;a" src="<?php echo $preview; ?>" id="preview" class="image" onclick="image_upload('image', 'preview');" width="100" height="100" />
                    <br />
                    <a onclick="image_upload('image', 'preview');" style="margin-left: 220px;color:#FFA500;font-size:10px">[ Cambiar ]</a>
                    <a onclick="image_delete('image', 'preview');" style="color:#FFA500;font-size:10px">[ Quitar ]</a>
                </div>
                            
                <div class="clear"></div>
                      
    
                <div class="row">
                    <label><?php echo $entry_link; ?></label>
                    <input type="url" title="<?php echo $help_link; ?>" name="link" value="<?php echo $link; ?>" style="width:500px" />
                    <div class="clear"></div><br />
                    <a title="Vincular Producto" onclick="showProducts()" style="margin-left: 220px;">Vincular Producto</a>&nbsp;o&nbsp;<a title="Vincular Categor&iacute;a" onclick="showCategories()">Vincular Categor&iacute;a</a>
                    <?php if ($error_link) { ?>
                    <span class="error"><?php echo $error_link; ?></span>
                    <?php } ?>
                </div>
                
            </div>
            
            <table class="list_view">
            
                <thead>
                    <tr>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody id="silders">
                <?php if ($sldiers) { foreach ($sliders as $slider) { ?>
                    <tr>
                        <td><img src="<?php echo $slider; ?>" alt="<?php echo $slider['title']; ?>" /></td>
                        <td><?php echo $slider['title']; ?></td>
                        <td><?php echo $slider['description']; ?></td>
                        <td><?php echo $slider['link']; ?></td>
                        <td><a class="button" onclick="$(this).closest('tr').remove();"></a></td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
            
        </form>
</div>
<div id="products" style="display: none;">
    <table>
        <tbody>
        <?php foreach($products as $product) { ?>
            <tr id="product_<?php echo $product['product_id']; ?>" onclick="setLink('<?php echo $product['href']; ?>')">
                <td><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" /></td>
                <td><?php echo $product['name']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<div id="categories" style="display: none;">
    <table>
        <tbody>
        <?php foreach($categories as $category) { ?>
            <tr id="category_<?php echo $category['category_id']; ?>" onclick="setLink('<?php echo $category['href']; ?>')">
                <td><?php echo $category['name']; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<div class="sidebar" id="feedbackPanel">
    <div class="tab"></div>
    <div class="content">
        <h2>Sugerencias</h2>
        <p style="margin: -10px auto 0px auto;">Tu opini&oacute;n es muy importante, dinos que quieres cambiar.</p>
        <form id="feedbackForm">
            <textarea name="feedback" id="feedback" cols="60" rows="10"></textarea>
            <input type="hidden" name="account_id" id="account_id" value="<?php echo C_CODE; ?>" />
            <input type="hidden" name="domain" id="domain" value="<?php echo HTTP_DOMAIN; ?>" />
            <input type="hidden" name="server_ip" id="server_ip" value="<?php echo $_SERVER['SERVER_ADDR']; ?>" />
            <input type="hidden" name="remote_ip" id="remote_ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
            <div class="clear"></div>
            <br />
            <div class="buttons"><a class="button" onclick="sendFeedback()">Enviar Sugerencia</a></div>
        </form>
    </div>
</div>
<?php echo $footer; ?>