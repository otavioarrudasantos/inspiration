<?php
namespace Inspiration\DataProvider;

use Inspiration\Database\Model;
use Inspiration\Database\Connection;
use Inspiration\Database\DatabaseProvider;
use Inspiration\Database\DefaultRepository;

class DataProviderFactory{

    public $context;

    public $defaultDataProvider;

    public $entity;

    public function get($entity){
        if(!class_exists($entity)){
            throw new \Exception("Entity: " . $entity . ' not found');
        }

        $this->entity = new $entity();

        $entityDataProvider = $this->getEntityProvider($this->entity);

        $entityDataProvider::getFactory()->configure($entityDataProvider, $this->context);

        $entityDataProvider->setEntity($entity);

        return $entityDataProvider;
    }

    public function setDefaultProvider($dataProvider=null){
        if(isset($dataProvider) && class_exists($dataProvider)){
            $this->defaultProvider = new $dataProvider();
        }

        if(!class_exists($dataProvider)){
            throw new \Exception("Data Provider Class don't exists");
        }

        
    }

    public function setContext($context){
        $this->context = $context;
    }

    public function getContext($context){
        
        return $this->context;
    }

    public function getEntityProvider($entity){
        $dataProviderClass = $entity->getDataProviderClass();

        if(!isset($dataProviderClass)){
            return $this->defaultProvider;

        }

        if(class_exists($dataProviderClass)){
            return new $dataProviderClass();
        }

        throw new \Exception("Data Provider class $dataProviderClass doesn't exists.");
        
     }
}