<?php if ($this->document->breadcrumbs) { ?>
<ol class="breadcrumb">
    <?php foreach ($this->document->breadcrumbs as $k => $breadcrumb) { ?>
    <li<?php if ((count($this->document->breadcrumbs) - 1) === $k) { echo ' class="active"'; } ?>>
        <?php if ((count($this->document->breadcrumbs) - 1) !== $k) { ?>
        <a href="<?php echo $breadcrumb['href']; ?>">
        <?php } else { ?>
        <strong>
        <?php } ?>

            <?php echo $breadcrumb['text']; ?>

        <?php if ((count($this->document->breadcrumbs) - 1) !== $k) { ?>
        </a>
        <?php } else { ?>
        </strong>
        <?php } ?>
    </li>
    <?php } ?>
</ol>
<?php } ?>