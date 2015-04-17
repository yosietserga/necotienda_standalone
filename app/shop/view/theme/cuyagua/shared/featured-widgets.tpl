<div class="large-12 medium-12 small-12 columns">
    <div id="featuredContent">
        <ul class="widgets"><?php if($featuredWidgets) { foreach ($featuredWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } } ?></ul>
    </div>
</div>