<!-- catalog-latest -->
<?php if($products) { ?>
<li nt-editable="1" class="widget-product-list widget-product-list-grid productListWidget<?php echo ($settings['class']) ? ' ' .$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>
    <ul>
<?php foreach($products as $product) { ?>
<li class="catalog-item">
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-picture.tpl"); ?>
    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/catalog-info.tpl"); ?>
</li>
<?php } ?>
    </ul>
</li>
<!-- /catalog -->
<?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/scripts/quickview-deps.tpl"); ?>


<script type="text/javascript">
    $(function(){
        ntPlugins = window.ntPlugins || [];

        ntPlugins.push({
            id:'#<?php echo $widgetName . $k; ?> .catalog-item .scrollImg',
            config:{
                lazyLoad:'ondemand',
                vertical:true,
                rows:3,
                nextArrow:'<span class="arrow arrow-down arrow-2x"></span>',
                prevArrow:'<span class="arrow arrow-up arrow-2x"></span>'
            },
            plugin:'slick'
        });

        window.ntPlugins = ntPlugins;

        $('#<?php echo $widgetName . $k; ?> .thumbs img').on('click', function(e){
            var p = $(this).closest('.picture');
            p.find('.items img').attr('src', $(this).data('preview'));
        });
    });
</script>
<?php } ?>
