<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    
    <?php if ($breadcrumbs) { ?>
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <?php } ?>
    
    <?php if ($success) { ?><div class="grid_12"><div class="message success"><?php echo $success; ?></div></div><?php } ?>
    <?php if ($msg || $error_warning) { ?><div class="grid_12"><div class="message warning"><?php echo ($msg) ? $msg : $error_warning; ?></div></div><?php } ?>
    <?php if ($error) { ?><div class="grid_12"><div class="message error"><?php echo $error; ?></div></div><?php } ?>
    <div class="grid_12" id="msg"></div>
    
    <div class="box">
        <h1><?php echo $Language->get('heading_title'); ?></h1>
        <div class="clear"></div>

        <ul>
            <?php foreach ($product_types as $type) { ?>
            <li dataproduct--type="<?php echo $type['type']; ?>">
                <img src="<?php echo HTTP_ADMIN_IMAGE . $type['icon']; ?>" />
                <?php echo $type['name']; ?>
            </li>
            <?php } ?>
        </ul>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

        </form>
    </div>
</div>
<script>
$(function() {
    $('[data-product-type]').each(function(){
        $('#form').load(createAdminUrl('store/product/insertWizard', {
            step:'relations',
            type:$(this).data('product-type'),
            product_id:'<?php echo $product_id; ?>'
        }));
    });
});
</script>
<?php echo $footer; ?>