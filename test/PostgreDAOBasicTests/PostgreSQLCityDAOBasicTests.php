<?php

include_once('phpreport/model/vo/CityVO.php');
include_once('phpreport/model/dao/CityDAO/PostgreSQLCityDAO.php');

class PostgreSQLCityDAOBasicTests extends PHPUnit_Framework_TestCase
{

    protected $dao;
    protected $testObjects;

        protected function setUp()
        {

        $this->dao = new PostgreSQLCityDAO();

        $this->testObjects[0] = new CityVO();
        $this->testObjects[0]->setName("New New York");
        $this->testObjects[0]->setId(-1);

    }

    protected function tearDown()
    {
        foreach($this->testObjects as $testObject)
            $this->dao->delete($testObject);

    }

        public function testCreate()
        {

        $this->assertEquals($this->dao->create($this->testObjects[0]), 1);

        }

    public function testDelete()
        {

        $this->dao->create($this->testObjects[0]);

        $this->assertEquals($this->dao->delete($this->testObjects[0]), 1);

        }

    public function testIdCreate()
        {

        $this->dao->create($this->testObjects[0]);

        $this->testObjects[1] = clone $this->testObjects[0];

        $this->testObjects[1]->setName("Old New York");

        $this->dao->create($this->testObjects[1]);

        $this->assertGreaterThan($this->testObjects[0]->getId(), $this->testObjects[1]->getId());

        }

    public function testGetById()
    {

        $this->dao->create($this->testObjects[0]);

        $read = $this->dao->getById($this->testObjects[0]->getId());

        $this->assertEquals($read, $this->testObjects[0]);

    }

    public function testGetByIdNonExistent()
    {

        $read = $this->dao->getById(0);

        $this->assertNull($read);

    }


    /**
         * @expectedException SQLIncorrectTypeException
         */
    public function testGetByIdInvalid()
    {

        $read = $this->dao->getById("zoidberg");

    }

    public function testGetAll()
        {

        $this->dao->create($this->testObjects[0]);

        $this->testObjects[1] = clone $this->testObjects[0];

        $this->testObjects[1]->setName("Old New York");

        $this->dao->create($this->testObjects[1]);

        $this->testObjects[2] = clone $this->testObjects[0];

        $this->testObjects[2]->setName("The Wong Place");

        $this->dao->create($this->testObjects[2]);

        $this->assertEquals($this->testObjects, $this->dao->getAll());

        }

    public function testDeleteNonExistent()
    {

        $this->assertEquals($this->dao->delete($this->testObjects[0]), 0);

    }

    public function testGetByIdAfterDelete()
    {

        $this->dao->create($this->testObjects[0]);

        $this->dao->delete($this->testObjects[0]);

        $read = $this->dao->getById($this->testObjects[0]->getId());

        $this->assertNull($read);

    }

    public function testUpdate()
    {

        $this->dao->create($this->testObjects[0]);

        $this->testObjects[0]->setName("Old New York");

        $this->assertEquals($this->dao->update($this->testObjects[0]), 1);

    }

    public function testGetByIdAfterUpdate()
    {

        $this->dao->create($this->testObjects[0]);

        $this->testObjects[0]->setName("Old New York");

        $this->dao->update($this->testObjects[0]);

        $read = $this->dao->getById($this->testObjects[0]->getId());

        $this->assertEquals($read, $this->testObjects[0]);

    }

    public function testUpdateNonExistent()
    {

        $this->assertEquals($this->dao->update($this->testObjects[0]), 0);

    }

}
?>
