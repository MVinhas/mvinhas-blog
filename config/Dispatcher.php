<?php
namespace config;

class Dispatcher
{
    public static function dispatch()
    {
        $uri = self::getURI();
        $cont = new $uri->controller;
        $method = $uri->method;
        $arg = $uri->arg;
        $cont->$method($arg);
    }
    public static function metadata()
    {
        $uri = self::getURI();
        $split = explode("\\", $uri->controller);
        $controller = explode("Controller", $split[2]);

        $site = new \engine\SiteInfo();

        $_SESSION['page_title'] = $site->getName().' :: '.$controller[0];
    }
    private static function getURI()
    {
        if (filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL) === null)
            return false;
            
        $url = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        $ctrPos = isset($url[1]) ? $url[1] : null;
        $mtdPos = isset($url[2]) ? $url[2] : null;
        $argPos = isset($url[3]) ? $url[3] : null;

        isset($ctrPos) ? $ctrPos = preg_replace('/\?/', '', $ctrPos) : null;
        //check for controller
        $controller = !empty($ctrPos) ? "\controllers\\" . $ctrPos . 'Controller' : '\controllers\HomeController';
        //controller method
        $method = !empty($mtdPos) ? $mtdPos : 'index';

        //get argument
        $arg = !empty($argPos) ? $argPos : null;
        
        $uri = new \stdClass();
        $uri->controller = $controller;
        $uri->method = $method;
        $uri->arg = $arg;
        return $uri;
    }
}
