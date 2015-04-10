<!--BREADCRUMBS-->
<?php if (!empty($breadcrumbs) && $breadcrumbs !== null) { ?>
    <nav class="large-12 small-12 medium-12 columns">
        <ul id="breadcrumbs" class="breadcrumbs nt-editable">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <li>
                 <a title="<?php echo $breadcrumb['text']; ?>" href="<?php echo str_replace('&', '&amp;', $breadcrumb['href']); ?>">
                     <?php echo $breadcrumb['text']; ?>
                 </a>
            </li>
        <?php } ?>
        </ul>
    </nav>
<?php } ?>

<!--/BREADCRUMBS-->