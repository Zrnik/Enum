<?php

/*
 * Zrník.eu | Enum
 * User: Programátor
 * Date: 30.07.2020 9:41
 */

namespace Zrnik\Base;

use Exception;
use InvalidArgumentException;
use LogicException;
use ReflectionClass;
use ReflectionException;

/**
 * Class Enum
 * @package Zrnik\Base
 */
abstract class Enum
{
    /**
     * Place to save data about constants
     * @var array<string, array<string, scalar|null>>
     */
    private static array $const_cache = [];

    /**
     * Throws instances out of the window...
     * @throws Exception
     */
    public function __construct()
    {
        throw new Exception("You should not create instance of an enum!");
    }

    /**
     * Returns an associative array with all constants.
     * @param bool $caseSensitive
     * @return array<string, scalar|null>
     */
    public static function toArray(bool $caseSensitive = true) : array
    {
        try {
            return self::_getCache($caseSensitive);
        } catch (ReflectionException $e) {
            return [];
        }
    }

    /**
     * Cache creator. Constants are parsed, then saved and then served.
     * @param bool $caseSensitive
     * @return array<string, scalar|null>
     */
    private static function _getCache(bool $caseSensitive = true): array
    {
        $key = get_called_class() . ($caseSensitive ? '::caseSensitive' : '');
        if (!isset(self::$const_cache[$key])) {
            $constantList = (new ReflectionClass(get_called_class()))->getConstants();

            /** @var string[] $knownKeys */
            $knownKeys = [];

            /** @var array<scalar|null> $knownValues */
            $knownValues = [];

            /** @var array<string, scalar|null> $resultArray */
            $resultArray = [];

            /**
             * @var string $ConstantKey
             * @var scalar|null $ConstantValue
             */
            foreach ($constantList as $ConstantKey => $ConstantValue) {
                if (in_array(strtolower($ConstantKey), $knownKeys)) {
                    throw new LogicException("Key '" . $ConstantKey . "' is already defined in '" . get_called_class() . "' or parent class!");
                }
                $knownKeys[] = strtolower($ConstantKey);

                if (in_array($ConstantValue, $knownValues)) {
                    throw new LogicException("Value '" . $ConstantValue . "' in key '" . $ConstantKey . "' is already defined in '" . get_called_class() . "' or parent class!");
                }

                if(is_string($ConstantValue)) {
                    $ConstantValue = strtolower((string)$ConstantValue);
                }

                $knownValues[] = $ConstantValue;

                $realKey = $caseSensitive ? $ConstantKey : strtolower($ConstantKey);

                $resultArray[$realKey] = $ConstantValue;
            }

            self::$const_cache[$key] = $resultArray;
        }
        return self::$const_cache[$key];
    }

    /**
     * Gets value of a constant by its name. Case sensitivity modified by second argument.
     * @param string $Name
     * @param bool $caseSensitive
     * @return mixed
     * @throws InvalidArgumentException
     */
    public static function getValue(string $Name, bool $caseSensitive = true)
    {
        $Name = trim($Name);
        try {
            $constants = self::_getCache($caseSensitive);

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
    public static function getName($Value) : string
    {
        try {
            $key = array_search($Value, self::_getCache(), true);

            if ($key === false) {
                throw new InvalidArgumentException();
            }

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
    public static function isValidName(string $Name, $caseSensitive = true) : bool
    {
        $Name = trim($Name);

        if(!$caseSensitive)
            $Name = strtolower($Name);

        return in_array($Name, static::getNames($caseSensitive), true);
    }

    /**
     * Returns list with all names defined in enum.
     * @param bool $caseSensitive
     * @return string[]
     */
    public static function getNames(bool $caseSensitive = true): array
    {
        try {
            return array_keys(self::_getCache($caseSensitive));
        } catch (ReflectionException $e) {
            return [];
        }
    }

    /**
     * Checks if constant with this value exists within all constants.
     * @param mixed $Value
     * @return bool
     */
    public static function isValidValue($Value) : bool
    {
        return in_array($Value, static::getValues(),true);
    }

    /**
     * Returns list with all values defined in enum.
     * @return array<scalar|null>
     */
    public static function getValues(): array
    {
        try {
            return array_values(self::_getCache());
        } catch (ReflectionException $e) {
            return [];
        }
    }

}
