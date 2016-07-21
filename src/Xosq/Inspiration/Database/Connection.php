<?php
namespace Xosq\Inspiration\Database;

class Connection {

    public function __construct($configFile){
        if(!file_exists($configFile)){
            throw new \Exception("Connection configuration not found at: ". $configFile);
                    
        }
        $this->config = include $configFile;
    }

    public $config;
    
    public $driver;

    public $context;

    public $conectionData;

    public function connect(){
        if(!array_key_exists($this->context, $this->config)){
            throw new \Exception("Settings not found by '$this->context' context");
        }

        $contextSettings = $this->config[$this->context];

        $dsn = $contextSettings['driver'].':'.'host='.$contextSettings['host'].';port='.$contextSettings['port'].';dbname='.$contextSettings['dbname'];
        
        $this->driver = new \PDO($dsn, $contextSettings['user'], $contextSettings['password'] );
    }

    public function setContext($context){
        $this->context = $context;
    }

    public function getContext(){
        
        return $this->context;
    }

    public function makeDSN(){
        



        return $dsn;
    }
}