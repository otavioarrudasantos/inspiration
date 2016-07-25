<?php

namespace InspirationTest\Inspiration\Database;

use \Inspiration\Database\Model;

class TestableModel extends Model
{

    private $id;
    protected $name;
    protected $age;
    public $job;

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function getAge()
    {
        return $this->age;
    }

    function getJob()
    {
        return $this->job;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function setAge($age)
    {
        $this->age = $age;
    }

    function setJob($job)
    {
        $this->job = $job;
    }
}

class TestableModelWithoutGetterSetter extends Model
{

    protected $id;

}

/**
 * Description of ModelTest
 *
 * @author otavio
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{

    public function testModelClassExists()
    {
        $this->assertTrue(class_exists(Model::class));
    }

    public function testCreateModel()
    {
        $model = new TestableModel();

        $this->isInstanceOf($model, Model::class);
    }

    public function testGetEntityName()
    {

        $model = new TestableModel();

        $entityName = 'Customer';

        $model->entityName = $entityName;

        $this->assertEquals($entityName, $model->getEntityName());
    }

    public function testSetEntityName()
    {

        $model = new TestableModel();
        $entityName = 'Customer';

        $model->setEntityName($entityName);

        $this->assertEquals($entityName, $model->getEntityName());
    }

    public function testGetPropertiesMethodGivenEmptyPropertiesModelObject()
    {
        $model = new TestableModel();

        $properties = Model::getProperties($model);

        $this->assertArraySubset(['id' => '', 'name' => '', 'age' => '', 'job' => ''], $properties);
    }

    public function testGetPropertiesMethodGivenPropertiesModelObject()
    {
        $model = new TestableModel();

        $model->setId(1);
        $model->setName('Inspiration');
        $model->setAge(0);
        $model->setJob('Developer');

        $properties = Model::getProperties($model);

        $this->assertArraySubset(['id' => 1, 'name' => 'Inspiration', 'age' => 0, 'job' => 'Developer'], $properties);
    }

    public function testSetPropertiesWhenEmptySetGiven()
    {
        $model = new TestableModel();
        Model::setProperties($model, []);


        $this->assertArraySubset(['id' => '', 'name' => '', 'age' => '', 'job' => ''], Model::getProperties($model));
    }

    public function testSetPropertiesWhenFilledSetGiven()
    {
        $set = ['id' => 1, 'name' => 'Inspiration', 'age' => 0, 'job' => 'Developer'];

        $model = new TestableModel();
        Model::setProperties($model, $set);

        $this->assertArraySubset($set, Model::getProperties($model));
    }

    public function testSetPropertiesWhenWrongPropertyNameGiven()
    {
        $set = ['id' => 1, 'wrongProperty' => 'test'];

        $model = new TestableModel();
        Model::setProperties($model, $set);

        $this->assertArraySubset(['id' => 1, 'name' => '', 'age' => '', 'job' => ''], Model::getProperties($model));
    }

    /**
     * @expectedException ReflectionException
     */
    public function testGetPropertiesWithoutGetter()
    {

        $model = new TestableModelWithoutGetterSetter();
        Model::getProperties($model);
    }

    /**
     * @expectedException ReflectionException
     */
    public function testSetPropertiesWithoutSetter()
    {

        $model = new TestableModelWithoutGetterSetter();

        $set = ['id' => 1];

        Model::setProperties($model, $set);
    }
}
