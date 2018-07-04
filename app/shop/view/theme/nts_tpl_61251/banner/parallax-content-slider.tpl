<li id="<?php echo $widgetName; ?>" class="banner<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?> nt-editableb"> 

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 

    <?php if (count($banner['items'])) { ?>
        <div class="widget-content" id="<?php echo $widgetName; ?>Content">
        
			<div id="<?php echo $widgetName; ?>slider" class="da-slider">
            <?php foreach ($banner['items'] as $item) { ?>
            
				<div class="da-slide">
					<?php if (!empty($item['title'])) { ?><h2><?php echo $item['title']; ?></h2><?php } ?>
					<?php if (!empty($item['description'])) { ?><p><?php echo $item['description']; ?></p><?php } ?>
					<?php if (!empty($item['link'])) { ?><a href="<?php echo $item['link']; ?>" class="da-link"><?php echo $Language->get('Read More'); ?></a><?php } ?>
                    
					<?php if (!empty($item['image'])) { ?><div class="da-img"><img src="<?php echo $Image->resizeAndSave($item['image'],275,275); ?>" alt="<?php echo $item['title']; ?>"/></div><?php } ?>
				</div>
                
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</li>

<script>
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:"<?php echo $widgetname; ?>slider",
            config:{
    			autoplay	: true
            },
            plugin:'cslider'
        });
        window.ntPlugins = ntPlugins;
    });
</script>
