<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/breadcumbs.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/featured-widgets.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
    <?php if ($page_info) { ?>

    <div id="pagePreview" class="row">
        <a href="<?php echo $Url::createUrl("content/page",array('page_id'=>$page_info['page_id'])); ?>" title="<?php echo $page_info['title']; ?>"><h1><?php echo $page_info['title']; ?></h1></a>
        <div class="large-4 medium-4 small-12 columns">
            <a href="<?php echo $Url::createUrl("content/page",array('page_id'=>$page_info['page_id'])); ?>" title="<?php echo $page_info['title']; ?>">
                <img src="<?php echo $page_info['image']; ?>" alt="<?php echo $page_info['title']; ?>" />
            </a>
        </div>
        <div class="large-8 medium-8 small-12 columns">
            <?php if (!empty($page_info['meta_description'])) { ?>
            <p><?php echo strip_tags($page_info['meta_description']); ?></p>
            <?php } else { echo substr(html_entity_decode($page_info['description']),0,250) . "..."; } ?>
        </div>
    </div>
    <?php } else { ?>
    <h1><?php echo $heading_title; ?></h1>
    <?php } ?>


    <?php if (!$pages) { ?>
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
            <?php foreach($pages as $page) { ?>
                <li class="glossary-item">

                    <article class="row">
                        <div class="glossary-item-head large-3 medium-3 small-3 columns">

                            <div class="post-date" title="<?php echo $Language->get('text_created'); ?>">
                                <span><?php echo $Language->get('text_created'); ?></span>
                                <small><?php echo $page['date_added']; ?></small>
                            </div>
                            <div class="post-rating" title="<?php echo $Language->get('text_rating'); ?>">
                                <span><?php echo $Language->get('text_rating'); ?></span>
                                <img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo (int)$page['rating'] . '.png'; ?>" alt="<?php echo $page['stars']; ?>" />
                            </div>
                        </div>

                        <div class="glossary-item-body large-9 medium-9 small-12 columns">
                            <a class="name" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page",array('page_id'=>$page['page_id']))); ?>">
                                <h3><?php echo $page['title']; ?></h3>
                            </a>
                            <?php if (!empty($page['meta_description'])) { ?>
                                <p class="overview"><?php echo strip_tags($page['meta_description']) . "... "; ?>&nbsp;
                                    <a class="read-more" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page",array('page_id'=>$page['page_id']))); ?>">
                                        <?php echo $Language->get('text_see_more'); ?>
                                    </a>
                                </p>
                            <?php } else { ?>
                                <p class="overview"><?php echo substr($page['description'],0,250) . "... "; ?>&nbsp;
                                    <a class="read-more" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page",array('page_id'=>$page['page_id']))); ?>">
                                        <?php echo $Language->get('text_see_more'); ?>
                                    </a>
                                </p>
                            <?php } ?>
                            <ul class="glossary-item-footer inline-list">
                                <li class="post-visits" title="<?php echo $Language->get('text_visits'); ?>"><?php echo (int)$page['visits']; ?></li>
                                <li class="post-follow" title="<?php echo $Language->get('text_followers'); ?>"><?php echo (int)$page['followers']; ?></li>
                                <li class="post-likes" title="<?php echo $Language->get('text_likes'); ?>"><?php echo (int)$page['likes']; ?></li>
                                <li class="post-dislikes" title="<?php echo $Language->get('text_dislikes'); ?>"><?php echo (int)$page['dislikes']; ?></li>
                            </ul>
                        </div>

                    </article>
                </li>
                <?php } ?>
            </ul>
        </div>
        <?php if ($pagination) { ?>
            <div class="pagination"><?php echo $pagination; ?></div>
        <?php } ?>
    <?php } ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.end"); ?>
</section>
<?php echo $footer; ?>