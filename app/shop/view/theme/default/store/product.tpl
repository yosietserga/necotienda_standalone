<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent">
    <aside id="column_left"><?php echo $column_left; ?></aside>
    <section id="content">
        <div class="grid_10">
            <h1><?php echo $heading_title; ?></h1>
            <div id="images">
                <a title="<?php echo $heading_title; ?>" href="<?php echo str_replace('&', '&amp;', $popup); ?>" id="popup"  class="thickbox" rel="product_images">
                    <img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" id="image" />
                </a>
                <?php   if ($images) { ?>
                <div id="imageScroller">
                    <ul id="productCarousel" class="jcarousel-skin-tango">
                    <?php foreach ($images as $k => $image) { ?>
                    <li><a title="<?php echo $heading_title; ?>">
                            <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                            <input type="hidden" name="img_<?php echo $k; ?>" value="<?php echo str_replace('&', '&amp;', $image['preview']); ?>" class="preview" />
                            <input type="hidden" name="popup_<?php echo $k; ?>" value="<?php echo str_replace('&', '&amp;', $image['popup']); ?>" class="popup" />
                            <a style="display: none;" href="<?php echo str_replace('&', '&amp;', $image['popup']); ?>" rel="product_images">
                                <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" />
                            </a>
                        </a>
                    </li>
                    <?php } ?>
                    </ul>
                  </div>
                  <?php }  ?>
            </div>
    
            <div id="overview">
                <?php if ($display_price) { ?>
                    <div>
                        <?php if (!$special) { ?>
                            <p class="price"><?php echo $price; ?></p>
                        <?php } else { ?>
                            <p class="old_price"><?php echo $price; ?></p>
                            <p class="new_price"><?php echo $special; ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>
                
                <div class="property model">
                    <p><b><?php echo $text_model; ?></b></p>
                    <p><?php echo $model; ?></p>
                </div>
                
                <div class="property availability">
                    <p><b><?php echo $text_availability; ?></b></p>
                    <p><?php echo $stock; ?></p>
                </div>
                
                <?php if ($manufacturer) { ?>
                <div class="property manufacturer">
                    <p><b><?php echo $text_manufacturer; ?></b></p>
                    <p><a title="<?php echo $manufacturer; ?>" href="<?php echo str_replace('&', '&amp;', $manufacturers); ?>"><?php echo $manufacturer; ?></a></p>
                </div>
                <?php } ?>
                
                <?php if ($review_status) { ?>
                <div class="property average">
                    <p><b><?php echo $text_average; ?></b></p>
                    <?php if ($average) { ?>
                        <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $average . '.png'; ?>" alt="<?php echo $text_stars; ?>" />
                    <?php } else { ?>
                        <p><?php echo $text_no_rating; ?></p>
                    <?php } ?>
                </div>
                <?php } ?>
                
                <?php if ($tags) { ?>
                <div class="property tags">
                    <p><b><?php echo $text_tags; ?></b></p>
                    <?php foreach ($tags as $tag) { ?>
                        <a title="<?php echo $tag['tag']; ?>" href="<?php echo str_replace('&', '&amp;', $tag['href']); ?>"><?php echo $tag['tag']; ?></a>, 
                    <?php } ?>
                </div>
                <?php } ?>
                
                <?php if ($display_price) { ?>
                <div class="property options">
                    <?php if ($options) { ?>
                        <p><b><?php echo $text_options; ?></b></p>
                        <ul>
                        <?php foreach ($options as $option) { ?>
                            <li>
                                <div class="label"><?php echo $option['name']; ?>:</div>
                                <select name="option[<?php echo $option['option_id']; ?>]">
                                <?php foreach ($option['option_value'] as $option_value) { ?>
                                    <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                    <?php if ($option_value['price']) { ?>
                                        <?php echo $option_value['prefix']; ?><?php echo $option_value['price']; ?>
                                    <?php } ?>
                                    </option>
                                <?php } ?>
                                </select>
                            </li>                    
                        <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <?php } ?>
                
                <?php if ($discounts) { ?>
                <div class="property discount">
                    <p><b><?php echo $text_discount; ?></b></p>
                    <p><b><?php echo $text_order_quantity; ?></b></p>
                    <p><b><?php echo $text_price_per_item; ?></b></p>
                    <?php foreach ($discounts as $discount) { ?>
                        <p>
                            <?php echo $discount['quantity']; ?>
                            <?php echo $discount['price']; ?>
                        </p>
                    <?php } ?>
                </div>
                <?php } ?>
                
                
                <div class="property quantity">
                    <p><b><?php echo $text_qty; ?></b></p>
                    <p>
                        <input type="text" name="quantity" size="3" value="<?php echo $minimum; ?>" />
                        <a title="<?php echo $button_add_to_cart; ?>" onclick="$('#product').submit();" id="add_to_cart" class="button"><span><?php echo $button_add_to_cart; ?></span></a>
                        <?php if ($minimum> 1) { ?><br><small><?php echo $text_minimum; ?></small><?php } ?>
                    </p>
                </div>
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                <input type="hidden" name="redirect" value="<?php echo str_replace('&', '&amp;', $redirect); ?>" />
            </div>
                    
            <div class="clear"></div>
            <div id="description" class="box">
                <div class="header"><h1>Descripci&oacute;n</h1></div>
                <div class="content"><p><?php echo $description; ?></p></div>
            </div>
            
            
            <div class="clear"></div>
            <div id="related" class="box"><img src='<?php echo HTTP_IMAGE; ?>nt_loader.gif' alt='Cargando...' /></div>
            
            
            <div class="clear"></div>
            <div class="box">
                <div class="header"><h1>Comentarios</h1></div>
                <div id="review" class="content"><img src='<?php echo HTTP_IMAGE; ?>nt_loader.gif' alt='Cargando...' /></div>
            </div>
            
            <div class="clear"></div>
            <div id="comment" class="box"><img src='<?php echo HTTP_IMAGE; ?>nt_loader.gif' alt='Cargando...' /></div>

    </section>
    <aside id="column_right"><?php echo $column_right; ?></aside>
</section>
<?php echo $footer; ?> 