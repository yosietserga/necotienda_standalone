<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="row">

        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-start.tpl"); ?>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/message.tpl"); ?>
            <div class="message-info">
                <h2><?php echo $message['subject']; ?></h2>

                <p >Enviado por: <?php echo $message['company']; ?><?php echo $message['created']; ?></p>
                <p ><?php echo $message['message']; ?></p>

                <p>
                    <a href="#" class="button" onclick="$('#messageForm').slideToggle();return false;">Responder al mensaje</a>
                    <a href="<?php echo $Url::createUrl("account/message",array("message_id"=>$message['message_id'])); ?>" class="button">Volver</a>
                </p>
            </div>

            <div class="simple-form">
                <form action="<?php echo $action; ?>" method="post" id="messageForm" style="display:none">
                    <input type="hidden" name="message_id" value="<?php echo $message['message_id']; ?>" />
                    <input type="hidden" name="subject" value="RE: <?php echo $message['subject']; ?>" />
                    <input type="hidden" name="to" value="<?php echo $message['customer_id']; ?>;" />
                    <table>
                        <tr>
                            <td>
                                <textarea id="message" name="message" showquick="off" required="required"></textarea>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        <?php include(DIR_TEMPLATE. $this->config->get('config_template') ."/shared/columns-end.tpl"); ?>


</section>
<?php echo $footer; ?>