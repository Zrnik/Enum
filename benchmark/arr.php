<?php

use Tracy\Debugger;

include __DIR__ . '/../vendor/autoload.php';

/**
 * 'isset' or 'array_key_exists'
 */

$Rounds = pow(10, 8);
/**
 * For 10^8
 * --------
 * C:\Projects\Enum>php benchmark/arr.php
 *              isset(): 3433.87198 ms
 *   array_key_exists(): 5685.10222 ms
 */

$TestArray = [
    0 => "test"
];

Debugger::timer("speed-isset");
for ($i = 0; $i < $Rounds; $i++) {
    isset($TestArray[0]);
    isset($TestArray[1]);
}
$speed_isset = round(1000 * Debugger::timer("speed-isset"), 5);
echo "           isset(): " . $speed_isset . " ms\n";

Debugger::timer("speed-array-key-exists");
for ($i = 0; $i < $Rounds; $i++) {
    array_key_exists(0, $TestArray);
    array_key_exists(1, $TestArray);
}
$speed_isset = round(1000 * Debugger::timer("speed-array-key-exists"), 5);
echo "array_key_exists(): " . $speed_isset . " ms\n";











