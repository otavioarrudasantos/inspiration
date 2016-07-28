<?php

namespace Inspiration\DataProvider;

class DataProviderFactory
{

    public $context;
    public $defaultDataProvider;
    public $entity;
    public $dataProviderConfiguration;

    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    public function getContext()
    {

        return $this->context;
    }

    public function setDefaultProvider($dataProvider)
    {
        if (!class_exists($dataProvider)) {
            throw new \Exception("Data Provider Class doesn't exists");
        }

        $this->defaultDataProvider = new $dataProvider();
        return $this;
    }

    function getDataProviderConfiguration()
    {
        return $this->dataProviderConfiguration;
    }

    function setDataProviderConfiguration($dataProviderConfiguration)
    {
        $this->dataProviderConfiguration = $dataProviderConfiguration;
        return $this;
    }

    public function getEntityProvider($entity)
    {
        $dataProviderClass = $entity->getDataProviderClass();

        if (class_exists($dataProviderClass)) {
            return new $dataProviderClass();
        }

        if (isset($this->defaultDataProvider)) {
            return $this->defaultDataProvider;
        }

        throw new \Exception("Data Provider class $dataProviderClass doesn't exists.");
    }

    public function get($entity)
    {
        if (!class_exists($entity)) {
            throw new \Exception("Entity: " . $entity . ' not found');
        }

        $this->entity = new $entity();

        $entityDataProvider = $this->getEntityProvider($this->entity);

        $entityDataProvider::getFactory()->setContext($this->getContext())
            ->configure($entityDataProvider, $this->getDataProviderConfiguration());

        $entityDataProvider->setEntity($this->entity);

        return $entityDataProvider;
    }
}
