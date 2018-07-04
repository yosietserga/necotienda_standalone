<?php echo $header; ?>

<div class="container">
    <section id="maincontent">
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/page-start.tpl");?>

            <div class="box" id="wrapperLi">
                <ul id="sitemap">
                    <li>
                        <a title="<?php echo $Language->get('text_account'); ?>" href="<?php echo str_replace('&', '&amp;', $account); ?>"><?php echo $Language->get('text_account'); ?></a>
                        <span>
                            <p><a title="<?php echo $Language->get('text_edit'); ?>" href="<?php echo str_replace('&', '&amp;', $edit); ?>"><?php echo $Language->get('text_edit'); ?></a></p>
                            <p><a title="<?php echo $Language->get('text_password'); ?>" href="<?php echo str_replace('&', '&amp;', $password); ?>"><?php echo $Language->get('text_password'); ?></a></p>
                            <p><a title="<?php echo $Language->get('text_address'); ?>" href="<?php echo str_replace('&', '&amp;', $address); ?>"><?php echo $Language->get('text_address'); ?></a></p>
                            <p><a title="<?php echo $Language->get('text_history'); ?>" href="<?php echo str_replace('&', '&amp;', $history); ?>"><?php echo $Language->get('text_history'); ?></a></p>
                            <p><a title="<?php echo $Language->get('text_download'); ?>" href="<?php echo str_replace('&', '&amp;', $download); ?>"><?php echo $Language->get('text_download'); ?></a></p>
                        </span>
                    </li>
                    
                    <li><a title="<?php echo $Language->get('text_special'); ?>" href="<?php echo str_replace('&', '&amp;', $special); ?>"><?php echo $Language->get('text_special'); ?></a></li>
                    <li><a title="<?php echo $Language->get('text_cart'); ?>" href="<?php echo str_replace('&', '&amp;', $cart); ?>"><?php echo $Language->get('text_cart'); ?></a></li>
                    <li><a title="<?php echo $Language->get('text_checkout'); ?>" href="<?php echo str_replace('&', '&amp;', $checkout); ?>"><?php echo $Language->get('text_checkout'); ?></a></li>
                    <li><a title="<?php echo $Language->get('text_search'); ?>" href="<?php echo str_replace('&', '&amp;', $search); ?>"><?php echo $Language->get('text_search'); ?></a></li>
                    <li><a title="<?php echo $Language->get('text_contact'); ?>" href="<?php echo str_replace('&', '&amp;', $contact); ?>"><?php echo $Language->get('text_contact'); ?></a></li>
                    <li>
                        <a title="<?php echo $Language->get('text_post_categories'); ?>" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/category")); ?>"><?php echo $Language->get('text_post_categories'); ?></a>
                        <span>
                            <?php foreach ($post_categories as $result) { ?><p><a title="<?php echo $result['title']; ?>" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/category",array('category_id'=>$result['category_id']))); ?>"><?php echo $result['title']; ?></a></p><?php } ?>
                        </span>
                    </li>
                    
                    <li>
                        <a title="<?php echo $Language->get('text_pages'); ?>" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page/all")); ?>"><?php echo $Language->get('text_pages'); ?></a>
                        <span>
                            <?php foreach ($pages as $result) { ?><p><a title="<?php echo $result['title']; ?>" href="<?php echo str_replace('&', '&amp;', $Url::createUrl("content/page",array('page_id'=>$result['post_id']))); ?>"><?php echo $result['title']; ?></a></p><?php } ?>
                        </span>
                    </li>
                    
                </ul>
            </div>
            
        <!-- widgets -->
        <div class="large-12 medium-12 small-12 columns">
            <?php $position = 'main'; ?>
            <?php foreach($rows[$position] as $j => $row) { ?>
            <?php if (!$row['key']) continue; ?>
            <?php $row_id = $row['key']; ?>
            <?php $row_settings = unserialize($row['value']); ?>
            <div class="row" id="<?php echo $position; ?>_<?php echo $row_id; ?>" nt-editable>
                <?php foreach($row['columns'] as $k => $column) { ?>
                <?php if (!$column['key']) continue; ?>
                <?php $column_id = $column['key']; ?>
                <?php $column_settings = unserialize($column['value']); ?>
                <div class="large-<?php echo $column_settings['grid_large']; ?> medium-<?php echo $column_settings['grid_medium']; ?> small-<?php echo $column_settings['grid_small']; ?>" id="<?php echo $position; ?>_<?php echo $column_id; ?>" nt-editable>
                    <ul class="widgets">
                        <?php foreach($column['widgets'] as $l => $widget) { ?> {%<?php echo $widget['name']; ?>%} <?php } ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <!-- widgets -->

            <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>
    </section>
</div>
<script>
$(function(){
    $('#sitemap li').wookmark({
        autoResize: true,
        container: $('#wrapperLi'),
        offset: 2,
        itemWidth: 200
      });
});
</script>
<?php echo $footer; ?>