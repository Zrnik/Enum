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
 * C:\Projects\Enum>php benchmark/cache.php
 *
 *            (isset) cached: 2085.33812 ms
 * (array_key_exists) cached: 2372.4761 ms
 *                   created: 6693.28809 ms
 *
 */
class test_cache
{
    public static array $cacheTest = [];
}

/**
 * @param $className
 * @return mixed
 * @throws ReflectionException
 */
function getFromCacheIsset($className)
{
    if (!isset(test_cache::$cacheTest[$className]))
        test_cache::$cacheTest[$className] = (new ReflectionClass($className))->getConstants();

    return test_cache::$cacheTest[$className];
}

/**
 * @param $className
 * @return mixed
 * @throws ReflectionException
 */
function getFromCacheKeyExists($className)
{
    if (!array_key_exists($className, test_cache::$cacheTest))
        test_cache::$cacheTest[$className] = (new ReflectionClass($className))->getConstants();

    return test_cache::$cacheTest[$className];
}

/**
 * @param $className
 * @return array
 * @throws ReflectionException
 */
function getCreated($className)
{
    return (new ReflectionClass($className))->getConstants();
}

try {

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
        getFromCacheKeyExists("Exception");
        getFromCacheKeyExists("stdClass");
        getFromCacheKeyExists("Directory");
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
} catch (ReflectionException $e) {
}
