<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?> 
    <?php if ($page_info) { ?> 
    <div id="pagePreview" class="row">
        <a class="column" href="<?php echo $Url::createUrl("content/page",array('page_id'=>$page_info['page_id'])); ?>" title="<?php echo $page_info['title']; ?>">
           <h1><?php echo $page_info['title']; ?></h1>
        </a>
        <div class="large-4 column">
            <a href="<?php echo $Url::createUrl("content/page",array('page_id'=>$page_info['page_id'])); ?>" title="<?php echo $page_info['title']; ?>">
                <img src="<?php echo $page_info['image']; ?>" alt="<?php echo $page_info['title']; ?>" />
            </a>
        </div> 
        <div class="large-8 column">
            <?php if (!empty($page_info['meta_description'])) { ?>
                <p><?php echo strip_tags($page_info['meta_description']); ?></p>
            <?php } else { echo substr(html_entity_decode($page_info['description']), 0, 250) . "..."; } ?>
        </div>
    </div>
    <?php }?>
    
    <?php if (!$posts) { ?>
    <div><?php echo $Language->get('text_error'); ?></div>
    <?php } else { ?>
        <?php if ($sorts) { ?>
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
        </div>
        <?php } ?>
        <?php if ($pagination) { ?>
            <div class="pagination"><?php echo $pagination; ?></div>
        <?php } ?>
        <div class="glossary glossary-list break">
            <ul>
            <?php foreach($posts as $post) { ?>
                <li class="glossary-item">
                    <article class="row">
                        <div class="glossary-item-body large-12 medium-12 column">
                            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/post-picture.tpl"); ?>
                            <a class="name" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/post",array('post_id'=>$post['post_id']))); ?>">
                                <h3><?php echo $post['title']; ?></h3>
                            </a>
                            <div class="post-rating" title="<?php echo $Language->get('text_rating'); ?>">
                                <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo (int)$post['rating'] . '.png'; ?>" alt="<?php echo $post['stars']; ?>" />
                            </div>
                            <?php if (!empty($post['meta_description'])) { ?>
                                <p class="overview"><?php echo $post['meta_description']; ?>
                                    <span><?php echo $post['date_rating'];?></span>
                                    <a class="read-more" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/post",array('post_id'=>$post['post_id']))); ?>">
                                        <?php echo $Language->get('text_see_more'); ?>
                                    </a>
                                </p>
                            <?php } ?>
                        </div>
                    </article>
                </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
    
    <!-- widgets -->
    <div class="large-12 medium-12 small-12 columns">
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
    </div>
    <!-- widgets -->

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>

</section>
<?php echo $footer; ?>