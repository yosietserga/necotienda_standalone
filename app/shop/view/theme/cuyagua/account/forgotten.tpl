<?php echo $header; ?>
<?php echo $navigation; ?>
<link rel="stylesheet" href="<?php echo HTTP_CSS; ?>neco.form.css" media="screen" />
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
        
            <h1><?php echo $heading_title; ?></h1>
            <?php if ($success) { ?><div class="success"><?php echo $success; ?></div><?php } ?>
            <?php if ($error) { ?><div class="warning"><?php echo $error; ?></div><?php } ?>
              
            <div class="clear"></div>
            <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="forgotten" class="nt-editable">
                <p><?php echo $text_email; ?></p>
                <b style="margin-bottom: 2px; display: block;"><?php echo $text_your_email; ?></b>
                
                <div class="property">
                    <label><?php echo $Language->get('entry_email'); ?></label>
                    <input type="email" name="email" id="email" placeholder="Email" />
                </div>
                
                <div class="clear"></div>
            </form>

        </div>
        <aside id="column_right" class="nt-editable"><?php echo $column_right; ?></aside>
    </section>
</section>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>vendor/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS; ?>necojs/neco.form.js"></script>
<script type="text/javascript">
$(function(){
    $('#forgotten').ntForm();
});
</script>
<?php echo $footer; ?>