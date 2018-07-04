    </div>
</aside>
<!--/COLUMN-CENTER-->
<!--COLUMN-RIGHT-->
<?php if ($column_right) { ?>
    <aside id="column_right" class="column-right large-3 column">
        <div class="widgets aside-column">
            <?php echo $column_right; ?>
        </div>
    </aside>
<?php } ?>
</section>

<?php if($featuredFooterWidgets) { ?>
<ul id="featuredFooter" class="columns-widgets widgets">
<?php foreach ($featuredFooterWidgets as $widget) { ?>{%<?php echo $widget; ?>%}<?php } ?>
</ul>
<?php } ?>
<!--/COLUMN-RIGHT-->
