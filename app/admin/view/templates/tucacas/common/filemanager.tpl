<!DOCTYPE html><html lang="es"><head>
    <title><?php echo $title; ?></title>
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <base href="<?php echo $base; ?>" />
    <link rel="stylesheet" type="text/css" href="css/vendor.css" />
    <link rel="stylesheet" type="text/css" href="css/filemanager.css" />
    
    <script src="js/vendor/modernizr.min.js"></script>
</head>
<body>
    <div class="container">
    
        <div id="tabs" class="grid_12">
            <ul>
                <li id="browser">Browser</li>
                <li id="frompc">Desde el PC</li>
                <!--<li id="fromurl">Desde URL</li>-->
            </ul>
        </div>
        
        <div classW="clear"></div>
        
        <div class="tabs grid_12" id="tabbrowser">
            <div id="menu">
                <a id="create" class="button" style="background-image: url('image/filemanager/folder.png');">
                    <span class="hideOnMobile hideOnTablet"><?php echo $Language->get('button_folder'); ?></span>
                </a>
                <a id="delete" class="button" style="background-image: url('image/filemanager/edit-delete.png');">
                    <span class="hideOnMobile hideOnTablet"><?php echo $Language->get('button_delete'); ?></span>
                </a>
                <!--
                <a id="move" class="button" style="background-image: url('image/filemanager/edit-cut.png');">
                    <span class="hideOnMobile hideOnTablet"><?php echo $Language->get('button_move'); ?></span>
                </a>
                <a id="copy" class="button" style="background-image: url('image/filemanager/edit-copy.png');">
                    <span class="hideOnMobile hideOnTablet"><?php echo $Language->get('button_copy'); ?></span>
                </a>
                <a id="rename" class="button" style="background-image: url('image/filemanager/edit-rename.png');">
                    <span class="hideOnMobile hideOnTablet"><?php echo $Language->get('button_rename'); ?></span>
                </a>
                -->
                <a onclick="$('.tabs').hide();$('#tabfrompc').show();" class="button" style="background-image: url('image/filemanager/upload.png');">
                    <span class="hideOnMobile hideOnTablet"><?php echo $Language->get('button_upload'); ?></span>
                </a>
                <a id="refresh" class="button" style="background-image: url('image/filemanager/refresh.png');">
                    <span class="hideOnMobile hideOnTablet"><?php echo $Language->get('button_refresh'); ?></span>
                </a>
                <input type="text" name="qfiles" value="" onkeyup="searchFiles(this);" placeholder="<?php echo $Language->get('Search Files'); ?>" />
            </div>
            
            <div class="clear"></div>
            
            <div class="grid_3" id="column_left"></div>
            <form id="form">
                <div class="grid_8" id="column_right"></div>
            </form>
        </div>
        
        <div class="clear"></div>
        
        <div class="tabs" id="tabfrompc">
            <p>
                <b>Instruccioes:</b>
                Antes de subir los archivos, debes seleccionar la carpeta donde quieres guardarlos. Haz click 
                <a href="#" title="Seleccionar carpeta" onclick="$('.tabs').hide();$('#tabfrompc').show();return false;">aqu&iacute;</a> para seleccionar la carpeta.
            </p>
            
            <a class="uploadStart">Comenzar a Subir</a>
            
            <div class="clear"></div>
            
            <input type="hidden" id="directoryForUpload" value="" />
            
            <div id="dropHere">
                <input id="fileupload" type="file" name="files[]" multiple="multiple" accept="image/*" capture="camera" />
                <p>
                    Arrastra los archivos hasta aqu&iacute;
                    <br />
                    <span>Tambi&eacute;n puedes hacer click en el bot&oacute;n para <a class="buttonBlue">Examinar</a> y elegir tus archivos</span>
                </p>
            </div>
            
            <ul id="filesUploaded"></ul>
            
            <div id="scrollDown"></div>
            
        </div>
        
        <div class="clear"></div>
        <!--
        <div class="tabs" id="tabfromurl">
        
        </div>
        -->
    </div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>window.$ || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>
<script type="text/javascript" src="js/vendor/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/vendor/jstree/jstree.min.js"></script>
<script type="text/javascript" src="js/vendor/fileUploader/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="js/vendor/fileUploader/jquery.fileupload.js"></script>
<script type="text/javascript" src="js/commonfilemanager.js"></script>
<script type="text/javascript">
$(function(){
    $(".tabs").hide();
    $("#tabbrowser").show();
    $("#tabs li").click(function(){
        $(".tabs").hide();
        $("#tab" + this.id).show();  
    });
    
    var windowHeight = $(window).height();
    $("#dropHere").css({
        height:(windowHeight * 60 / 100) + 'px'
    });
    
    window.baseImageUrl = '<?php echo HTTP_IMAGE; ?>';
    window.field = '<?php echo $field; ?>';
    window.preview = '<?php echo $preview; ?>';
    window.isFckeditor = '<?php echo $fckeditor; ?>';
    
    loadDirectories('<?php echo $GET['token']; ?>');
});
function searchFiles(e) {
    var q = '';
    q = e.value.toLowerCase().trim();
    $('#column_right li p').each(function(){
        name = $(this).text().replace(/-/g, ' ');
        if (name.indexOf(q) === -1) {
            $(this).closest('li').hide();
        } else {
            $(this).closest('li').show();
        }
    });
}
</script>
</body>
</html>