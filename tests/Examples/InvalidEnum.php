<?php
/*
 * Zrník.eu | Enum
 * User: Programátor
 * Date: 30.07.2020 10:52
 */

namespace ExampleEnums;

use Zrnik\Base\Enum;

class InvalidEnum extends Enum
{
    // No duplicate values please
    const Foo = "foo";
    const Bar = "foo";

    // This case is rejected by PHP itself:
    // const Foo = 'bar';
}
