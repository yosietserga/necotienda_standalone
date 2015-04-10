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
                <?php } else { echo substr(html_entity_decode($page_info['description'],0,250)) . "..."; } ?>
            </div>
        </div>
        <?php } else { ?>
        <h1><?php echo $heading_title; ?></h1>
        <?php } ?>

        <?php if (!$posts) { ?>
        <div class="content"><?php echo $Language->get('text_error'); ?></div>
        <?php } else { ?>
        <div class="content">
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

            <div class="list_view">
                <?php foreach($posts as $post) { ?>
                <article>
                    <div>
                        <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/post",array('post_id'=>$post['post_id']))); ?>" >
                            <h1><?php echo $post['title']; ?></h1>
                        </a>

                        <?php if (!empty($post['meta_description'])) { ?>
                        <p><?php echo strip_tags($post['meta_description']); ?></p>
                        <?php } else { echo substr($post['description'],0,250); } ?>
                        <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/post",array('post_id'=>$post['post_id']))); ?>"><?php echo $Language->get('text_see_more'); ?></a>
                    </div>
                    <div>
                        <ul class="post-footer">
                            <li class="post-date" title="<?php echo $Language->get('text_created'); ?>" style="padding:0px;"><?php echo $post['date_added']; ?></li>
                            <li class="post-rating" title="<?php echo $Language->get('text_rating'); ?>" style="padding:0px;padding-right: 20px;"><img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo (int)$post['rating'] . '.png'; ?>" alt="<?php echo $post['stars']; ?>" /></li>
                            <li class="post-visits" title="<?php echo $Language->get('text_visits'); ?>"><?php echo (int)$post['visits']; ?></li>
                            <li class="post-follow" title="<?php echo $Language->get('text_followers'); ?>"><?php echo (int)$post['followers']; ?></li>
                            <li class="post-likes" title="<?php echo $Language->get('text_likes'); ?>"><?php echo (int)$post['likes']; ?></li>
                            <li class="post-dislikes" title="<?php echo $Language->get('text_dislikes'); ?>"><?php echo (int)$post['dislikes']; ?></li>
                        </ul>
                    </div>
                </article>
                <?php } ?>
                <?php if ($pagination) { ?>
                <div class="pagination"><?php echo $pagination; ?></div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>

</section>
<?php echo $footer; ?>