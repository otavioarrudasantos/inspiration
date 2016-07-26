<?php

namespace InspirationTest\Inspiration\Database;

use Inspiration\Database\DatabaseProvider;
use Inspiration\DataProvider\DatabaseProviderFactory;
use Inspiration\DataProvider\DataProviderInterface;

class TestableEntity extends \Inspiration\Database\Model
{
    
}

/**
 * Description of DatabaseProviderClass
 *
 * @author otavio
 */
class DatabaseProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testClassExists()
    {
        $this->assertTrue(class_exists(DatabaseProvider::class));
    }

    public function testGetFactory()
    {

        $this->assertInstanceOf(DatabaseProviderFactory::class, DatabaseProvider::getFactory());
    }

    public function testDatabaseProviderImplementsDataProviderInterface()
    {
        $this->assertInstanceOf(DatabaseProviderFactory::class, DatabaseProvider::getFactory());
    }

    public function testSetGetEntity()
    {
        $model = new TestableEntity();

        $dataProvider = new DatabaseProvider();

        $dataProvider->setEntity($model);

        $this->assertEquals($model, $dataProvider->getEntity());
    }

    public function testSetGetDataDriver()
    {
        $connection = new \Inspiration\Database\Connection();

        $dataProvider = new DatabaseProvider();

        $dataProvider->setDataDriver($connection);

        $this->assertEquals($connection, $dataProvider->getDataDriver());
    }

    public function testIsEntitySetWhenNotSet()
    {
        $dataProvider = new DatabaseProvider();
        $this->assertFalse($dataProvider->isEntitySet());
    }

    public function testIsEntitySetWhenSet()
    {
        $dataProvider = new DatabaseProvider();
        
        $model = new TestableEntity();
        $dataProvider->setEntity($model);
        
        $this->assertTrue($dataProvider->isEntitySet());
    }
}
