<?php
/*
 * Zrník.eu | Enum  
 * User: Programátor
 * Date: 30.07.2020 9:41
 */

namespace Zrny\Base;

use Exception;
use InvalidArgumentException;
use LogicException;
use ReflectionClass;
use ReflectionException;

/**
 * Class Enum
 * @package Zrny\Base
 */
abstract class Enum
{
    /**
     * Place to save data about constants
     * @var array
     */
    private static $const_cache = [];

    /**
     * Throws instances out of the windows...
     * @throws Exception
     */
    public function __construct()
    {
        throw new Exception("You should not create instance of an enum!");
    }

    /**
     * Returns an associative array with all constants.
     * @param bool $caseSensitive
     * @return array
     */
    public static function toArray($caseSensitive = true): array
    {
        try {
            return static::_getCache($caseSensitive);
        } catch (ReflectionException $e) {
            return [];
        }
    }

    /**
     * Cache creator. Constants are parsed, then saved and then served.
     * @param bool $caseSensitive
     * @return array
     * @throws ReflectionException
     */
    private static function _getCache(bool $caseSensitive = true): array
    {
        $key = get_called_class() . $caseSensitive ?? '::caseSensitive';
        if (!isset(self::$const_cache[$key])) {
            $constantList = (new ReflectionClass(get_called_class()))->getConstants();

            $knownKeys = [];
            $knownValues = [];

            $resultArray = [];

            foreach ($constantList as $ConstantKey => $ConstantValue) {
                if (in_array(strtolower($ConstantKey), $knownKeys)) {
                    throw new LogicException("Key '" . $ConstantKey . "' is already defined in '" . get_called_class() . "' or parent class!");
                }
                $knownKeys[] = strtolower($ConstantKey);

                if (in_array($ConstantValue, $knownValues)) {
                    throw new LogicException("Value '" . $ConstantValue . "' in key '" . $ConstantKey . "' is already defined in '" . get_called_class() . "' or parent class!");
                }
                $knownValues[] = strtolower($ConstantValue);

                $realKey = $caseSensitive ? $ConstantKey : strtolower($ConstantKey);

                $resultArray[$realKey] = $ConstantValue;
            }

            self::$const_cache[$key] = $resultArray;
        }
        return self::$const_cache[$key];
    }

    /**
     * Gets value of a constant by its name. Case sensitivity modified by second argument.
     * @param $Name
     * @param bool $caseSensitive
     * @return mixed
     * @throws InvalidArgumentException
     */
    public static function getValue($Name, $caseSensitive = true)
    {
        $Name = trim($Name);
        try {
            $constants = static::_getCache($caseSensitive);

            if (isset($constants[$Name]))
                return $constants[$Name];

            throw new InvalidArgumentException();
        } catch (ReflectionException $e) {
            throw new InvalidArgumentException();
        }
    }

    /**
     * Gets constant name by its value.
     * @param mixed $Value
     * @return string
     * @throws InvalidArgumentException
     */
    public static function getName($Value): string
    {
        try {
            $key = array_search($Value, static::_getCache(), true);

            if ($key === false || $key === null)
                throw new InvalidArgumentException();

            return strval($key);
        } catch (ReflectionException $e) {
            throw new InvalidArgumentException();
        }
    }

    /**
     * Check if constant with this name exists constant exists within all constants.
     * @param string $Name
     * @param bool $caseSensitive
     * @return bool
     */
    public static function isValidName(string $Name, $caseSensitive = true)
    {
        $Name = trim($Name);
        return in_array($Name, static::getNames($caseSensitive), true);
    }

    /**
     * Returns list with all names defined in enum.
     * @param bool $caseSensitive
     * @return array
     */
    public static function getNames(bool $caseSensitive = true): array
    {
        try {
            return array_keys(static::_getCache($caseSensitive));
        } catch (ReflectionException $e) {
            return [];
        }
    }

    /**
     * Checks if constant with this value exists within all constants.
     * @param mixed $Value
     * @return bool
     */
    public static function isValidValue(string $Value)
    {
        return in_array($Value, static::getValues());
    }

    /**
     * Returns list with all values defined in enum.
     * @return array
     */
    public static function getValues(): array
    {
        try {
            return array_values(static::_getCache());
        } catch (ReflectionException $e) {
            return [];
        }
    }

}