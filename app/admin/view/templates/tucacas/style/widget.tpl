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
            <div class="header">
                <h1>Widgets</h1>
                
                <?php if ($stores) { ?>
                <div class="pull-right">
                    <label><?php echo $Language->get('entry_store'); ?></label><br />
                    <select onchange="window.location = '<?php echo $Url::createAdminUrl("style/widget"); ?>&store_id='+ this.value">
                        <option value="0"<?php if ($store_id==0) { echo ' selected="selected"'; } ?>><?php echo $Language->get('text_default'); ?></option>
                        <?php foreach ($stores as $store) { ?>
                        <option value="<?php echo $store['store_id']; ?>"<?php if ($store_id==$store['store_id']) { echo ' selected="selected"'; } ?>><?php echo $store['name']; ?></option>
                        <?php } ?>
                    </select>
                </div> 
                <?php } ?>
            </div>    

            <div class="clear"></div><br />

            <div class="grid_3" id="widgetsWrapper" style="margin:0px !important;">
                <input type="text" id="qWidgets" placeholder="<?php echo $Language->get('text_filter'); ?>" />
                <ul id="widgetsPanel" class="widget widgetsPanel">
                    <?php foreach ($modules as $module) { ?>
                    <li class="neco-widget" data-title="<?php echo $module['name']; ?>" data-widget="<?php echo $module['widget']; ?>">
                        <b><?php echo $module['name']; ?></b><br />
                        <?php echo $module['description']; ?>
                    </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="grid_9" id="blocksWrapper" style="margin:0px !important;padding:0px !important;">
                <div class="grid_11">
                    <h2>Cabecera (Header)</h2>
                    <ul id="widgetHeader" class="widgetWrapper" data-position="header">
                    <?php foreach ($widgets['header'] as $widget) { ?>
                        <li class="widgetSet" id="<?php echo $widget['name']; ?>">
                            <b class="widgetTitle"><?php echo $Language->get('text_'.$widget['extension']); ?></b><br />
                            <a class="advanced"><?php echo $Language->get('text_advanced'); ?></a><br />
                            <div class="attributes"></div>
                            <div style="float:right">
                                <a class="moveWidget button" style="padding:2px;cursor:move">Mover</a>
                                <a class="deleteWidget button" onclick="deleteWidget(this)" style="padding:2px;">Eliminar</a>
                            </div>
                        </li>
                        <script type="text/javascript">
                            $(function(){
                                loadNtWidgets({
                                    name: '<?php echo $widget['name']; ?>',
                                    position: '<?php echo $widget['position']; ?>',
                                    extension: '<?php echo $widget['extension']; ?>',
                                    order: '<?php echo (int)$widget['order']; ?>'
                                });
                            });
                        </script>
                    <?php } ?>
                    </ul>
                </div>
                
                <div class="clear"></div>
                
                <div class="grid_11">
                    <h2>Contenido Destacado (Featured Content)</h2>
                    <ul id="widgetFeaturedContent" class="widgetWrapper" data-position="featuredContent">
                    <?php foreach ($widgets['featuredContent'] as $widget) { ?>
                        <li class="widgetSet" id="<?php echo $widget['name']; ?>">
                            <b class="widgetTitle"><?php echo $Language->get('text_'.$widget['extension']); ?></b><br />
                            <a class="advanced"><?php echo $Language->get('text_advanced'); ?></a><br />
                            <div class="attributes"></div>
                            <div style="float:right">
                                <a class="moveWidget button" style="padding:2px;cursor:move">Mover</a>
                                <a class="deleteWidget button" onclick="deleteWidget(this)" style="padding:2px;">Eliminar</a>
                            </div>
                        </li>
                        <script type="text/javascript">
                            $(function(){
                                loadNtWidgets({
                                    name: '<?php echo $widget['name']; ?>',
                                    position: '<?php echo $widget['position']; ?>',
                                    extension: '<?php echo $widget['extension']; ?>',
                                    order: '<?php echo (int)$widget['order']; ?>'
                                });
                            });
                        </script>
                    <?php } ?>
                    </ul>
                </div>
                
                <div class="clear"></div>
                
                <div class="grid_3">
                    <h2>Columna Izquierda</h2>
                    <ul id="widgetColumnLeft" class="widgetWrapper" data-position="column_left">
                    <?php foreach ($widgets['column_left'] as $widget) { ?>
                        <li class="widgetSet" id="<?php echo $widget['name']; ?>">
                            <b class="widgetTitle"><?php echo $Language->get('text_'.$widget['extension']); ?></b><br />
                            <a class="advanced"><?php echo $Language->get('text_advanced'); ?></a><br />
                            <div class="attributes"></div>
                            <div style="float:right">
                                <a class="moveWidget button" style="padding:2px;cursor:move">Mover</a>
                                <a class="deleteWidget button" onclick="deleteWidget(this)" style="padding:2px;">Eliminar</a>
                            </div>
                        </li>
                        <script type="text/javascript">
                            $(function(){
                                loadNtWidgets({
                                    name: '<?php echo $widget['name']; ?>',
                                    position: '<?php echo $widget['position']; ?>',
                                    extension: '<?php echo $widget['extension']; ?>',
                                    order: '<?php echo (int)$widget['order']; ?>'
                                });
                            });
                        </script>
                    <?php } ?>
                    </ul>
                </div>
                
                <div class="grid_5" style="margin-left: 2%;">
                    <h2>Principal</h2>
                    <ul id="widgetMain" class="widgetWrapper" data-position="main">
                    <?php foreach ($widgets['main'] as $widget) { ?>
                        <li class="widgetSet" id="<?php echo $widget['name']; ?>">
                            <b class="widgetTitle"><?php echo $Language->get('text_'.$widget['extension']); ?></b><br />
                            <a class="advanced"><?php echo $Language->get('text_advanced'); ?></a><br />
                            <div class="attributes"></div>
                            <div style="float:right">
                                <a class="moveWidget button" style="padding:2px;cursor:move">Mover</a>
                                <a class="deleteWidget button" onclick="deleteWidget(this)" style="padding:2px;">Eliminar</a>
                            </div>
                        </li>
                        <script type="text/javascript">
                            $(function(){
                                loadNtWidgets({
                                    name: '<?php echo $widget['name']; ?>',
                                    position: '<?php echo $widget['position']; ?>',
                                    extension: '<?php echo $widget['extension']; ?>',
                                    order: '<?php echo (int)$widget['order']; ?>'
                                });
                            });
                        </script>
                    <?php } ?>
                    </ul>
                </div>
                
                <div class="grid_3">
                    <h2>Columna Derecha</h2>
                    <ul id="widgetColumnRight" class="widgetWrapper" data-position="column_right">
                    <?php foreach ($widgets['column_right'] as $widget) { ?>
                        <li class="widgetSet" id="<?php echo $widget['name']; ?>">
                            <b class="widgetTitle"><?php echo $Language->get('text_'.$widget['extension']); ?></b><br />
                            <a class="advanced"><?php echo $Language->get('text_advanced'); ?></a><br />
                            <div class="attributes"></div>
                            <div style="float:right">
                                <a class="moveWidget button" style="padding:2px;cursor:move">Mover</a>
                                <a class="deleteWidget button" onclick="deleteWidget(this)" style="padding:2px;">Eliminar</a>
                            </div>
                        </li>
                        <script type="text/javascript">
                            $(function(){
                                loadNtWidgets({
                                    name: '<?php echo $widget['name']; ?>',
                                    position: '<?php echo $widget['position']; ?>',
                                    extension: '<?php echo $widget['extension']; ?>',
                                    order: '<?php echo (int)$widget['order']; ?>'
                                });
                            });
                        </script>
                    <?php } ?>
                    </ul>
                </div>
                
                <div class="clear"></div>
                
                <div class="grid_11">
                    <h2>Antes del Pie de P&aacute;gina</h2>
                    <ul id="featuredFooter" class="widgetWrapper" data-position="featuredFooter">
                    <?php foreach ($widgets['featuredFooter'] as $widget) { ?>
                        <li class="widgetSet" id="<?php echo $widget['name']; ?>">
                            <b class="widgetTitle"><?php echo $Language->get('text_'.$widget['extension']); ?></b><br />
                            <a class="advanced"><?php echo $Language->get('text_advanced'); ?></a><br />
                            <div class="attributes"></div>
                            <div style="float:right">
                                <a class="moveWidget button" style="padding:2px;cursor:move">Mover</a>
                                <a class="deleteWidget button" onclick="deleteWidget(this)" style="padding:2px;">Eliminar</a>
                            </div>
                        </li>
                        <script type="text/javascript">
                            $(function(){
                                loadNtWidgets({
                                    name: '<?php echo $widget['name']; ?>',
                                    position: '<?php echo $widget['position']; ?>',
                                    extension: '<?php echo $widget['extension']; ?>',
                                    order: '<?php echo (int)$widget['order']; ?>'
                                });
                            });
                        </script>
                    <?php } ?>
                    </ul>
                </div>
                
                <div class="clear"></div>
                
                <div class="grid_11">
                    <h2>Pie de P&aacute;gina</h2>
                    <ul id="widgetFooter" class="widgetWrapper" data-position="footer">
                    <?php foreach ($widgets['footer'] as $widget) { ?>
                        <li class="widgetSet" id="<?php echo $widget['name']; ?>">
                            <b class="widgetTitle"><?php echo $Language->get('text_'.$widget['extension']); ?></b><br />
                            <a class="advanced"><?php echo $Language->get('text_advanced'); ?></a><br />
                            <div class="attributes"></div>
                            <div style="float:right">
                                <a class="moveWidget button" style="padding:2px;cursor:move">Mover</a>
                                <a class="deleteWidget button" onclick="deleteWidget(this)" style="padding:2px;">Eliminar</a>
                            </div>
                        </li>
                        <script type="text/javascript">
                            $(function(){
                                loadNtWidgets({
                                    name: '<?php echo $widget['name']; ?>',
                                    position: '<?php echo $widget['position']; ?>',
                                    extension: '<?php echo $widget['extension']; ?>',
                                    order: '<?php echo (int)$widget['order']; ?>'
                                });
                            });
                        </script>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/vendor/jquery.ajaxqueue.min.js"></script>
<?php echo $footer; ?>