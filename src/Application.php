<?php
namespace Inspiration\Rest;

use Inspiration\DataProvider\DataProviderFactory;

class Application {

	public static $configDir = __DIR__ . '/../../../../config/';

    public $applicationConfig;
	public $requestedURI;
	public $method;
	public $routes;
    public $controllers;
    public $genericRoute;
    public $matchedRoute;

    /*TODO responseStrategy*/
    public $responseStrategy;

    public $dataProviderFactory;

	public static function load(){
		try{
            $application = new Application();

			$application->requestURI = $_SERVER['REQUEST_URI'];

			$application->method = $_SERVER['REQUEST_METHOD'];

            $application->setApplicationConfig();

            $application->setRoutesConfig();

            $application->createDataProviderFactory();
			
			$application->parseRequestURI();
            
            $application->buildGenericRoute();
            
            $application->matchRoute();

            $application->run();

		}catch (\Exception $ex){
            echo "erro: " . $ex->getMessage();
		}

	}

    public function setApplicationConfig($config=null){
        if(isset($config)){
            $this->applicationConfig = $config;
            return;
        }

        if(!file_exists(self::$configDir . 'application_config.php')){
            throw new Exception("Application configuration not found in path: ". self::$configDir . 'application_config.php');
        }

        $this->applicationConfig = include self::$configDir . 'application_config.php' ;
    }

    public function setRoutesConfig($config=null){
        if(isset($config)){
            $this->routes = $config;
            return;
        }

        if(!file_exists(self::$configDir . 'routes.php')){
            throw new Exception("Routes configuration not found in path: ". self::$configDir . 'routes.php');
        }

        $this->routes = include self::$configDir . 'routes.php' ;
    }
    

    public function createDataProviderFactory(){
        $this->dataProviderFactory = new DataProviderFactory();
        $this->dataProviderFactory->setContext($this->applicationConfig['serverContext']);

        $this->dataProviderFactory->setDefaultProvider($this->applicationConfig['defaultDataProvider']);
    }

    public function getDataProviderFactory(){
        return $this->dataProviderFactory;
    }

    public function parseRequestURI(){
        $regex = '#/((?P<controller>\w+)/?(?P<value>[^/]*))+#';
        $r = preg_match_all($regex, $this->requestURI, $matches);
        $this->controllers = array_combine($matches['controller'], $matches['value']);
    }

    public function buildGenericRoute(){
        $genericRoute = '';
        foreach ($this->controllers as $controllerName => $value) {
            $genericRoute .= '/' . $controllerName;

            if(strlen($value)){
                $genericRoute .= '/:id';
            }
        }

        $this->genericRoute = $genericRoute;
    }

    public function matchRoute(){
        $this->matchedRoute = $this->routes[$this->genericRoute][$this->method];

        if(!$this->matchedRoute){
            throw new \Exception("Route not found");
        }
    }

    public function run(){
        list($controller, $method) = explode(':',$this->matchedRoute);
        
        $controller = new $controller();
        $controller->setApplication($this);
        
        call_user_func([$controller, $method]);
    }
}