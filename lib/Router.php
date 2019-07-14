<?php
/*******************************
 * Routing class that parses the
 * incoming url and routes to the
 * correct controller/action
 *
 * Author: Nick Orr
 * norr@ida.net
 * http://onyx.homelinux.net
 * Created: 6/23/09
 * Updated: 2/2/12 - Added matching for get strings
 ******************************/

class Router {
    private static $_basepath = '';
    private static $_routes = array();

    private function __construct() {
    }

    private function __clone() {
    }

    public static function SetBasePath($path) {
        self::$_basepath = $path;
    }

    public static function AddRoute($request, $controller, $action) {
        self::$_routes[$request] = array($controller, $action);
    }

    public static function MatchRoute() {
        $url = strncmp($_SERVER['REQUEST_URI'], self::$_basepath, strlen(self::$_basepath)) === 0?substr($_SERVER['REQUEST_URI'], strlen(self::$_basepath)):$_SERVER['REQUEST_URI'];
        if ((strripos($url, '/') == strlen($url) - 1) && (strlen($url) > 1)) {
            //ends in slash
            $url = substr($url, 0, strlen($url) - 1);
            header('Location: ' . $url);
            exit;
        }
        //if (array_key_exists($url, self::$_routes)) {
        foreach (array_keys(self::$_routes) as $route) {
            $orig_route = $route;
            $route = explode('/', $route);
            foreach ($route as &$key) {
                if (0 === strpos($key, ':')) {
                    $key = '.+';
                }
            }
            $route = implode('/', $route);
            if (preg_match('/^' . str_replace('/', '\/', $route) . '(\?.*)?' . '$/', $url)) {
                //still need to assign the vars
                $route = explode('/', $orig_route);
                $url = explode('/', $url);
                for ($i = 0; $i < count($url); $i++) {
                    if ($route[$i] != $url[$i]) {
                        define(substr($route[$i], 1), $url[$i]);
                    }
                }
                list($controller, $action) = self::$_routes[$orig_route];
                require_once $controller . '.php';
                if (is_callable(array($controller, $action))) {
                    $controlObject = new $controller();
                    $controlObject->$action();
                    exit;
                }
            } 
        }
        throw new Exception('Unable to match route: ' . $_SERVER['REQUEST_URI']);
        exit;
        //Logger::LogMessage('Unable to match route: ' . $_SERVER['REQUEST_URI']);
    }
}
?>
