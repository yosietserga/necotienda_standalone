<?php echo $header; ?>
<?php echo $navigation; ?>
<section id="maincontent" class="nt-editable">
    <section id="content" class="nt-editable">
	   <aside id="column_left" class="nt-editable"><?php echo $column_left; ?></aside>
        <div class="grid_13">
            <h1><?php echo $heading_title; ?></h1>
            <?php if ($success) { ?><div class="success"><?php echo $success; ?></div><?php } ?>
            <?php if ($error) { ?><div class="warning"><?php echo $error; ?></div><?php } ?>
            <div class="clear"></div>
            <div class="box">
                <div class="header">
				    <h2>Mensajes</h2>
				</div>
				<div class="content"></div>
            </div>
    		<div class="box">
                <div class="header">
                    <h2>Actividades Recientes</h2>
                </div>
    			<div class="content"></div>
    		</div>
    		<div class="box">
                <div class="header">
                    <h2>Últimos Pedidos</h2>
                </div>
                <div class="content"></div>
            </div>
    		<div class="box">
                <div class="header">
                    <h2>Recomendaciones</h2>
                </div>
    			<div class="content"></div>
    		</div>
        </div>
    </section>
</section>
<?php echo $footer; ?>