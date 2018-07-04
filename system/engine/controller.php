<?php

abstract class Controller {

    protected $registry;
    protected $id;
    protected $template;
    protected $templatePath = null;
    protected $children = array();
    protected $childrenParams = array();
    protected $data = array();
    protected $widget = array();
    protected $output;
    protected $cacheId = null;


    public function __construct($registry) {
        $this->registry = $registry;
    }

    public function __get($key) {
        return $this->registry->get($key);
    }

    public function __set($key, $value) {
        $this->registry->set($key, $value);
    }

    /**
     * Controller::setvar()
     * Asigna un valor a una variable 
     * @param string $varname
     * @param array $model
     * @return mixed $varname
     * */
    public function setvar($varname, $model = null, $default = null) {
        $config = $this->registry->get('config');
        if (isset($this->request->post[$varname])) {
            $this->data[$varname] = $this->request->post[$varname];
        } elseif (isset($model)) {
            $this->data[$varname] = $model[$varname];
        } elseif (isset($this->request->get[$varname])) {
            $this->data[$varname] = $this->request->get[$varname];
        } elseif (isset($config) && $config->get($varname)) {
            $this->data[$varname] = $config->get($varname);
        } elseif (isset($default)) {
            $this->data[$varname] = $default;
        } else {
            $this->data[$varname] = '';
        }
        return $this->data[$varname];
    }

    /**
     * Controller::setImageVar
     * Asigna el valor del campo de imagen del formulario
     * @param string $varname el nombre de la variable a definir
     * @param array $group el nombre del grupo de estilos
     * @return void
     * */
    public function setImageVar($varname, $group) {
        $this->load->model("image");
        $this->load->model("style/style");
        $model = $this->model_style_style->getStyles($group);

        if (!empty($model['background-image']) && file_exists(DIR_IMAGE . $model['background-image'])) {
            $this->data[$varname] = NTImage::resizeAndSave($model['background-image'], 100, 100);
            $this->data["_" . $varname] = $model['background-image'];
        } else {
            $this->data[$varname] = NTImage::resizeAndSave('sin_fondo.jpg', 100, 100);
            $this->data["_" . $varname] = "";
        }
    }

    /**
     * Controller::setStyleVar
     * Asigna el valor del campo de una propiedad css
     * @param string $varname el nombre de la variable a definir
     * @param array $group el nombre del grupo de estilos
     * @return void
     * */
    public function setStyleVar($varname, $group, $prefix = null) {
        $this->load->model("style/style");
        $model = $this->model_style_style->getStyles($group);

        if (!empty($model[$varname])) {
            if ($prefix)
                $this->data[$prefix . "_" . str_replace("-", "_", $varname)] = $model[$varname];
            else
                $this->data[$group . "_" . str_replace("-", "_", $varname)] = $model[$varname];
        } else {
            if ($prefix)
                $this->data[$prefix . "_" . str_replace("-", "_", $varname)] = $model[$varname];
            else
                $this->data[$group . "_" . str_replace("-", "_", $varname)] = $model[$varname];
        }
    }

    public function getvar($varname) {
        return isset($this->data[$varname]) ? $this->data[$varname] : false;
    }

    protected function forward($route, $args = array()) {
        return new Action($route, $args);
    }

