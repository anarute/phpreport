<?php

include_once('phpreport/model/vo/AreaHistoryVO.php');

class AreaHistoryVOTests extends PHPUnit_Framework_TestCase
{

    protected $VO;

    protected function setUp()
        {

        $this->VO = new AreaHistoryVO();

    }

        public function testNew()
        {

        $this->assertNotNull($this->VO);

        }

    public function testIdField()
        {

        $this->VO->setId(1);

        $this->assertEquals($this->VO->getId(), 1);

        $this->VO->setId(2);

        $this->assertEquals($this->VO->getId(), 2);

        }

    public function testAreaIdField()
        {

        $this->VO->setAreaId(2);

        $this->assertEquals($this->VO->getAreaId(), 2);

        $this->VO->setAreaId(4);

        $this->assertEquals($this->VO->getAreaId(), 4);

        }

    public function testInitDateField()
        {

        $this->VO->setInitDate(date_create('1999-12-31'));

        $this->assertEquals($this->VO->getInitDate(), date_create('1999-12-31'));

        $this->VO->setInitDate(date_create('2999-12-31'));

        $this->assertEquals($this->VO->getInitDate(), date_create('2999-12-31'));

        }

    public function testEndDateField()
        {

        $this->VO->setEndDate(date_create('1999-12-31'));

        $this->assertEquals($this->VO->getEndDate(), date_create('1999-12-31'));

        $this->VO->setEndDate(NULL);

        $this->assertEquals($this->VO->getEndDate(), NULL);

        }

    public function testUserIdField()
        {

        $this->VO->setUserId(2);

        $this->assertEquals($this->VO->getUserId(), 2);

        $this->VO->setUserId(45);

        $this->assertEquals($this->VO->getUserId(), 45);

        }

}
?>
