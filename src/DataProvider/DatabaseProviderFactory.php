<?php

namespace Inspiration\DataProvider;

use Inspiration\Database\Connection;

class DatabaseProviderFactory
{

    public $databaseConfig;
    public $dataDriver;
    public $context;

    function getDatabaseConfig()
    {
        return $this->databaseConfig;
    }

    function setDatabaseConfig($databaseConfig)
    {
        $this->databaseConfig = $databaseConfig;
    }

    public function configure($entityDataProvider, $config = null)
    {
        $entityDataProvider->setDataDriver($this->getDataDriver($config));
    }

    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    public function getContext()
    {

        return $this->context;
    }

    public function getDataDriver($config = null)
    {

        if (!isset($this->dataDriver)) {
            $this->databaseConfig = isset($config) ? $config : $this->databaseConfig;
            $this->dataDriver = new Connection($this->databaseConfig);
            $this->dataDriver->setContext($this->getContext());
            $this->dataDriver->connect();
        }

        return $this->dataDriver;
    }
}
