<?php
/*
 * Zrník.eu | Enum
 * User: Programátor
 * Date: 30.07.2020 10:52
 */

namespace ExampleEnums;

use Zrnik\Base\Enum;

class EnumWithNullValue extends Enum
{
    // Null is allowed
    const Null = null;
    const Foo = 'foo';
    const Bar = 'bar';
}
