<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent">
    <section id="content">
        <div class="grid_16">
            <h1><?php echo $heading_title; ?></h1>
            <?php if ($description) { ?>
            <p><?php echo $description; ?></p>
            <?php } ?>
        	<?php if (!$categories && !$products) { ?>
            <div class="content"><?php echo $text_error; ?></div>
            <?php } ?>
    
            <?php if($categories) { ?>
            <nav class="content">
                <div class="category_view">
                <?php foreach($categories as $category) { ?>
                    <div class="product_preview">
                        <a class="thumb" href="<?php echo str_replace('&', '&amp;', $category['href']); ?>" title="<?php echo $category['name']; ?>"><img src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['name']; ?>" /></a>
                        <a class="name" href="<?php echo str_replace('&', '&amp;', $category['href']); ?>" title="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a>
                        
                    </div>
                <?php } ?>
                </div>
            </nav>
            <?php } ?>
    
            <div class="clear"></div>
            <section id="products"><img src='<?php echo HTTP_IMAGE; ?>nt_loader.gif' alt='Cargando...' /></section>
        </div>
    </section>
</section>
<?php echo $footer; ?> 