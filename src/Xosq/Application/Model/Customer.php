<?php
namespace Xosq\Application\Model;

use Xosq\Inspiration\Database\Model;

class Customer extends Model{

    // public $dataProviderClass = 'Xosq\Application\DataProvider\Customer';
    
    private $id;

    public $name;

    public $age;
}