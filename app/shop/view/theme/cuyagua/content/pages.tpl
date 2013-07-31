<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="nt-editable">
    <section id="content" class="nt-editable">
        <div class="grid_16">
            <ul id="breadcrumbs" class="nt-editable">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a title="<?php echo $breadcrumb['text']; ?>" href="<?php echo str_replace('&', '&amp;', $breadcrumb['href']); ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
            </ul>
        </div>
        
        <div class="clear"></div><br /><br />
        
        <div class="grid_16">
            <div id="featuredContent" class="nt-editable">
            <?php if($featuredWidgets) { ?><ul class="widgets"><?php foreach ($featuredWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
            </div>
        </div>
        <div class="clear"></div>
        
        <div class="grid_13">
            <?php if ($page_info) { ?>
            <div id="pagePreview" class="nt-editable">
                <a href="<?php echo $Url::createUrl("content/page",array('page_id'=>$page_info['page_id'])); ?>" title="<?php echo $page_info['title']; ?>"><h1><?php echo $page_info['title']; ?></h1></a>
                <div class="grid_4">
                    <a href="<?php echo $Url::createUrl("content/page",array('page_id'=>$page_info['page_id'])); ?>" title="<?php echo $page_info['title']; ?>">
                        <img src="<?php echo $page_info['image']; ?>" alt="<?php echo $page_info['title']; ?>" />
                    </a>
                </div>
                <div class="grid_8">
                    <?php if (!empty($page_info['meta_description'])) { ?>
                    <p><?php echo strip_tags($page_info['meta_description']); ?></p>
                    <?php } else { echo substr(html_entity_decode($page_info['description'],0,250)) . "..."; } ?>
                </div>
            </div>
            <?php } else { ?>
            <h1><?php echo $heading_title; ?></h1>
            <?php } ?>
            
            <div class="clear"></div>
            
        	<?php if (!$pages) { ?>
            <div class="content"><?php echo $Language->get('text_error'); ?></div>
            <?php } else { ?>
            <div class="content">
                <?php if ($sorts) { ?>
                <div id="sort" class="sort nt-editable">
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

                <div id="page_list" class="list_view nt-editable">
                    <?php foreach($pages as $page) { ?>
                    <article>
                        <div class="grid_12">
                            <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page",array('page_id'=>$page['page_id']))); ?>" style="text-decoration: none !important;">
                                <hgroup><h1><?php echo $page['title']; ?></h1></hgroup>
                            </a>
                                
                            <?php if (!empty($page['meta_description'])) { ?>
                            <p><?php echo strip_tags($page['meta_description']); ?></p>
                            <?php } else { echo substr($page['description'],0,250); } ?>
                            <a href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page",array('page_id'=>$page['page_id']))); ?>"><?php echo $Language->get('text_see_more'); ?></a>
                        </div>
                        <div class="grid_12">
                            <ul class="post-footer">
                                <li class="post-date" title="<?php echo $Language->get('text_created'); ?>" style="padding:0px;"><?php echo $page['date_added']; ?></li>
                                <li class="post-rating" title="<?php echo $Language->get('text_rating'); ?>" style="padding:0px;padding-right: 20px;"><img src="<?php echo HTTP_IMAGE; ?>stars_<?php echo (int)$page['rating'] . '.png'; ?>" alt="<?php echo $page['stars']; ?>" /></li>
                                <li class="post-visits" title="<?php echo $Language->get('text_visits'); ?>"><?php echo (int)$page['visits']; ?></li>
                                <li class="post-follow" title="<?php echo $Language->get('text_followers'); ?>"><?php echo (int)$page['followers']; ?></li>
                                <li class="post-likes" title="<?php echo $Language->get('text_likes'); ?>"><?php echo (int)$page['likes']; ?></li>
                                <li class="post-dislikes" title="<?php echo $Language->get('text_dislikes'); ?>"><?php echo (int)$page['dislikes']; ?></li>
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
            <div class="clear"></div>
            <?php if($widgets) { ?><ul class="widgets"><?php foreach ($widgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?></ul><?php } ?>
            <div class="clear"></div>
            
        </div>
        
        <aside id="column_right" class="nt-editable"><?php echo $column_right; ?></aside>
        
    </section>
    
</section>
<?php echo $footer; ?>