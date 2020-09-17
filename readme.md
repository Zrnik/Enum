# Enum for PHP

![GitHub](https://img.shields.io/github/license/zrnik/enum)
![Packagist Downloads](https://img.shields.io/packagist/dm/zrnik/enum)
![Travis (.com)](https://api.travis-ci.com/Zrnik/Enum.svg?branch=master)
![Packagist Version](https://img.shields.io/packagist/v/zrnik/enum)  
  
This class was created because of this Stack Overflow question:
https://stackoverflow.com/questions/254514/php-and-enumerations

Many times I was googling for [Brian Cline's](https://stackoverflow.com/a/254543/3133859) 
answer. And as many times I copied it, that many times I was extending it for my needs. 
 
**But not again.**

I have rewritten and extended the class, and the result is this package!

# Installation

`composer require zrnik/enum`

# Change Log 

- 1.0.0 - Re-Namespace Release (from zrny/enum)

# Usage

#### Create Enum Class

```php
use Zrnik\Base\Enum;
class DayOfWeek extends Enum
{
    const Sunday = 0;
    const Monday = 1;
    const Tuesday = 2;
    const Wednesday = 3;
    const Thursday = 4;
    const Friday = 5;
    const Saturday = 6;

}
```

#### Compare


```php
if($this->Stardate->DayOfWeek === DayOfWeek::Monday)
{
    $this->spaceTime = new SpaceTime();
     //TODO: Decide if light will be particle or wave
    $this->spaceTime->addComponent(new Light());
}
```

#### Enumerate 

```php
foreach(DayOfWeek::getValues() as $value)
{
    echo 'It\'s '.DayOfWeek::getName($value).' and im still lazy. '.PHP_EOL;
}
```


```php
foreach(DayOfWeek::getNames() as $name)
{
    echo 'It\'s '.$name.' and im'.(DayOfWeek::getValue($name) === DayOfWeek::Monday ? ' ':' still ').'lazy. '.PHP_EOL;
}
```

#### Check

```php
if(DayOfWeek::getValue("Monday") === DayOfWeek::Monday) {
    // true
}

if(DayOfWeek::getValue("monday") === DayOfWeek::Monday) {
     // Invalid Argument Exception
}

if(DayOfWeek::getValue("monday", false) === DayOfWeek::Monday) {
    // true, case sensitivity disabled
}

if(DayOfWeek::getValue("monday ", false) === DayOfWeek::Monday) {
    // true, not case sensitive AND it gets trimmed automatically
}
```

##### ??? 

##### PROFIT!

# Methods

`\Zrnik\Base\Enum::getName(mixed $Value) : array`

Gets constant name by the value.

`\Zrnik\Base\Enum::getValue(string $Name[, bool $caseSensitive = true]) : mixed`

Gets value of a constant by its name. Case sensitivity is modified by second argument.

------

`\Zrnik\Base\Enum::isValidName(string $Name[, bool $caseSensitive = true]) : bool`

Checks if the name is present in the Enum. Case sensitivity is modified by second argument.

`\Zrnik\Base\Enum::isValidValue(string $Value) : bool`

Checks if the value is present in the Enum.

------

`\Zrnik\Base\Enum::toArray([$caseSensitive = true]) : array`

Returns an associative array with all the constants.

`\Zrnik\Base\Enum::getNames([$caseSensitive = true]) : array`

Returns a list with all names defined in an enum.

`\Zrnik\Base\Enum::getValues() : array`

Returns an array with all the values defined in an enum.

------
