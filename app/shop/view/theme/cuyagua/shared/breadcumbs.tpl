<!--BREADCRUMBS-->
<?php if  (!empty($breadcrumbs) && $breadcrumbs !== null) { ?>
    <nav class="columns" style="height: 0;">
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