<?php if($featuredWidgets && count($featuredWidgets) !== 0) { ?>
<aside class="column home-grid-full">
    <section id="featuredContent" class="widgets featured">
        <ul>
            <?php foreach ($featuredWidgets as $widget) { ?>
                {%<?php echo $widget; ?>%}
            <?php }  ?>
        </ul>
    </section>
</aside>
<?php }  ?>