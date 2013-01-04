<?php define('CATALOG', 'shop');

$publictPath    = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "web" . DIRECTORY_SEPARATOR;
$privatePath    = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$mainPath       = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR;

$protocol       = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http://' : 'https://';
$httpDefaultPath= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] : substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],"/")+1);
$httpPath = str_replace('/index.php',"",$httpDefaultPath);

/*
$httpPath   = $_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],"/")+1);
$httpPath   = str_replace("//","/",$httpPath);
*/
/**
 * descomentar para agregar un cdn
 * define('CDN', null);
 * */
 
 // HTTP addresses
define('HTTP_HOME',     "http://" . $httpPath . "/");
define('HTTP_IMAGE',    HTTP_HOME . "assets/images/");
define('HTTP_CSS',      HTTP_HOME . "assets/css/");
define('HTTP_JS',       HTTP_HOME . "assets/js/");
define('HTTP_UPLOAD',   HTTP_HOME . "assets/upload/");
define('HTTP_DOWNLOAD', HTTP_HOME . "assets/upload/");

 // HTTPS addresses
define('HTTPS_HOME',     "https://" . $httpPath . "/");
define('HTTPS_IMAGE',    HTTP_HOME . "assets/images/");
define('HTTPS_CSS',      HTTP_HOME . "assets/css/");
define('HTTPS_JS',       HTTP_HOME . "assets/js/");
define('HTTPS_UPLOAD',   HTTP_HOME . "assets/upload/");
define('HTTPS_DOWNLOAD', HTTP_HOME . "assets/upload/");

define('DIR_APPLICATION',$privatePath);
define('DIR_MODEL',     $privatePath . "model" . DIRECTORY_SEPARATOR);
define('DIR_CONTROLLER',$privatePath . "controller" . DIRECTORY_SEPARATOR);
define('DIR_LANGUAGE',  $privatePath . "language" . DIRECTORY_SEPARATOR);
define('DIR_TEMPLATE',  $privatePath . "view/theme/");

// Shared Files
define('DIR_IMAGE',     $publictPath . "assets/images/");
define('DIR_CSS',       $publictPath . "assets/css/");
define('DIR_JS',        $publictPath . "assets/js/");
define('DIR_UPLOAD',    $publictPath . "assets/upload/");
define('DIR_DOWNLOAD',  $publictPath . "assets/upload/");

// System files
define('DIR_SYSTEM',    $mainPath . "system" . DIRECTORY_SEPARATOR);
define('DIR_DATABASE',  DIR_SYSTEM . 'database/');
define('DIR_CONFIG',    DIR_SYSTEM . 'config/');
define('DIR_CACHE',     DIR_SYSTEM . 'cache/');
define('DIR_LOGS',      DIR_SYSTEM . 'logs' . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR);

require_once($mainPath . "cconfig.php");