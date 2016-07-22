<?php
namespace Xosq\Inspiration\DataProvider;

use Xosq\Inspiration\Database\Model;
use Xosq\Inspiration\Database\Connection;
use Xosq\Inspiration\Database\DatabaseProvider;
use Xosq\Inspiration\Database\DefaultRepository;

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