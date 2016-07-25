<?php

namespace Inspiration\Database;

class Model
{

    public $entityName;

    public function getEntityName()
    {
        return $this->entityName;
    }

    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;
    }

    public static function getProperties(Model $model)
    {
        $properties = [];

        $reflection = new \ReflectionClass($model);
        $properties = $reflection->getProperties();

        foreach ($properties as $reflectionProperty) {
            $reflectionMethod = new \ReflectionMethod(
                get_class($model), 'get' . ucfirst($reflectionProperty->name)
            );
            $value = $reflectionMethod->invoke($model);

            $properties[$reflectionProperty->name] = $value;
        }

        return $properties;
    }

    public static function setProperties(Model $model, Array $properties)
    {
        $reflection = new \ReflectionClass($model);


        foreach ($properties as $propertyName => $value) {
            try {
                $reflectionProperty = $reflection->getProperty($propertyName);
            } catch (\ReflectionException $ex) {
                continue;
            }

            $reflectionMethod = new \ReflectionMethod(
                get_class($model), 'set' . ucfirst($reflectionProperty->name)
            );
            
            $value = $reflectionMethod->invoke($model, $value);
        }
    }

    public function setDataProviderClass($dataProviderClass)
    {
        $this->dataProviderClass = $dataProviderClass;
    }

    public function getDataProviderClass()
    {
        return $this->dataProviderClass;
    }
}
