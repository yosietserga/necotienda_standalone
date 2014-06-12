<?php echo $header; ?>
<div class="grid_24">
    <div class="box">
        <div class="header">
            <h1><?php echo $Language->get('heading_title'); ?></h1>
            <div class="buttons">
                <a onclick="location = '<?php echo $insert; ?>'" class="button">Agregar Nuevo</a>
            </div>
        </div>    
          
        <div class="clear"></div><br />
        
        <h3>Filtros<span id="filters">[ Mostrar ]</span></h3>
        <form action="<?php echo $search; ?>" method="post" enctype="multipart/form-data" id="formFilter">        
            <div class="grid_11">
                <div class="row">       
                    <label>Pedido ID:</label>
                    <input type="text" name="filter_order_id" value="" />
                </div>
                    
                <div class="row">       
                    <label>Pago ID:</label>
                    <input type="text" name="filter_payment_id" value="" />
                </div>
                    
                <div class="row">       
                    <label>Nombre del Cliente:</label>
                    <input type="text" name="filter_customer" value="" />
                </div>
                    
                <div class="row">       
                    <label>N&uacute;mero de Transacci&oacute;n:</label>
                    <input type="text" name="filter_transac_number" value="" />
                </div>
                    
                <div class="row">
                    <label>Estado:</label>
                    <select name="filter_status">
                        <option value="">Selecciona una opci&oacute;n</option>
                        <?php foreach ($order_payment_statuses as $key => $value) { ?>
                        <option value="<?php echo $value['order_payment_status_id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                    
                <div class="row">
                    <label>Banco:</label>
                    <select name="filter_bank">
                        <option value="">Selecciona una opci&oacute;n</option>
                        <?php foreach ($banks as $key => $value) { ?>
                        <option value="<?php echo $value['bank_id']; ?>"><?php echo $value['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                    
                <div class="row">
                    <label>Ordernar Por:</label>
                    <select name="sort">
                        <option value="">Selecciona un campo</option>
                        <option value="op.amount">Monto</option>
                        <option value="op.order_id">Pedido ID</option>
                        <option value="customer">Cliente</option>
                        <option value="op.order_payment_status_id">Estado</option>
                        <option value="bk.name">Banco</option>
                        <option value="op.date_added">Fecha cuando se cre&oacute;</option>
                    </select>
                </div>
            </div>
            
            <div class="grid_11">
                <div class="row">
                    <label>Fecha Inicial:</label>
                    <input type="necoDate" name="filter_date_start" value="" />
                </div>
                
                <div class="row">
                    <label>Fecha Final:</label>
                    <input type="necoDate" name="filter_date_end" value="" />
                </div>
                
                <div class="row">
                    <label>Mostrar:</label>
                    <select name="limit">
                        <option value="">Selecciona una cantidad</option>
                        <option value="10">10 Resultados por p&aacute;gina</option>
                        <option value="25">25 Resultados por p&aacute;gina</option>
                        <option value="50">50 Resultados por p&aacute;gina</option>
                        <option value="100">100 Resultados por p&aacute;gina</option>
                        <option value="150">150 Resultados por p&aacute;gina</option>
                    </select>
                </div>
            </div>
                        
            <div class="clear"></div><br />
        </form>
    </div>
</div>
<div class="clear"></div>
<?php if ($error_warning) { ?><div class="grid_24"><div class="message warning"><?php echo $error_warning; ?></div></div><?php } ?>
<?php if ($success) { ?><div class="grid_24"><div class="message success"><?php echo $success; ?></div></div><?php } ?>
<div class="grid_24" id="msg"></div>
<div class="clear"></div>
<div class="grid_24">
    <div class="box">
        <div id="gridPreloader"></div>
        <div id="gridWrapper"></div>
    </div>
</div>
<?php echo $footer; ?>