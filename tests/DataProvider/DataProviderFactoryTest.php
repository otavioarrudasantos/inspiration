<?php

namespace InspirationTest\DataProvider;

use Inspiration\DataProvider\DataProviderFactory;
use Inspiration\Database\DatabaseProvider;
use \Inspiration\Database\Model;

class TestableDataProvider extends DatabaseProvider
{
    
}

class TestableEntityWithDataProviderClass extends Model
{

    public function __construct()
    {
        $this->dataProviderClass = 'InspirationTest\DataProvider\TestableDataProvider';
    }
}

class TestableEntityWithoutDataProviderClass extends Model
{
    
}

class DataProviderFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetContext()
    {
        $context = 'Test';

        $dataProviderFactory = new DataProviderFactory();

        $dataProviderFactory->setContext($context);

        $this->assertEquals($context, $dataProviderFactory->getContext());
    }

    public function testSetGetDataProviderConfiguration()
    {
        $config = [
            'test' => [
                'driver' => 'sqlite',
                'dbname' => '/tmp/testTest.db'
            ]
        ];

        $dataProviderFactory = new DataProviderFactory();
        $dataProviderFactory->setDataProviderConfiguration($config);

        $this->assertArraySubset($config, $dataProviderFactory->getDataProviderConfiguration());
    }

    public function testSetCorrectDefaultProvider()
    {
        $defaultDataProvider = DatabaseProvider::class;

        $dataProviderFactory = new DataProviderFactory();

        $dataProviderFactory->setDefaultProvider($defaultDataProvider);

        $this->assertInstanceOf($defaultDataProvider, $dataProviderFactory->defaultDataProvider);
    }

    /**
     * @expectedException Exception
     */
    public function testSetIncorrectDefaultProvider()
    {
        $defaultDataProvider = 'Inspiration\Database\Provider';

        $dataProviderFactory = new DataProviderFactory();

        $dataProviderFactory->setDefaultProvider($defaultDataProvider);
    }

    public function testGetEntityProviderWhenProviderClassIsSetAndDefaultProviderIsNot()
    {
        $entity = new TestableEntityWithDataProviderClass();

        $dataProviderFactory = new DataProviderFactory();


        $this->assertInstanceOf($entity->getDataProviderClass(), $dataProviderFactory->getEntityProvider($entity));
    }

    public function testGetEntityProviderWhenProviderClassIsSetAndDefaultProviderIsSet()
    {
        $entity = new TestableEntityWithDataProviderClass();

        $dataProviderFactory = new DataProviderFactory();

        $dataProviderFactory->setDefaultProvider(DatabaseProvider::class);

        $this->assertInstanceOf($entity->getDataProviderClass(), $dataProviderFactory->getEntityProvider($entity));
    }

    public function testGetEntityProviderWhenProviderClassIsNotSetAndDefaultProviderIsSet()
    {
        $entity = new TestableEntityWithoutDataProviderClass();

        $dataProviderFactory = new DataProviderFactory();

        $dataProviderFactory->setDefaultProvider(DatabaseProvider::class);

        $this->assertInstanceOf(DatabaseProvider::class, $dataProviderFactory->getEntityProvider($entity));
    }

    /**
     * @expectedException Exception
     */
    public function testGetEntityProviderWhenProviderClassIsNotSetAndDefaultProviderIsNotSet()
    {
        $entity = new TestableEntityWithoutDataProviderClass();

        $dataProviderFactory = new DataProviderFactory();

        $this->assertInstanceOf(DatabaseProvider::class, $dataProviderFactory->getEntityProvider($entity));
    }

    public function testGetDataProviderWithEntitySet()
    {
        $entity = new TestableEntityWithDataProviderClass();

        $dataProviderFactory = new DataProviderFactory();
        $dataProviderFactory->setContext('test');
        $dataProviderFactory->setDefaultProvider(DatabaseProvider::class);

        $dataProviderFactory->setDataProviderConfiguration([
            'test' => [
                'driver' => 'sqlite',
                'dbname' => '/tmp/testTest.db'
            ]
        ]);
        $this->assertInstanceOf($entity->getDataProviderClass(), $dataProviderFactory->get('InspirationTest\DataProvider\TestableEntityWithDataProviderClass'));
    }

    public function testGetDataProviderReturnsProviderContainingSameEntity()
    {
        $entity = new TestableEntityWithDataProviderClass();

        $dataProviderFactory = new DataProviderFactory();
        $dataProviderFactory->setContext('test');
        $dataProviderFactory->setDefaultProvider(DatabaseProvider::class);

        $dataProviderFactory->setDataProviderConfiguration([
            'test' => [
                'driver' => 'sqlite',
                'dbname' => '/tmp/testTest.db'
            ]
        ]);
        $this->assertInstanceOf(TestableEntityWithDataProviderClass::class, $dataProviderFactory->get('InspirationTest\DataProvider\TestableEntityWithDataProviderClass')->getEntity());
    }

    public function testGetDataProviderReturnsDefaultProviderContainingSameEntity()
    {
        $entity = new TestableEntityWithoutDataProviderClass();

        $dataProviderFactory = new DataProviderFactory();
        $dataProviderFactory->setContext('test');
        $dataProviderFactory->setDefaultProvider(DatabaseProvider::class);

        $dataProviderFactory->setDataProviderConfiguration([
            'test' => [
                'driver' => 'sqlite',
                'dbname' => '/tmp/testTest.db'
            ]
        ]);
        $this->assertInstanceOf(TestableEntityWithoutDataProviderClass::class, $dataProviderFactory->get('InspirationTest\DataProvider\TestableEntityWithoutDataProviderClass')->getEntity());
    }
}
