<?php

class Module extends Controller
{

    public function __construct($registry) {
        parent::__construct($registry);

        $this->moduleClass = get_called_class();
        $this->moduleRoute = 'module/'. str_replace('controllermodule', '', strtolower($this->moduleClass));
        $this->loadDeps($this->moduleRoute);
    }

    protected function loadDeps($route) {
        foreach ($this->js_assets as $i => $routes) {
            if (empty($routes)) continue;
            if ((is_array($routes) && in_array($route, $routes)) || $routes === '*') {
                $this->javascripts = array_merge($this->javascripts, array($i));
                unset($this->js_assets[$i]);
            }
        }

        foreach ($this->js_header_assets as $i => $routes) {
            if (empty($routes)) continue;
            if (is_array($routes) && in_array($route, $routes) || $routes === '*') {
                $this->header_javascripts = array_merge($this->header_javascripts, array($i));
                unset($this->js_header_assets[$i]);
            }
        }

        if ($this->jsx_assets) {
            foreach ($this->jsx_assets as $i => $routes) {
                if (empty($routes)) continue;
                if ((is_array($routes) && in_array($route, $routes)) || $routes === '*') {
                    $this->scripts = array_merge($this->scripts, array(
                        array(
                        'method' => 'jsx',
                        'id' => $i,
                        'script' => file_get_contents($i)
                        )
                    ));
                    unset($this->jsx_assets[$i]);
                }
            }
        }

        foreach ($this->css_assets as $i => $asset) {
            if (empty($asset['css'])) continue;
            if ((is_array($asset['routes']) && in_array($route, $asset['routes'])) || $asset['routes'] === '*') {
                $this->styles = array_merge($this->styles, array($asset['css']));
                unset($this->css_assets[$i]);
                break;
            }
        }
    }

    protected function loadWidgetAssets($filename, $subfolder = null) {
        if (!$filename) return false;
        $this->_loadAssets($filename, $subfolder);
    }
}