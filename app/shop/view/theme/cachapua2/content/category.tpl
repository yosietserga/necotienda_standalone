<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <?php if ($page_info) { ?>
    <div id="pagePreview" class="row">
        <a class="large-12 medium-12 small-12 columns" href="<?php echo $Url::createUrl("content/page",array('page_id'=>$page_info['page_id'])); ?>" title="<?php echo $page_info['title']; ?>"><h1><?php echo $page_info['title']; ?></h1></a>
        <div class="large-4 medium-12 small-12 columns">
            <a href="<?php echo $Url::createUrl("content/page",array('page_id'=>$page_info['page_id'])); ?>" title="<?php echo $page_info['title']; ?>">
                <img src="<?php echo $page_info['image']; ?>" alt="<?php echo $page_info['title']; ?>" />
            </a>
        </div>
        <div class="large-8 medium-12 small-12 columns">
            <?php if (!empty($page_info['meta_description'])) { ?>
                <p><?php echo strip_tags($page_info['meta_description']); ?></p>
            <?php } else { echo substr(html_entity_decode($page_info['description']), 0, 250) . "..."; } ?>
        </div>
    </div>
    <?php } else { ?>
    <h1><?php echo $heading_title; ?></h1>
    <?php } ?>

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
                <article>
                    <div class="glossary-item-body">
                        <a class="name" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/post",array('post_id'=>$post['post_id']))); ?>">
                            <h3><?php echo $post['title']; ?></h3>
                        </a>
                        <?php if (!empty($post['meta_description'])) { ?>
                            <p class="overview"><?php echo strip_tags($post['meta_description']). "... "; ?>
                            </p>
                            <a class="read-more" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/post",array('post_id'=>$post['post_id']))); ?>">
                                    <?php echo $Language->get('text_see_more'); ?>
                            </a>
                        <?php } else { ?>
                            <p class="overview"><?php echo strip_tags(substr($post['description'],0,250)) . "... "; ?></p>
                            <a class="read-more" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/post",array('post_id'=>$post['post_id']))); ?>">
                                <?php echo $Language->get('text_see_more'); ?>
                            </a>
                        <?php } ?>
                    </div>
                    <div class="glossary-item-footer">
                            <ul class="glossary-item-footer-row">
                                <li class="post-date" title="<?php echo $Language->get('text_created'); ?>">
                                    <div>
                                        <?php echo $Language->get('text_created'); ?>
                                        <small><?php echo $post['date_added']; ?></small>
                                    </div>
                                </li>
                                <li class="post-rating" title="<?php echo $Language->get('text_rating'); ?>">
                                    <div>
                                        <i class="fa fa-eye"></i><?php echo $Language->get('text_rating'); ?>
                                        <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo (int)$post['rating'] . '.png'; ?>" alt="<?php echo $post['stars']; ?>" />
                                    </div>
                                </li>
                            </ul>
                            <ul class="glossary-item-footer-row">
                                <li class="post-visits" title="<?php echo $Language->get('text_visits'); ?>">
                                    <div><i class="fa fa-eye"></i><?php echo (int)$post['visits']; ?></div>
                                </li>
                                <li class="post-follow" title="<?php echo $Language->get('text_followers'); ?>">
                                    <div><i class="fa fa-star"></i><?php echo (int)$post['followers']; ?></div>
                                </li>
                                <li class="post-likes" title="<?php echo $Language->get('text_likes'); ?>">
                                   <div><i class="fa fa-thumbs-up"></i><?php echo (int)$post['likes']; ?></div>
                                </li>
                                <li class="post-dislikes" title="<?php echo $Language->get('text_dislikes'); ?>">
                                    <div><i class="fa fa-thumbs-down"></i><?php echo (int)$post['dislikes']; ?></div>
                                </li>
                            </ul>
                        </div>
                </article>
            </li>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>

</section>
<?php echo $footer; ?>