<?php ini_set('error_reporting',E_ALL^E_STRICT);

// Configuration
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app/shop/config.php');
   
// Startup
require_once(DIR_SYSTEM . 'startup.php');

$registry   = new Registry();
$loader     = new Loader($registry);
$config     = new Config();
$db         = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$log        = new Log($config->get('config_error_filename'));
$request    = new Request();
$response   = new Response();
$controller = new Front($registry);
$session    = new Session();

// JS
$javascripts = array();
$registry->set('javascripts', $javascripts);

// CSS
$styles = array();
$registry->set('styles', $styles);

// SCRIPTS
$scripts = array();
$registry->set('scripts', $scripts);

// llave para utilizar en los formularios y evitar ataques csrf
if (!$session->has('fkey')) {
    $i = 0;
    $super_rand = "";
    while ($i <= 10) {
        $super_rand .= md5(mt_rand(1000000000,9999999999));
        $i++;
    }
    $session->set('fkey',md5($_SERVER['REMOTE_ADDR']) . "." . $super_rand."_".strtotime(date('d-m-Y'))); 
    $registry->set('fkey', $session->get('fkey'));
} else {
    $registry->set('fkey', $session->get('fkey'));
}
    
// Config
$config = !$session->has("config") ? $config = new Config() : $session->get("config"); 

// Settings
if (!$session->has("config")) {
    $query = $db->query("SELECT * FROM " . DB_PREFIX . "setting");
    foreach ($query->rows as $setting) {
            $config->set($setting['key'], $setting['value']);
    }
}

$response->addHeader('Content-Type: text/html; charset=utf-8');

// Language Detection
$languages = array();

$query = $db->query("SELECT * FROM " . DB_PREFIX . "language"); 

foreach ($query->rows as $result) {
	$languages[$result['code']] = array(
		'language_id' => $result['language_id'],
		'name'        => $result['name'],
		'code'        => $result['code'],
		'locale'      => $result['locale'],
		'directory'   => $result['directory'],
		'filename'    => $result['filename']
	);
}

$detect = '';

if (isset($request->server['HTTP_ACCEPT_LANGUAGE']) && ($request->server['HTTP_ACCEPT_LANGUAGE'])) { 
	$browser_languages = explode(',', $request->server['HTTP_ACCEPT_LANGUAGE']);
	
	foreach ($browser_languages as $browser_language) {
		foreach ($languages as $key => $value) {
			$locale = explode(',', $value['locale']);

			if (in_array($browser_language, $locale)) {
				$detect = $key;
			}
		}
	}
}

if (isset($_GET['language']) && array_key_exists($_GET['language'], $languages)) {
	$code = $_GET['language'];
} elseif ($session->has('language') && array_key_exists($session->get('language'), $languages)) {
	$code = $session->get('language');
} elseif (isset($request->cookie[C_CODE."_".'language']) && array_key_exists($request->cookie[C_CODE."_".'language'], $languages)) {
	$code = $request->cookie[C_CODE."_".'language'];
} elseif ($detect) {
	$code = $detect;
} else {
	$code = $config->get('config_language');
}

if (!$session->has('language') || $session->get('language') != $code) {
	$session->set('language',$code);
}

if (!isset($request->cookie[C_CODE."_".'language']) || $request->cookie[C_CODE."_".'language'] != $code) {	  
	setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $request->server['HTTP_HOST']);
}			

$config->set('config_language_id', $languages[$code]['language_id']);
$config->set('config_language', $languages[$code]['code']);

// Language		
$language = new Language($languages[$code]['directory']);
$language->load($languages[$code]['filename']);

// Log 
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);

function error_handler($errno, $errstr, $errfile, $errline) {
	global $log, $config;
	
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	}
		
    echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b></br >';
    $log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	return true;
}
	
// Error Handler
set_error_handler('error_handler');

// App Libs and Configs Preload
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app/shop/map.php');
if (!$session->has("config")) $session->set("config", $config);

// Front Controller 
$controller = new Front($registry);

// Maintenance Mode
$controller->addPreAction(new Action('common/maintenance/check'));

// SEO URL's
$controller->addPreAction(new Action('common/seo_url'));
// Router
if (isset($request->get['r'])) {
    if (!isset($controller->ClassName)) $controller->ClassName = $request->get['r'];
	$action = new Action($request->get['r']);
} else {
	$action = new Action('common/home');
}

// Dispatch
$controller->dispatch($action, new Action('error/not_found'));

// Output
$response->output();