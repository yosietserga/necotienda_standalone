<li class="nt-editable box pageWidget<?php echo ($settings['class']) ? " ".$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?> 

    <div class="content" id="<?php echo $widgetName; ?>Content">
        <ul>
            <?php foreach ($pages as $page) { ?>
            <li><a title="<?php echo $page['title']; ?>" href="<?php echo str_replace('&', '&amp;', $page['href']); ?>"><?php echo $page['title']; ?></a></li>
            <?php } ?>
            <li><a title="<?php echo $text_contact; ?>" href="<?php echo str_replace('&', '&amp;', $contact); ?>"><?php echo $text_contact; ?></a></li>
            <li><a title="<?php echo $text_sitemap; ?>" href="<?php echo str_replace('&', '&amp;', $sitemap); ?>"><?php echo $text_sitemap; ?></a></li>
        </ul>
    </div>
</li>