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
                <h1><?php echo $Language->get('heading_title'); ?></h1>
                <div class="buttons">
                <a onclick="location = '<?php echo $insert; ?>'" class="button"><?php echo $Language->get('button_insert'); ?></a>
                </div>
            </div>    

            <div class="clear"></div><br />

            <h3>Filtros<span id="filters">[ Mostrar ]</span></h3>
            <form action="<?php echo $search; ?>" method="post" enctype="multipart/form-data" id="formFilter">        
                <div class="grid_11">
                    <div class="row">       
                        <label>Nombre del Tema:</label>
                        <input type="text" name="filter_name" value="" />
                    </div>

                    <div class="row">
                        <label>Asociado a la Plantilla:</label>
                        <input type="text" name="filter_template" value="" />
                    </div>

                    <div class="row">
                        <label>Ordernar Por:</label>
                        <select name="sort">
                            <option value="">Selecciona un campo</option>
                            <option value="name">Nombre</option>
                            <option value="sort_order">Posici&oacute;n</option>
                            <option value="date_added">Fecha cuando se cre&oacute;</option>
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
    
    <div class="grid_12">
        <div class="box">
            <div id="gridWrapper">
                <?php foreach($templates as $template) { ?>
                <div class="grid_4" style="margin:30px 5px;padding:5px;">
                    <a href="javascript:void(0)">
                        <img src="<?php echo $template['thumb']; ?>" alt="<?php echo $template['name']; ?>" width="200" />
                    </a>
                    <div class="product_desc">
                        <h2><?php echo $template['name']; ?></h2>
                        
                        <p>
                            Ref: <?php echo $template['ref']; ?>&nbsp;
                            <?php if (in_array($template['ref'], $templates_installed)) { ?>
                            <b>Plantilla Instalada</b>
                            <?php } ?>
                        </p>
                        <span class="tempalte_review">
                            <img src="image/stars_<?php echo (int)$template['review']; ?>.png" alt="Review: <?php echo (int)$template['review']; ?>" />
                        </span>
                        <p>
                            <i class="fa fa-home"></i>&nbsp;Autor: <?php echo $template['author']['name']; ?> <a href="<?php echo $template['author']['profile']; ?>"><i class="fa fa-home"></i></a><br />
                            <i class="fa fa-home"></i>&nbsp;Versión: <?php echo $template['version']; ?><br />
                            <i class="fa fa-home"></i>&nbsp;Compatibilidad: NTS <?php echo implode(', ',$template['compatibility']); ?><br />
                            <i class="fa fa-home"></i>&nbsp;Descargas: <?php echo $template['downloads']; ?><br />
                            <i class="fa fa-home"></i>&nbsp;Status: <?php echo ($template['status']) ? $Language->get('Disponible') : $Language->get('Indisponible'); ?><br />
                        </p>
                        <p class="price" data-price="<?php echo $template['price']; ?>" data-currency="<?php echo $template['VEF']; ?>"><?php echo $template['price_text']; ?></p>
                        <br />
                        <a class="button" href="<?php echo $template['demourl']; ?>">Demo</a>
                        <a class="button" href="<?php echo $template['url']; ?>" target="_blank">Más Detalles</a>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>



                    'ref'=>'93820',
                    'name'=>'Hero Winter',
                    'price'=>1000.0000,
                    'price_text'=>'Bs. 3600,00',
                    'currency'=>'VEF',
                    'version'=>'0.0.1',
                    'legacy'=>'2.0.0',
                    'compatibility'=>[
                       '2.0.0',
                       '2.0.3'
                    ],
                    'demourl'=>'http://demo.necoyoad.com/web-template-93820',
                    'url'=>'http://www.necoyoad.com/web-template-93820',
                    'thumb'=>'http://scr0.templatemonster.com/52200/52268-med.jpg',
                    'preview'=>'http://scr0.templatemonster.com/52200/52268-med.jpg',
                    'author'=>[
                        'url'=>'http://www.necoyoad.com',
                        'name'=>'NecoYoad',
                        'profile'=>'http://www.necotienda.org/profile/necoyoad'
                    ],
                    'review'=>1,
                    'downloads'=>123,
                    'status'=>1