<?php if($posts) { ?>
<!-- post-list -->
<li class="nt-editable widget-post-list-<?php echo $settings['func']; ?> widget-post-list-<?php echo $settings['view']; ?> widget-post-list postListWidget<?php echo ($settings['class']) ? ' ' .$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">


    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl"); ?>

    <!-- post-list-content -->
    <div class="widget-content post-list-content" id="<?php echo $widgetName; ?>Content">
        <?php foreach ($posts as $post) { ?>
        <div class="article row">
            <figure class="picture large-5 medium-3 small-3 columns">
                <a title="<?php echo $post['name']; ?>" href="<?php echo str_replace('&', '&amp;', $post['href']); ?>" class="thumb">
                    <img src="<?php echo $post['thumb']; ?>" alt="<?php echo $post['name']; ?>" />
                </a>
            </figure>

            <div class="info large-7 medium-9 small-9 columns">
                <a class="name" title="<?php echo $post['name']; ?>" href="<?php echo str_replace('&', '&amp;', $post['href']); ?>">
                    <?php echo $post['name']; ?>
                </a>

                <p class="overview overview hide-for-small-only hide-for-large-up">
                    <?php echo substr($post['overview'],0,80)." ... "; ?>
                    <a href="<?php echo str_replace('&', '&amp;', $post['href']); ?>" title="<?php echo $post['name']; ?>">Leer M&aacute;s</a>
                </p>

                <?php if ($post['rating']) { ?>
                <div class="rating">
                    <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo $post['rating'] . '.png'; ?>" alt="<?php echo $post['stars']; ?>" />
                </div>
                <?php }else { ?>
                <div class="rating" style="min-height: 1.063em; width: 100%;"></div>
                <?php }?>
            </div>
        </div>
        <?php } ?>
    </div>
    <!-- /post-list-content -->
</li>
<!-- /post-list -->
<?php } ?>
