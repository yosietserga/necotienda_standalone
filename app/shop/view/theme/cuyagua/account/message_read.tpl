<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/message.tpl"); ?>
            <div class="message-info">
                <h2><?php echo $message['subject']; ?></h2>

                <p ><?php echo $Language->get('text_sent_by');?><?php echo $message['company']; ?><?php echo $message['created']; ?></p>
                <p ><?php echo $message['message']; ?></p>

                <div class="actions">
                    <div class="action-button button-filter">
                        <a href="#" onclick="$('#messageForm').slideToggle();return false;"><?php echo $Language->get('text_reply');?></a>
                    </div>
                    <div class="action-button button-update">
                        <a href="<?php echo $Url::createUrl("account/message",array("message_id"=>$message['message_id'])); ?>"><?php echo $Language->get('text_return');?></a>
                    </div>
                </div>
            </div>

            <div class="simple-form">
                <form action="<?php echo $action; ?>" method="post" id="messageForm" style="display:none">
                    <div class="form-entry">
                        <input type="hidden" name="message_id" value="<?php echo $message['message_id']; ?>" />
                    </div>
                    <div class="form-entry">
                        <input type="hidden" name="subject" value="RE: <?php echo $message['subject']; ?>" />
                    </div>
                    <div class="form-entry">
                        <input type="hidden" name="to" value="<?php echo $message['customer_id']; ?>;" />
                    </div>
                    <div class="form-entry">
                                <textarea id="message" name="message" showquick="off" required="required"></textarea>
                    </div>
                </form>
            </div>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>


</section>
<?php echo $footer; ?>