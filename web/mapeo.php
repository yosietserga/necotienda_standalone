<?php

function getDirs($path) {
    $directories = glob($path . '*/*', GLOB_ONLYDIR);
    $folders = $return = array();
    foreach ($directories as $directory) {
        $folders[] = basename($directory);
        $files = glob($directory . '/*.php');
        foreach ($files as $file) {
            $return[] = array(
                'checksum'=>md5(file_get_contents($file)),
                'path'=>str_replace('/home/necoyoad/Escritorio/www/myapps/necotienda_standalone/','',$file),
                'version'=>(int)$version
            );
        }
    }
    return $return;
}

$path = '/home/necoyoad/Escritorio/www/myapps/necotienda_standalone/app/shop/';

$link = fopen(__DIR__ . '/shop_map.php', 'w+');
fwrite($link, "<?php\n". '$map = ' . var_export(getDirs($path), true) . ";");
fclose($link);