<?php
namespace Inspiration\DataProvider;

use Inspiration\Database\Model;
use Inspiration\Database\Connection;
use Inspiration\Database\DatabaseProvider;
use Inspiration\Database\DefaultRepository;

class DatabaseProviderFactory {

    public $databaseConfigDir = __DIR__ . '/../../../../config/';

    public $dataDriver;

    public $context;

    public function configure($entityDataProvider, $context){
        $this->context = $context;
        $entityDataProvider->setDataDriver($this->getDataDriver());

    }

    public function setContext($context){
        $this->context = $context;
    }

    public function getContext($context){
        
        return $this->context;
    }

    public function getDataDriver(){

        if(!isset($this->dataDriver)){
            $this->dataDriver = new Connection($this->databaseConfigDir. 'connection.php');
            $this->dataDriver->setContext($this->context);
            $this->dataDriver->connect();
        }

        return $this->dataDriver;
    }
}