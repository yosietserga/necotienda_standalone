<?php

final class Cache {

    private $expire;

    public function __construct() {
        if (!is_dir(DIR_CACHE)) {
            mkdir(DIR_CACHE, 0755);
        }

        $this->expire = 60*3600;

        $files = glob(DIR_CACHE . '*.cache');

        if ($files) {
            foreach ($files as $file) {
                $time = substr(strrchr(str_replace('.cache','',$file), '.'), 1);

                if ($time < time()) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
        }
    }

    public function get($key, $prefix="") {
        if (!empty($prefix)) $prefix = $this->sanitizeCacheId($prefix).'.';
        $files = glob(DIR_CACHE . $prefix . md5($key) . '*.cache');

        if ($files) {
            $cache = file_get_contents($files[0]);
            return unserialize($cache);
        }
    }

    public function set($key, $value, $prefix="") {
        $this->delete($key, $prefix);
        if (!empty($prefix)) $prefix = $this->sanitizeCacheId($prefix).'.';
        $file = DIR_CACHE . $prefix . md5($key) .'.'. (time() + $this->expire . '.cache');

        $handle = fopen($file, 'w');

        fwrite($handle, serialize($value));

        fclose($handle);
    }

    public function delete($prefix) {
        $prefix = $this->sanitizeCacheId($prefix);
        $files = glob(DIR_CACHE . $prefix . '*.cache');

        if ($files) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }

    protected function sanitizeCacheId($cachedId) {

        if($cachedId !== mb_convert_encoding( mb_convert_encoding($cachedId, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
            $cachedId = mb_convert_encoding($cachedId, 'UTF-8', mb_detect_encoding($cachedId));
        $cachedId = htmlentities($cachedId, ENT_NOQUOTES, 'UTF-8');
        $cachedId = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $cachedId);
        $cachedId = html_entity_decode($cachedId, ENT_NOQUOTES, 'UTF-8');
        $cachedId = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $cachedId);
        $cachedId = strtolower( trim($cachedId, '-') );

        return $cachedId;
    }

}
