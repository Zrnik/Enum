# PHP Enum Released!
  
This class was created because of this Stack Overflow question:

https://stackoverflow.com/questions/254514/php-and-enumerations

I liked the selected answer by [Brian Cline](https://stackoverflow.com/a/254543/3133859), but it was not complete enough for me.

It works as intended, so I created first major version, and probably the last version.
# License

[MIT](license.md)

# Usage

#### Create Enum Class

```php
use Zrny\Base\Enum;
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

`\Zrny\Base\Enum::getName(mixed $Value) : array`

Gets constant name by its value.

`\Zrny\Base\Enum::getValue(string $Name[, bool $caseSensitive = true]) : mixed`

Gets value of a constant by its name. Case sensitivity modified by second argument.

------

`\Zrny\Base\Enum::isValidName(string $Name[, bool $caseSensitive = true]) : bool`

Check if constant with this name exists constant exists within all constants.

`\Zrny\Base\Enum::isValidValue(string $Value) : bool`

Checks if constant with this value exists within all constants.

------

`\Zrny\Base\Enum::toArray([$caseSensitive = true]) : array`

Returns an associative array with all constants.

`\Zrny\Base\Enum::getNames([$caseSensitive = true]) : array`

Returns list with all names defined in enum.

`\Zrny\Base\Enum::getValues() : array`

Returns list with all values defined in enum.

------