<?php
namespace Inspiration\Database;

class Model{

    public $entityName;

    public $dataProviderClass;

    public function getEntityName(){
        return $this->entityName;
    }

    public function setEntityName($entityName){
        $this->entityName = $entityName;
    }

    public function getAttributes(){

    }

    public function setAttributes(){

    }

    public function setDataProviderClass($dataProviderClass){
        $this->dataProviderClass = $dataProviderClass;
    }

        public function getDataProviderClass(){
        return $this->dataProviderClass;
    }
}