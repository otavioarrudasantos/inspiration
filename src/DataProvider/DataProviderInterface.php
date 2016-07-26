<?php
namespace Inspiration\DataProvider;

interface DataProviderInterface {

    public static function getFactory();

    public function getEntity();

    public function setEntity(\Inspiration\Database\Model $entity);

    public function getDataDriver();

    public function setDataDriver($dataDriver);

}