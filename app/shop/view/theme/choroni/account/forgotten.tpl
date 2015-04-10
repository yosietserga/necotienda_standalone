<?php echo $header; ?>
<?php echo $navigation; ?>
<div class="container">
    <section id="maincontent">
        <section id="content">
        <div class="grid_12 hideOnMobile">
            <ul id="breadcrumbs" class="nt-editable">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li><a title="<?php echo $breadcrumb['text']; ?>" href="<?php echo str_replace('&', '&amp;', $breadcrumb['href']); ?>"><?php echo $breadcrumb['text']; ?></a></li>
            <?php } ?>
            </ul>
        </div>
        
        <div class="clear"></div><br /><br />
        
        <?php if ($column_left) { ?><aside id="column_left" class="grid_3"><?php echo $column_left; ?></aside><?php } ?>
        
        <?php if ($column_left && $column_right) { ?>
        <div class="grid_6">
        <?php } elseif ($column_left || $column_right) { ?>
        <div class="grid_9">
        <?php } else { ?>
        <div class="grid_12">
        <?php } ?>
            
            <h1><?php echo $heading_title; ?></h1>
            <?php if ($success) { ?><div class="success"><?php echo $success; ?></div><?php } ?>
            <?php if ($error) { ?><div class="warning"><?php echo $error; ?></div><?php } ?>
            
            <div class="clear"></div>
		
                <form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" enctype="multipart/form-data" id="forgotten">
                    <p><?php echo $Language->get('text_email'); ?></p>
                    <b style="margin-bottom: 2px; display: block;"><?php echo $Language->get('text_your_email'); ?></b>
                    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
                        <table>
                            <tr>
                                <td class="tdW150"><?php echo $entry_email; ?></td>
                                <td><input type="text" name="email"></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="buttons">
                        <a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><?php echo $Language->get('button_back'); ?></a>
                        <a onclick="$('#forgotten').submit();" class="button"><?php echo $Language->get('button_continue'); ?></a>
                    </div>
                </form>
            </div>

            <?php if ($column_right) { ?><aside id="column_right" class="grid_3"><?php echo $column_right; ?></aside><?php } ?>

            <div class="clear"></div>

            <div class="grid_12">
                <div id="featuredFooter">
                <ul class="widgets" data-position="featuredFooter"><?php if($featuredFooterWidgets) { foreach ($featuredFooterWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } } ?></ul>
                </div>
            </div>

        </section>
    </section>
</div>
<?php echo $footer; ?>