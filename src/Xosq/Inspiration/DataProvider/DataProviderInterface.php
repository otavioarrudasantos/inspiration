<?php
namespace Xosq\Inspiration\DataProvider;

interface DataProviderInterface {

    public static function getFactory();

    public function getEntity();

    public function setEntity($entity);

    public function getDataDriver();

    public function setDataDriver($dataDriver);

    public function findAll();
 
    public function find($id);

    public function insert($data);

    public function update($id, $data);

    public function delete($id);
}