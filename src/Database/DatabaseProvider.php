<?php

namespace Inspiration\Database;

use Inspiration\DataProvider\DataProviderInterface;
use Inspiration\DataProvider\DatabaseProviderFactory;

class DatabaseProvider implements DataProviderInterface
{

    public static $factory;
    public $dataDriver;
    public $entity;

    public function getEntity()
    {
        return $this->entity;
    }

    public function setEntity(Model $entity)
    {
        $this->entity = $entity;
    }

    public function getDataDriver()
    {
        return $this->dataDriver;
    }

    public function setDataDriver($dataDriver)
    {
        $this->dataDriver = $dataDriver;
    }

    public function isEntitySet()
    {
        return isset($this->entity);
    }

    public static function getFactory()
    {
        if (!isset(self::$factory)) {
            self::$factory = new DatabaseProviderFactory();
            return self::$factory;
        }

        return self::$factory;
    }
}
