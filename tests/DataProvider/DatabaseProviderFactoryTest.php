<?php

namespace InspirationTest\DataProvider;

use Inspiration\DataProvider\DatabaseProviderFactory;

class DatabaseProviderFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetDatabaseConfig()
    {
        $config = [
            'test' => [
                'driver' => 'sqlite',
                'dbname' => '/tmp/testTest.db'
            ]
        ];
        $databaseProviderFactory = new DatabaseProviderFactory();
        $databaseProviderFactory->setDatabaseConfig($config);

        $this->assertArraySubset($config, $databaseProviderFactory->getDatabaseConfig());
    }

    public function testSetGetContext()
    {
        $context = 'test';
        $databaseProviderFactory = new DatabaseProviderFactory();
        $databaseProviderFactory->setContext($context);

        $this->assertEquals($context, $databaseProviderFactory->getContext());
    }

    /**
     * @expectedException Exception
     */
    public function testGetDataDriverWithoutAnyConfiguration()
    {
        $databaseProviderFactory = new DatabaseProviderFactory();
        $databaseProviderFactory->getDataDriver();
    }

    /**
     * @expectedException Exception
     */
    public function testGetDataDriverWithoutConfig()
    {
        $databaseProviderFactory = new DatabaseProviderFactory();
        $databaseProviderFactory->setContext('test');
        $databaseProviderFactory->getDataDriver();
    }

    /**
     * @expectedException Exception
     */
    public function testGetDataDriverWhenConfigParameterGivenAndContextIsNotSet()
    {
        $config = [
            'test' => [
                'driver' => 'sqlite',
                'dbname' => '/tmp/testTest.db'
            ]
        ];

        $databaseProviderFactory = new DatabaseProviderFactory();

        $databaseProviderFactory->getDataDriver($config);
    }

    public function testGetDataDriverWhenConfigParameterAndContextGiven()
    {
        $config = [
            'test' => [
                'driver' => 'sqlite',
                'dbname' => '/tmp/testTest.db'
            ]
        ];

        $databaseProviderFactory = new DatabaseProviderFactory();
        $databaseProviderFactory->setContext('test');
        $this->assertInstanceOf(
            \Inspiration\Database\Connection::class, $databaseProviderFactory->getDataDriver($config)
        );
    }

    /**
     * @expectedException Exception
     */
    public function testConfigureWithoutConfigurationAndContext()
    {

        $databaseProviderFactory = new DatabaseProviderFactory();
        $databaseProviderFactory->configure(new TestableDataProvider());
    }

    /**
     * @expectedException Exception
     */
    public function testConfigureWithoutContext()
    {

        $config = [
            'test' => [
                'driver' => 'sqlite',
                'dbname' => '/tmp/testTest.db'
            ]
        ];
        $databaseProviderFactory = new DatabaseProviderFactory();
        $databaseProviderFactory->configure(new TestableDataProvider(), $config);
    }

    /**
     * @expectedException Exception
     */
    public function testConfigureWithoutConfiguration()
    {

        $databaseProviderFactory = new DatabaseProviderFactory();
        $databaseProviderFactory->setContext('test');
        $databaseProviderFactory->configure(new TestableDataProvider());
    }

    public function testConfigureGivenContextAndConfiguration()
    {

        $config = [
            'test' => [
                'driver' => 'sqlite',
                'dbname' => '/tmp/testTest.db'
            ]
        ];

        $databaseProvider = new TestableDataProvider();
        $databaseProviderFactory = new DatabaseProviderFactory();
        $databaseProviderFactory->setContext('test');
        $databaseProviderFactory->configure($databaseProvider, $config);

        $this->assertInstanceOf(
            \Inspiration\Database\Connection::class, $databaseProvider->getDataDriver()
        );
    }
}
