<!-- catalog-latest -->
<?php if($tabs) { ?>
<li nt-editable="1" class="widget-product-list-<?php echo $settings['func']; ?> widget-product-list-<?php echo $settings['view']; ?> widget-product-list-home productListWidget<?php echo ($settings['class']) ? ' ' .$settings['class'] : ''; ?>" id="<?php echo $widgetName; ?>">

    <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/module-heading.tpl");?>

    <div class="product-tabs large-12 medium-12 small-12 columns" id="<?php echo 'tabs_wrapper_'. $k .'_'. $widgetName; ?>" nt-editable>
        <ul class="tabs" id="<?php echo 'tabs_'. $k .'_'. $widgetName; ?>" nt-editable>
            <?php foreach($tabs as $k => $tab) { ?>
            <li class="tab" id="<?php echo 'tab_'. $k .'_'. $widgetName; ?>">
                <span class="tab-item"><?php echo $tab['name']; ?></span>
            </li>
            <?php } ?>
        </ul>

        <?php include("product_tabs_home_". $tab['view'] .".tpl"); ?>

    </div>
</li>

<script data-script="tabs">
    (function () {
        window.deferjQuery(function () {
            var $tabs = $('.tab');
            $tabs.each(function(){
                $(this).removeClass('active');
                $('#_' + this.id).hide();
            });
            $tabs.on('click',function() {
                $tabs.each(function(){
                    $(this).removeClass('active');
                    $('#_' + this.id).hide();
                });
                $(this).addClass('active');
                $('#_' + this.id).show();
            });

            $("#<?php echo 'tab_0_'. $widgetName; ?>").addClass('active');
            $('#_<?php echo 'tab_0_'. $widgetName; ?>').show();
        });
    })();
</script>

<?php } ?>
