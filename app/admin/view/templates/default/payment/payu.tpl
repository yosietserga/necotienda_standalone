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
        <div class="buttons">
            <a onclick="saveAndExit();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_exit'); ?></a>
            <a onclick="saveAndKeep();$('#form').submit();" class="button"><?php echo $Language->get('button_save_and_keep'); ?></a>
            <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $Language->get('button_cancel'); ?></a>
        </div>

        <div class="clear"></div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <table class="form">
                <tr>
                    <td><span class="required">*</span> <?php echo $Language->get('PayU Api Login'); ?></td>
                    <td><input type="url" name="payu_api_login" value="<?php echo $payu_api_login; ?>" />
                        <?php if ($error_api_login) { ?>
                        <span class="error"><?php echo $error_api_login; ?></span>
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <td><span class="required">*</span> <?php echo $Language->get('PayU Api Key'); ?></td>
                    <td><input type="url" name="payu_api_key" value="<?php echo $payu_api_key; ?>" />
                        <?php if ($error_api_key) { ?>
                        <span class="error"><?php echo $error_api_key; ?></span>
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <td><span class="required">*</span> <?php echo $Language->get('PayU Merchant ID'); ?></td>
                    <td><input type="text" name="payu_merchantid" value="<?php echo $payu_merchantid; ?>" />
                        <?php if ($error_merchantid) { ?>
                        <span class="error"><?php echo $error_merchantid; ?></span>
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <td><span class="required">*</span> <?php echo $Language->get('PayU Account ID'); ?></td>
                    <td><input type="text" name="payu_accountid" value="<?php echo $payu_accountid; ?>" size="40" />
                        <?php if ($error_accountid) { ?>
                        <span class="error"><?php echo $error_accountid; ?></span>
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $Language->get('entry_newsletter'); ?></td>
                    <td>
                        <select name="payu_newsletter_id" title="<?php echo $Language->get('help_newsletter_id'); ?>">
                            <option value="0"><?php echo $Language->get('text_none'); ?></option>
                            <?php foreach ($newsletters as $newsletter) { ?>
                            <option value="<?php echo $newsletter['newsletter_id']; ?>"<?php if ($newsletter['newsletter_id'] == $payu_newsletter_id) { ?> selected="selected"<?php } ?>><?php echo $newsletter['name']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $Language->get('entry_status'); ?></td>
                    <td>
                        <select name="payu_status">
                            <?php if ($payu_status) { ?>
                            <option value="1" selected="selected"><?php echo $Language->get('text_enabled'); ?></option>
                            <option value="0"><?php echo $Language->get('text_disabled'); ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $Language->get('text_enabled'); ?></option>
                            <option value="0" selected="selected"><?php echo $Language->get('text_disabled'); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><?php echo $Language->get('Test Mode?'); ?></td>
                    <td>
                        <select name="payu_test_mode">
                            <?php if ($payu_test_mode) { ?>
                            <option value="1" selected="selected"><?php echo $Language->get('text_enabled'); ?></option>
                            <option value="0"><?php echo $Language->get('text_disabled'); ?></option>
                            <?php } else { ?>
                            <option value="1"><?php echo $Language->get('text_enabled'); ?></option>
                            <option value="0" selected="selected"><?php echo $Language->get('text_disabled'); ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>

                <!--Statuses config -->
                <tr>
                    <td><?php echo $Language->get('entry_cancelled_status'); ?></td>
                    <td><select name="payu_cancelled_status">
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if ($order_status['order_status_id'] == $payu_cancelled_status) { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><?php echo $Language->get('entry_complete_status'); ?></td>
                    <td><select name="payu_complete_status">
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if ($order_status['order_status_id'] == $payu_complete_status) { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><?php echo $Language->get('entry_failed_status'); ?></td>
                    <td><select name="payu_failed_status">
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if ($order_status['order_status_id'] == $payu_failed_status) { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><?php echo $Language->get('entry_new_status'); ?></td>
                    <td><select name="payu_new_status">
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if ($order_status['order_status_id'] == $payu_new_status) { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select></td>
                </tr>

                <tr>
                    <td><?php echo $Language->get('entry_pending_status'); ?></td>
                    <td><select name="payu_pending_status">
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if ($order_status['order_status_id'] == $payu_pending_status) { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><?php echo $Language->get('entry_reject_status'); ?></td>
                    <td><select name="payu_reject_status">
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if ($order_status['order_status_id'] == $payu_reject_status) { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><?php echo $Language->get('entry_returned_status'); ?></td>
                    <td><select name="payu_returned_status">
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if ($order_status['order_status_id'] == $payu_returned_status) { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                    <td><?php echo $Language->get('entry_sent_status'); ?></td>
                    <td><select name="payu_sent_status">
                        <?php foreach ($order_statuses as $order_status) { ?>
                        <?php if ($order_status['order_status_id'] == $payu_sent_status) { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select></td>
                </tr>

                <!-- sort order -->
                <tr>
                    <td><?php echo $Language->get('entry_sort_order'); ?></td>
                    <td><input type="text" name="payu_sort_order" value="<?php echo $payu_sort_order; ?>" size="5" />
                        <?php if ($error_sort_order) { ?>
                        <span class="error"><?php echo $error_sort_order; ?></span>
                        <?php } ?>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php echo $footer; ?>