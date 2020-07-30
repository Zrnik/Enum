<?php

/*
 * I have no idea how to write tests.. (yet)
 *
 * Hope this will do :)
 */

include __DIR__ . '/bootstrap.php';
include __DIR__ . '/Examples/TestEnum.php';

use Tester\Assert;
use Tester\Examples\TestEnum;

Assert::equal(["North", "South", "East", "West"], TestEnum::getNames());
Assert::equal([0, 1, 2, 3], TestEnum::getValues());
Assert::equal([
    "North" => 0,
    "South" => 1,
    "East" => 2,
    "West" => 3
],
    TestEnum::toArray());
Assert::equal([
    "north" => 0,
    "south" => 1,
    "east" => 2,
    "west" => 3
],
    TestEnum::toArray(false));


Assert::equal("North", TestEnum::getName(0));
Assert::notEqual("South", TestEnum::getName(0));
Assert::notEqual("East", TestEnum::getName(0));
Assert::notEqual("West", TestEnum::getName(0));

Assert::equal("North", TestEnum::getName(0));
Assert::notEqual("North", TestEnum::getName(1));
Assert::notEqual("North", TestEnum::getName(2));
Assert::notEqual("North", TestEnum::getName(3));

Assert::equal(0, TestEnum::getValue("North"));
Assert::notEqual(1, TestEnum::getValue("North"));
Assert::notEqual(2, TestEnum::getValue("North"));
Assert::notEqual(3, TestEnum::getValue("North"));

Assert::equal(0, TestEnum::getValue("North"));
Assert::notEqual(0, TestEnum::getValue("South"));
Assert::notEqual(0, TestEnum::getValue("East"));
Assert::notEqual(0, TestEnum::getValue("West"));

Assert::true(TestEnum::isValidValue(0));
Assert::true(TestEnum::isValidValue(1));
Assert::false(TestEnum::isValidValue(4));

Assert::true(TestEnum::isValidName("North"));
Assert::true(TestEnum::isValidName("West"));
Assert::false(TestEnum::isValidName("NorthWest"));

Assert::equal(0, TestEnum::getValue("North"));

Assert::exception(function () {
    TestEnum::getValue("north");
}, InvalidArgumentException::class);

Assert::equal(0, TestEnum::getValue("north", false));

/*
 * Is this test file correct? Am i missing something? Let me know :)
 */

