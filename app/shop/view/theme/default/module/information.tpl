<li class="box informationModule">
    <div class="header"><hgroup><h1><?php echo $heading_title; ?></h1></hgroup></div>
    <div class="content">
        <ul>
            <?php foreach ($informations as $information) { ?>
            <li><a title="<?php echo $information['title']; ?>" href="<?php echo str_replace('&', '&amp;', $information['href']); ?>"><?php echo $information['title']; ?></a></li>
            <?php } ?>
            <li><a title="<?php echo $text_contact; ?>" href="<?php echo str_replace('&', '&amp;', $contact); ?>"><?php echo $text_contact; ?></a></li>
            <li><a title="<?php echo $text_sitemap; ?>" href="<?php echo str_replace('&', '&amp;', $sitemap); ?>"><?php echo $text_sitemap; ?></a></li>
        </ul>
    </div>
</li>