    protected function redirect($url) {
        if (!headers_sent()) {
            header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url));
            exit;
        } else {
            echo "<script> window.location = '".str_replace('&amp;', '&', $url)."'; </script>";
        }
    }

    protected function addChild($child, $params = null) {
        if (!isset($child) || empty($child)) return false;

        array_push($this->children, $child);

        if (isset($params) || !empty($params)) {
            $this->childrenParams[$child] = $params;
        }
    }

    protected function getChild($child) {
        return isset($this->children[$child]) ? $this->children[$child] : false;
    }

    protected function getChildParams($child) {
        return isset($this->childrenParams[$child]) ? $this->childrenParams[$child] : false;
    }

    protected function getChildren() {
        return $this->children;
    }

    protected function render($return = false) {
        $cache = $this->registry->get('cache');
        $user = $this->registry->get('user');

        if (isset($this->cacheId) && !empty($this->cacheId) && isset($user) && !$user->islogged()) {
            $cached = $cache->get($this->cacheId, substr($this->cacheId, 0, strpos($this->cacheId, '.')));
        }
        
        if (!isset($cached)) {
            if (defined('APP_PATH')) {
                if (str_replace('controller','',strtolower($this->ClassName)) != str_replace('/','',strtolower($this->Route))) $this->loadAssets($this->ClassName, APP_PATH);
                $this->loadAssets($this->Route, APP_PATH);
            } else {
                if (str_replace('controller','',strtolower($this->ClassName)) != str_replace('/','',strtolower($this->Route))) $this->loadAssets($this->ClassName);
                $this->loadAssets($this->Route);
            }
            foreach ($this->getChildren() as $key => $child) {
                $action = new Action($child);
                $file = $action->getFile();
                $class = $action->getClass();
                $method = $action->getMethod();
                $args = $action->getArgs();
                
                if (file_exists($file)) {
                    require_once($file);
                    $controller = new $class($this->registry);
                    $params = isset($this->widget[$key]) ? $this->widget[$key] : $this->getChildParams($child);
                    
                    if (defined('APP_PATH')) {
                        if ($this->Method != 'index') $this->loadAssets($class.$this->Method, APP_PATH);
                        $this->loadAssets($class, APP_PATH);
                    } else {
                        if ($this->Method != 'index') $this->loadAssets($class.$this->Method);
                        $this->loadAssets($class);
                    }
                    
                    $controller->index($params);
                    
                    if (!is_numeric($key)) {
                        $this->data[$key . "_hook"] = $key;
                        $this->data[$key . "_code"] = $controller->output;
                    } else {
                        $this->data[$controller->id] = $controller->output;
                    }
                } else {
                    exit('Error: Could not load controller ' . $child . '!');
                }
            }

            if ($return) {
                $r = $this->fetch($this->template);
                if (isset($this->cacheId) && !empty($this->cacheId)) {
                    $cache->set($this->cacheId, $r, substr($this->cacheId, 0, strpos($this->cacheId, '.')));
                }
                return $r;
            } else {
                $this->output = $this->fetch($this->template);
            }
        } else {
            if ($return) {
                return $cached;
            } else {
                $this->output = $cached;
            }
        }
    }

    protected function fetch($filename) {
        if ($this->templatePath && is_dir($this->templatePath)) {
            $file = $this->templatePath . $filename;
        } else {
            $file = DIR_TEMPLATE . $filename;
        }
        
        if (file_exists($file)) {
            $this->data['Api'] = $this->registry->get('api');
            $this->data['Config'] = $this->registry->get('config');
            $this->data['Language'] = $this->registry->get('language');
            $this->data['Request'] = $this->registry->get('request');

            if (strpos(strtolower($this->Classname), 'footer')>= 0) $this->data['javascripts'] = $this->registry->get('javascripts');
            if (strpos(strtolower($this->Classname), 'header')>= 0) $this->data['styles'] = $this->registry->get('styles');
            if (strpos(strtolower($this->Classname), 'header')>= 0) $this->data['header_javascripts'] = $this->registry->get('header_javascripts');

            $this->data['Url'] = new Url($this->registry);
            $this->data['Image'] = new NTImage;

            extract($this->data);
            ob_start();
            require($file);
            $content = ob_get_contents();
            ob_end_clean();
            
            foreach ($this->children as $key => $child) {
                if (!is_numeric($key)) {
                    $content = str_replace('{%' . $this->data[$key . "_hook"] . '%}', $this->data[$key . "_code"], $content);
                }
            }

            foreach ($this->children as $key => $child) {
                if (!is_numeric($key)) {
                    $content = str_replace('{%' . $this->data[$key . "_hook"] . '%}', $this->data[$key . "_code"], $content);
                }
            }

            if ($this->data['Config']->get('config_minified_html') && defined('STORE_ID')) {
                $content = preg_replace('!/\*.*?\*/!s', '', $content);
                $content = str_replace("\n", "", $content);
                $content = str_replace("\r", "", $content);
                $content = preg_replace('/\s{2,}/', "", $content);
                $content = preg_replace('/\n\s*\n/', "\n", $content);
            }
            return $content;
        } else {
            exit('Error: Could not load template ' . $file . '!');
        }
    }

    public function renderChild($view, $template = null) {
        $config = $this->registry->get('config');
        if ($config->get('config_template') !== 'choroni' && !$template) {
            $template = $config->get('config_template');
        } else {
            $template = 'choroni';
        }
        if (file_exists(DIR_TEMPLATE . $template ."/". $view .".tpl")) {
            include_once(DIR_TEMPLATE . $template ."/". $view .".tpl");
        } else {
            //TODO: mostrar mensaje de error
            echo "No se pudo cargar el archivo $view";
        }
        //TODO: integrate view engine render
    }

    protected function loadWidgets($position, $landing_page = 'all', $app = 'shop', $full_tree = true) {
        $load = $this->registry->get('load');
        $session = $this->registry->get('session');
        $browser = $this->registry->get('browser');
        $rows = array();

        if (!$browser) {
            $load->library('browser');
            $browser = $this->registry->get('browser');
        }

        $load->helper('widgets');
        $widgets = new NecoWidget($this->registry, $this->Route);

        if ($full_tree) {

            $params = array(
                'landing_page'=>$session->get('landing_page'),
                'position'=>$position,
                'show_in_mobile'=>$browser->isMobile(),
                'show_in_desktop'=>!$browser->isMobile(),
                'full_tree'=>$full_tree
            );

            $rows = $widgets->getRows($params);
            foreach ($rows as $row) {
                if (!is_array($this->children) ) {
                    $this->children = array();
                }
                if (!is_array($this->widget) ) {
                    $this->widget = array();
                }
                if (isset($row['children']) && is_array($row['children']) && !empty($row['children'])) {
                    $this->children = array_merge($this->children, $row['children']);
                }
                if (isset($row['widget']) && is_array($row['widget']) && !empty($row['widget'])) {
                    $this->widget = array_merge($this->widget, $row['widget']);
                }
            }

            if ($session->has('object_type') || $session->has('object_id')) {
                if ($session->has('object_type')) $widgets->object_type = $session->get('object_type');
                if ($session->has('object_id')) $widgets->object_id = $session->get('object_id');

                $params['object_type'] = $session->get('object_type');
                $params['object_id'] = $session->get('object_id');
                $_rows = $widgets->getRows($params);

                foreach ($_rows as $row) {
                    if (isset($row['children']) && is_array($row['children']) && is_array($this->children) && !empty($row['children'])) {
                        $this->children = array_merge($this->children, $row['children']);
                    }
                    if (isset($row['widget']) && is_array($row['widget']) && is_array($this->widget) && !empty($row['widget'])) {
                        $this->widget = array_merge($this->widget, $row['widget']);
                    }
                }
            }
            if ($_rows) $rows = array_merge($rows, $_rows);
            $this->data['rows'][$position] = $rows;
        } else {
            foreach ($widgets->getWidgets($position, $app) as $k => $widget) {
                $settings = (array)unserialize($widget['settings']);
                if (isset($settings['route'])) {
                    if (($browser->isMobile() && $settings['showonmobile']) || (!$browser->isMobile() && $settings['showondesktop'])) {
                        if ($settings['autoload']) {
                            $row_id = str_replace('row_id=','',$settings['row_id']);
                            $col_id = str_replace('col_id=','',$settings['col_id']);

                            $rows[$row_id]['columns'][$col_id]['column'] = $settings['column'];
                            $rows[$row_id]['columns'][$col_id]['widgets'][$k] = $widget['name'];

                        }

                        $this->children[$widget['name']] = $settings['route'];
                        $this->widget[$widget['name']] = $widget;
                    }
                }
            }

            if ($session->has('object_type') || $session->has('object_id')) {
                //loading widgets just for manufacurers
                if ($session->has('object_type')) $widgets->object_type = $session->get('object_type');

                //loading widgets just for this manufacurer
                if ($session->has('object_id')) $widgets->object_id = $session->get('object_id');

                foreach ($widgets->getWidgets($position, $app) as $widget) {
                    $settings = (array)unserialize($widget['settings']);
                    if (isset($settings['route'])) {
                        if (($browser->isMobile() && $settings['showonmobile']) || (!$browser->isMobile() && $settings['showondesktop'])) {
                            if ($settings['autoload']) {
                                $row_id = str_replace('row_id=','',$settings['row_id']);
                                $col_id = str_replace('col_id=','',$settings['col_id']);

                                $rows[$row_id]['columns'][$col_id]['column'] = $settings['column'];
                                $rows[$row_id]['columns'][$col_id]['widgets'][$k] = $widget['name'];

                            }

                            $this->children[$widget['name']] = $settings['route'];
                            $this->widget[$widget['name']] = $widget;
                        }
                    }
                }
            }
            $this->data['rows'][$position] = $rows;
        }
    }

    protected function loadAssets($classname, $subfolder = null) {
        if (!$classname) return false;
        $filename = str_replace('/', '', str_replace('controller', '', strtolower($classname)));
        $this->_loadAssets($filename, $subfolder);
    }

    protected function _loadAssets($filename, $subfolder = null) {
        if (!$filename) return false;

        if (!$this->assetLoaded) {
            $this->registry->set('assetLoaded', array());
        } else {
            $assetLoaded = $this->registry->get('assetLoaded');
        }

        if (in_array($filename, $assetLoaded)) return false;
        array_push($assetLoaded, $filename);
        $this->registry->set('assetLoaded', $assetLoaded);

        $config = $this->registry->get('config');

        if (!isset($subfolder)) {
            $render_css_in_file = $config->get('config_render_css_in_file');
            $render_js_in_file = $config->get('config_render_js_in_file');
            $template = $config->get('config_template');
            if (!file_exists(DIR_TEMPLATE . $template . '/common/header.tpl')) $template = 'choroni';
            if (!file_exists(DIR_TEMPLATE . $template . '/common/header.tpl')) return false;
            $csspath = defined("CDN_CSS") ? CDN_CSS : HTTP_THEME_CSS;
            $jspath = defined("CDN_JS") ? CDN_JS : HTTP_THEME_JS;

            if (file_exists(DIR_TEMPLATE . $template . '/common/header.tpl')) {
                $csspath = str_replace("%theme%", $template, $csspath);
                $cssFolder = str_replace("%theme%", $template, DIR_THEME_CSS);

                $jspath = str_replace("%theme%", $template, $jspath);
                $jsFolder = str_replace("%theme%", $template, DIR_THEME_JS);
            } else {
                $csspath = str_replace("%theme%", "default", $csspath);
                $cssFolder = str_replace("%theme%", "default", DIR_THEME_CSS);

                $jspath = str_replace("%theme%", "default", $jspath);
                $jsFolder = str_replace("%theme%", "default", DIR_THEME_JS);
            }
        } else {
            $render_css_in_file = $config->get('config_'. strtolower($subfolder) .'_render_css_in_file');
            $render_js_in_file = $config->get('config_'. strtolower($subfolder) .'_render_js_in_file');
            $template = $config->get('config_'. strtolower($subfolder) .'_template');
            if (!file_exists(DIR_TEMPLATE . $template . '/common/header.tpl')) $template = 'default';
            if (!file_exists(DIR_TEMPLATE . $template . '/common/header.tpl')) return false;
            $csspath = defined("CDN_". strtoupper($subfolder) ."_CSS") ? constant("CDN_". strtoupper($subfolder) ."_CSS") : constant('HTTP_'. strtoupper($subfolder) .'_THEME_CSS');
            $jspath = defined("CDN_". strtoupper($subfolder) ."_JS") ? constant("CDN_". strtoupper($subfolder) ."_JS") : constant('HTTP_'. strtoupper($subfolder) .'_THEME_JS');

            if (file_exists(DIR_TEMPLATE . $template . '/common/header.tpl')) {
                $csspath = str_replace("%theme%", $template, $csspath);
                $cssFolder = str_replace("%theme%", $template, constant('DIR_'. strtoupper($subfolder) .'_THEME_CSS'));

                $jspath = str_replace("%theme%", $template, $jspath);
                $jsFolder = str_replace("%theme%", $template, constant('DIR_'. strtoupper($subfolder) .'_THEME_JS'));
            }
        }

        if (file_exists($cssFolder . $filename .'.css')) {
            if ($render_css_in_file) {
                $this->data['css'] .= file_get_contents($cssFolder . $filename .'.css');
            } else {
                $styles[$filename .'.css'] = array('media' => 'all', 'href' => $csspath . $filename .'.css');
            }
        }

        if (file_exists($jsFolder . $filename .'.js')) {
            if ($render_js_in_file) {
                $javascripts[$filename .'.js'] = $jsFolder . $filename .'.js';
            } else {
                $javascripts[$filename .'.js'] = $jspath . $filename .'.js';
            }
        }

        if (isset($styles)) $this->styles = array_merge($this->styles, $styles);
        if (isset($javascripts)) $this->javascripts = array_merge($this->javascripts, $javascripts);
    }
}