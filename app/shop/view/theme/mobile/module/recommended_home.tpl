<?php if($products) { ?>
<li class="nt-editable content latestWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">
<?php if ($heading_title) { ?><div class="header" id="<?php echo $widgetName; ?>Header"><hgroup><h1><?php echo $heading_title; ?></h1></hgroup></div><?php } ?>
    
    <?php if ($sort) { ?>
    <div class="sort">
        <select name="sort" <?php echo (array_key_exists('ajax',$sorts[0])) ? "onchange='sort(this,this.value)' " : "onchange='window.location = this.value'"; ?>>
          <?php foreach ($sorts as $sorted) { ?>
              <?php if (($sort . '-' . $order) == $sorted['value']) { ?>
                <option value="<?php echo $sorted['href']; ?>" selected="selected"><?php echo $sorted['text']; ?></option>
              <?php } else { ?>
                <option value="<?php echo $sorted['href']; ?>"><?php echo $sorted['text']; ?></option>
              <?php } ?>
          <?php } ?>
        </select>
      <?php echo $text_sort; ?>
      
          <?php if (isset($_GET['v']) && $_GET['v']=='list') { ?>
          <a class="view_style" onclick="$('#products').html('<img src=\'<?php echo HTTP_IMAGE; ?>loader.gif\' alt=\'Cargando...\' />');$('#products').load('<?php echo str_replace('&', '&amp;', $gridView); ?>')" title="Ver en Miniaturas"  style="background-position:0 -23px">&nbsp;</a>    
          <?php } else { ?>
          <a class="view_style" onclick="$('#products').html('<img src=\'<?php echo HTTP_IMAGE; ?>loader.gif\' alt=\'Cargando...\' />');$('#products').load('<?php echo str_replace('&', '&amp;', $listView); ?>')" title="Ver en Listado">&nbsp;</a>    
          <?php } ?>
    </div> 
    <?php } ?>

    <div class="clear"></div>
    <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
    <div class="clear"></div>
    
    <div class="list_view" id="productsWrapper">
        <ul>
        <?php foreach($products as $product) { ?>
            <li>
                <a class="thumb" title="<?php echo $product['name']; ?>">
                    <img src="<?php echo HTTP_IMAGE; ?>data/preloader.gif" data-original="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="nt-lazyload" />
                </a>
                <div class="product_info nt-hoverdir">
                    <?php echo $product['sticker']; ?>
                    
                    <a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>" class="name"><?php echo $product['name']; ?></a>
                    
                    <?php if ($product['rating']) { ?><img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $product['rating'] . '.png'; ?>" alt="<?php echo $product['stars']; ?>" /><?php } ?>
                    
                    <p class="model"><?php echo $product['model']; ?></p>
                    
                    <p class="overview"><?php echo substr($product['overview'],0,150)." ... "; ?><a href="<?php echo str_replace('&', '&amp;', $product['href']); ?>" title="<?php echo $product['name']; ?>">Leer M&aacute;s</a></p>
                    
                    <div class="description"><?php echo $product['description']; ?></div>
                    
                    <?php if ($display_price) { ?>
                    <?php if (!$product['special']) { ?>
                    <p class="price"><?php echo $product['price']; ?></p>
                    <?php } else { ?>
                    <p class="old_price"><?php echo $product['price']; ?></p> 
                    <p class="special"><?php echo $product['special']; ?></p>
                    <?php } ?>
                    <?php } ?>
                    
                    <a title="<?php echo $button_quick_view; ?>" class="button_quick_view" onclick="window.location.href = '<?php echo str_replace('&', '&amp;', $product['href']); ?>'"><?php echo $Language->get('button_quick_view'); ?></a>
                    <a title="<?php echo $button_see_product; ?>" class="button_see_small" onclick="window.location.href = '<?php echo str_replace('&', '&amp;', $product['href']); ?>'"><?php echo $Language->get('button_see_product'); ?></a>
                    <a title="<?php echo $Language->get('button_add_to_cart'); ?>" class="button_add_small" <?php if (!$this->config->get("cart_ajax") && !$product['option']) { ?>onclick="window.location.href = '<?php echo str_replace('&', '&amp;', $product['add']); ?>'"<?php } else { ?>onclick="addToCart('<?php echo $product['product_id']; ?>')"<?php } ?>><?php echo $Language->get('button_add_to_cart'); ?></a>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
    
    <div class="clear"></div>
    <?php if ($pagination) { ?><div class="pagination"><?php echo $pagination; ?></div><?php } ?>
    <div class="clear"></div><br />
</li>
<?php } ?>