<?php

use ExampleEnums\InvalidEnum;
use ExampleEnums\TestEnum;
use PHPUnit\Framework\TestCase;

class EnumTest extends TestCase
{

    public function testInvalidEnum()
    {
        $this->expectException("\LogicException");
        InvalidEnum::toArray(); //Actually thrown in '_getCache'. Its called from every method...
    }

    public function testToArray()
    {
        $this->assertSame(
            [
                'North' => 0,
                'South' => 1,
                'East' => 2,
                'West' => 3,
            ],
            TestEnum::toArray()
        );
    }

    public function testGetName()
    {
        $this->assertSame(
            "North",
            TestEnum::getName(0)
        );

        $this->assertNotSame(
            "north",
            TestEnum::getName(0)
        );


        $this->expectException("\InvalidArgumentException");
        TestEnum::getName(4);
    }

    public function testGetValue()
    {
        $this->assertSame(
            0,
            TestEnum::getValue("North")
        );

        $this->assertSame(
            0,
            TestEnum::getValue("north",false)
        );

        $this->expectException("\InvalidArgumentException");
        TestEnum::getValue("north");
    }

    public function testGetValues()
    {
        $this->assertSame(
            [0,1,2,3],
            TestEnum::getValues()
        );
    }

    public function testGetNames()
    {
        $this->assertSame(
            [
                'North',
                'South',
                'East',
                'West'
            ],
            TestEnum::getNames()
        );

        $this->assertSame(
            [
                'north',
                'south',
                'east',
                'west'
            ],
            TestEnum::getNames(false)
        );
    }

    public function testIsValidName()
    {
        $this->assertTrue(
            TestEnum::isValidName("North")
        );

        $this->assertTrue(
            TestEnum::isValidName("north", false)
        );

        $this->assertNotTrue(
            TestEnum::isValidName("north")
        );

        $this->assertTrue(
            TestEnum::isValidName("noRtH", false)
        );

        $this->assertNotTrue(
            TestEnum::isValidName("noRtH")
        );
    }

    public function testIsValidValue()
    {
        $this->assertTrue(
            TestEnum::isValidValue(0)
        );

        $this->assertTrue(
            TestEnum::isValidValue(1)
        );

        $this->assertNotTrue(
            TestEnum::isValidValue(-1)
        );

        $this->assertNotTrue(
            TestEnum::isValidValue(4)
        );

        $this->assertNotTrue(
            TestEnum::isValidValue("Anything else...")
        );

    }

}
