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
    
    <div class="grid_12">
        <div class="box">
            <h1><?php echo $Language->get('heading_title'); ?></h1>
            
            <div id="tasksPanel">
                <div class="grid_3">
                    <div class="title">
                        <h2>Contacto</h2>
                        <small>Total Customers: 5 | Total Order: Bs. 544000,00</small>
                    </div>
                    <hr />
                    <ul id="task_step_<?php echo $step['step_id']; ?>" class="tasksWrapper" data-position="<?php echo $step['step_id']; ?>">
                        <li>
                            <div class="grid_12">

                                <img src="http://www.necoshop.com/web/assets/images/data/profiles/avatar.png" title="Yosiet Serga" width="40" />
                                <a href="#">
                                    <h3>
                                        Yosiet Serga
                                        <i class="fa fa-pencil-square fa-1x"></i>
                                    </h3>
                                </a>
                                <small>Inversiones Necoyoad, C.A.</small>
                                <h2>Bs. 53000,00</h2>

                                <div class="clear"></div>

                                <div class="onHold"><?php echo $Language->get('On Hold'); ?></div>
                            </div>
                        </li>
                        <li>
                            <div class="grid_12">

                                <img src="http://www.necoshop.com/web/assets/images/data/profiles/avatar.png" title="Yosiet Serga" width="40" />
                                <a href="#">
                                    <h3>
                                        Yosiet Serga
                                        <i class="fa fa-pencil-square fa-1x"></i>
                                    </h3>
                                </a>
                                <small>Inversiones Necoyoad, C.A.</small>
                                <h2>Bs. 53000,00</h2>

                                <div class="clear"></div>

                                <div class="overdue"><?php echo $Language->get('Overdue'); ?></div>
                            </div>
                        </li>
                        <li>
                            <div class="grid_12">

                                <img src="http://www.necoshop.com/web/assets/images/data/profiles/avatar.png" title="Yosiet Serga" width="40" />
                                <a href="#">
                                    <h3>
                                        Yosiet Serga
                                        <i class="fa fa-pencil-square fa-1x"></i>
                                    </h3>
                                </a>
                                <small>Inversiones Necoyoad, C.A.</small>
                                <h2>Bs. 53000,00</h2>

                                <div class="clear"></div>

                                <div class="rejected"><?php echo $Language->get('Rejected'); ?></div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="grid_3">
                    <div class="title">
                        <h2>Oportunidades</h2>
                        <small>Total Customers: 5 | Total Order: Bs. 544000,00</small>
                    </div>
                    <hr />
                    <ul id="task_step_1<?php echo $step['step_id']; ?>" class="tasksWrapper" data-position="3<?php echo $step['step_id']; ?>">
                        <li>
                            <div class="grid_12">

                                <img src="http://www.necoshop.com/web/assets/images/data/profiles/avatar.png" title="Yosiet Serga" width="40" />
                                <a href="#">
                                    <h3>
                                        Yosiet Serga
                                        <i class="fa fa-pencil-square fa-1x"></i>
                                    </h3>
                                </a>
                                <small>Inversiones Necoyoad, C.A.</small>
                                <h2>Bs. 53000,00</h2>

                                <div class="clear"></div>

                                <div class="inProcess"><?php echo $Language->get('In Process'); ?></div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="grid_3">
                    <div class="title">
                        <h2>Pre-Venta</h2>
                        <small>Total Customers: 5 | Total Order: Bs. 544000,00</small>
                    </div>
                    <hr />
                    <ul id="task_step_1<?php echo $step['step_id']; ?>" class="tasksWrapper" data-position="3<?php echo $step['step_id']; ?>">
                        <li>
                            <div class="grid_12">

                                <img src="http://www.necoshop.com/web/assets/images/data/profiles/avatar.png" title="Yosiet Serga" width="40" />
                                <a href="#">
                                    <h3>
                                        Yosiet Serga
                                        <i class="fa fa-pencil-square fa-1x"></i>
                                    </h3>
                                </a>
                                <small>Inversiones Necoyoad, C.A.</small>
                                <h2>Bs. 53000,00</h2>

                                <div class="clear"></div>

                                <div class="completed"><?php echo $Language->get('Completed'); ?></div>
                            </div>
                        </li>
                    </ul>
                </div>


                <div class="grid_3">
                    <div class="title">
                        <h2>Vendido</h2>
                        <small>Total Customers: 5 | Total Order: Bs. 544000,00</small>
                    </div>
                    <hr />
                    <ul id="task_step_w<?php echo $step['step_id']; ?>" class="tasksWrapper" data-position="4<?php echo $step['step_id']; ?>">
                        <li>
                            <div class="grid_12">

                                <img src="http://www.necoshop.com/web/assets/images/data/profiles/avatar.png" title="Yosiet Serga" width="40" />
                                <a href="#">
                                    <h3>
                                        Yosiet Serga
                                        <i class="fa fa-pencil-square fa-1x"></i>
                                    </h3>
                                </a>
                                <small>Inversiones Necoyoad, C.A.</small>
                                <h2>Bs. 53000,00</h2>

                                <div class="clear"></div>

                                <div class="canceled"><?php echo $Language->get('Canceled'); ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
</script>
<?php echo $footer; ?>