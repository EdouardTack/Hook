# Hook PHP package

Library in loading ...
Documention in writing ...

## Requirements

* PHP >= 7

## How to use it

### Load it

Load the library with composer

```sh
php composer.phar require edouardtack/hook "dev-master"
```

OR add this lines to your `composer.json`

```sh
"require": {
    "edouardtack/hook": "dev-master"
}
```

And run `php composer.phar update`

## Use it

### Instance the hook

```php
use EdouardTack\Hook\Hook;

$hook = new Hook();
```

### Add an event on your code

```php
echo $hook->filter('UNIQUE_NAME', 'VALUE');
```

### Create a hook method to modify your value on the way

```php
class Test {
    public static function method($value) {
        return $value . ' azacd';
    }
    public static function method2($value) {
        return $value . ' 22222';
    }
}
$hook->setFilter('test', array('Test', 'method'), 1);
$hook->setFilter('test', array('Test', 'method2'), 3);
```

## Go further

### HOOK TYPE

Default type of hook are Filter and Action.
You can create some new like this

```php
$hook->addType('NewType');

// Event code
echo $hook->newType('UNIQUE_NAME', 'VALUE');

// Register code
$hook->setNewType('UNIQUE_NAME', array('Test', 'method'), 1);
```

## LICENCE

The MIT License (MIT)

Copyright (c) 2016 Edouard Tack

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
