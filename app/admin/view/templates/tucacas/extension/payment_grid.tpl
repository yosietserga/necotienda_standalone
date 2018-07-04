<div class="pagination"><?php echo $pagination; ?></div>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
    <table id="list">
        <thead>
            <tr>
                <th><?php echo $Language->get('column_name'); ?></th>
                <th></th>
                <th><?php echo $Language->get('column_status'); ?></th>
                <th><?php echo $Language->get('column_sort_order'); ?></th>
                <th><?php echo $Language->get('column_action'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if ($extensions) { ?>
            <?php foreach ($extensions as $extension) { ?>
            <tr id="tr_<?php echo $extension['extension']; ?>-<?php echo $extension['pos']; ?>">
                <td><?php echo $extension['name']; ?></td>
                <td><?php echo $extension['link'] ?></td>
                <td><?php echo $extension['status'] ?></td>
                <td class="move"><img src="image/move.png" alt="Posicionar" title="Posicionar" style="text-align:center" /></td>
                <td>
                <?php foreach ($extension['action'] as $action) { ?>
                <?php 
                    if ($action['action'] == "install") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                        $img_id = "img_install_" . $customer['customer_id'];
                    } elseif ($action['action'] == "activate") {
                        $jsfunction = "activate(". $customer['customer_id'] .")";
                        $href = $action['href'];
                        $img_id = "img_activate_" . $customer['customer_id'];
                    } elseif ($action['action'] == "edit") {
                        $href = "href='" . $action['href'] ."'";
                        $jsfunction = "";
                        $img_id = "img_edit_" . $customer['customer_id'];
                    }   
                ?>
                <a title="<?php echo $action['text']; ?>" <?php echo $href; ?> onclick="<?php echo $jsfunction; ?>"><img id="img_<?php echo $extension['extension_id']; ?>" src="image/<?php echo $action['img']; ?>" alt="<?php echo $action['text']; ?>" /></a>
                <?php } ?>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="8" style="text-align:center"><?php echo $Language->get('text_no_results'); ?></td></tr>
        <?php } ?>
        </tbody>
    </table>
</form>
<div class="pagination"><?php echo $pagination; ?></div>