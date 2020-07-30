<?php

use Tracy\Debugger;

include __DIR__ . '/../vendor/autoload.php';
/**
 * 'new ReflectionClass' always or array from memory?
 */

$Rounds = pow(10, 7);

/**
 * We will save reflection class to memory because its faster
 *
 * 10^7
 *
 * C:\Code2\Enum>php benchmark/cache.php
 *
 *            (isset) cached: 2149.94192 ms
 * (array_key_exists) cached: 2215.25002 ms
 *                   created: 6488.66606 ms
 *
 * 10^8
 *
 * C:\Code2\Enum>php benchmark/cache.php
 *            (isset) cached: 24595.64519 ms
 * (array_key_exists) cached: 24075.32406 ms
 *                   created: 64699.00203 ms
 *
 */
class testcache
{
    public static $cacheTest = [];
}


function getFromCacheIsset($className)
{
    if (!isset(testcache::$cacheTest[$className]))
        testcache::$cacheTest[$className] = (new ReflectionClass($className))->getConstants();

    return testcache::$cacheTest[$className];
}

function getFromCachKeyExists($className)
{
    if (!array_key_exists(testcache::$cacheTest, $className))
        testcache::$cacheTest[$className] = (new ReflectionClass($className))->getConstants();

    return testcache::$cacheTest[$className];
}

function getCreated($className)
{
    return (new ReflectionClass($className))->getConstants();
}


Debugger::timer("speed-cached-isset");
for ($i = 0; $i < $Rounds; $i++) {
    getFromCacheIsset("Exception");
    getFromCacheIsset("stdClass");
    getFromCacheIsset("Directory");
}
$speed_cached = round(1000 * Debugger::timer("speed-cached-isset"), 5);
echo "            (isset) cached: " . $speed_cached . " ms\n";


Debugger::timer("speed-cached-ake");
for ($i = 0; $i < $Rounds; $i++) {
    getFromCacheIsset("Exception");
    getFromCacheIsset("stdClass");
    getFromCacheIsset("Directory");
}
$speed_cached_ake = round(1000 * Debugger::timer("speed-cached-ake"), 5);
echo " (array_key_exists) cached: " . $speed_cached_ake . " ms\n";


Debugger::timer("speed-created");
for ($i = 0; $i < $Rounds; $i++) {
    getCreated("Exception");
    getCreated("stdClass");
    getCreated("Directory");
}
$speed_created = round(1000 * Debugger::timer("speed-created"), 5);
echo "                   created: " . $speed_created . " ms\n";