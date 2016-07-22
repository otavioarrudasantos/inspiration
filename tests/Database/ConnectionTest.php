<?php
namespace XosqTest\Inspiration\Database;

use PHPUnit\Framework\TestCase;
use Xosq\Inspiration\Database\Connection;

class ConnectionTest extends TestCase{

    protected $databaseConfigDir = __DIR__ . '/../../../../config/';

    protected $configParameters = [
        'development' => [
            'host' => '0.0.0.0',
            'driver' => 'mysql',
            'port' => 3306,
            'user' => 'root',
            'password' => 123,
            'dbname' => 'testDev'
        ],
        'production' => [
            'host' => '0.0.0.0',
            'driver' => 'mysql',
            'port' => 3306,
            'user' => 'root',
            'password' => 123,
            'dbname' => 'testProduction'
        ],
        'test' => [
            'driver' => 'sqlite',
            'dbname' => '/tmp/testTest.db'
        ]
    ];

    public function testConnectionClassExists(){
        $this->assertTrue(class_exists(Connection::class));
    }

    public function testCreateConnectionObject(){
        $connection = new Connection();

        $this->assertInstanceOf(Connection::class, $connection);
    }

    public function testConfigAttributeIssetGivenConfigFilePath(){
        $connection = new Connection($this->databaseConfigDir.'connection.php');

        $this->assertTrue(null !== $connection->getConfig());
    }

    public function testConfigAttributeIssetGivenConfigArray(){
        $connection = new Connection($this->configParameters);

        $this->assertTrue(null !== $connection->getConfig());
    }
    /**
     * @expectedException Exception
     *
     */
    public function testThrowExceptionIfInvalidConfigFilePathGiven(){
        $invalidPath = 'invalid/path/';
        $connection = new Connection($invalidPath);
    }

    public function testCorrectDsnGenerationGivenConfigAndContext(){
        $correctDsn = "mysql:host=0.0.0.0;port=3306;dbname=testDev";

        $connection = new Connection($this->configParameters);
        $connection->setContext('development');

        $this->assertEquals($correctDsn, $connection->getDsn());
    }

    public function testCorrectDsnGenerationGivenSqliteConfig(){
        $correctDsn = "sqlite:/tmp/testTest.db";

        $connection = new Connection($this->configParameters);
        $connection->setContext('test');

        $this->assertEquals($correctDsn, $connection->getDsn());
    }

    public function testRetrieveParametersFromUndefinedContext(){
        $context = 'undefinedContext';

        $connection = new Connection();
        $connection->setContext($context);
        $connection->setConfig($this->configParameters);

        $this->assertEquals([], $connection->getConfigFromContext());
        
    }

    public function testRetrieveCorrectParametersFromCorrectContext(){
        $context = 'development';
        $expectedParameters = [
            'host' => '0.0.0.0',
            'driver' => 'mysql',
            'port' => 3306,
            'user' => 'root',
            'password' => 123,
            'dbname' => 'testDev'
        ];

        $connection = new Connection();
        $connection->setConfig($this->configParameters);
        $connection->setContext($context);

        $this->assertArraySubset($expectedParameters, $connection->getConfigFromContext());
    }

    /**
     * @expectedException Exception
    */
    public function testConnectWithoutAnyConfiguration(){
        $connection = new Connection();
        $connection->connect();
    }

    /**
     * @expectedException Exception
    */
    public function testConnectWithCorrectConfigButWithoutContext(){
        $connection = new Connection($this->configParameters);
        $connection->connect();
    }

    /**
     * @expectedException Exception
    */
    public function testConnectFailureWhenWrongConfigGivenAndCorrectContext(){
        $wrongParameters = [];
        $connection = new Connection($wrongParameters);
        $connection->setContext('test');
        $connection->connect();
    }

    /**
     * @expectedException Exception
    */
    public function testConnectFailureWhenCorrectConfigGivenAndWrongContext(){
        $wrongContext = 'wrong';
        $connection = new Connection($this->configParameters);
        $connection->setContext($wrongContext);
        $connection->connect();   
    }

    /**
     * @expectedException \PDOException
    */
    public function testConnectFailureWithWrongDbConfig(){
        $wrongDbConfig = [
            'test' => [
                'host' => 'localhost',
                'driver' => 'mysql',
            ]
        ];

        $connection = new Connection($wrongDbConfig);
        $connection->setContext('test');
        $connection->connect();   
    }

    public function testConnect(){
        
        $connection = new Connection($this->configParameters);
        $connection->setContext('test');
        $connection->connect();   

        $this->assertInstanceOf(\PDO::class, $connection->getDriver());
    }
}