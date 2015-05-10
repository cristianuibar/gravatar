# Gravatar for Laravel 5

[![Build Status](https://travis-ci.org/uibar/gravatar.svg?branch=master)](https://travis-ci.org/uibar/gravatar)
[![Latest Stable Version](https://poser.pugx.org/uibar/gravatar/v/stable)](https://packagist.org/packages/uibar/gravatar)
[![Total Downloads](https://poser.pugx.org/uibar/gravatar/downloads)](https://packagist.org/packages/uibar/gravatar)
[![Latest Unstable Version](https://poser.pugx.org/uibar/gravatar/v/unstable)](https://packagist.org/packages/uibar/gravatar)
[![License](https://poser.pugx.org/uibar/gravatar/license)](https://packagist.org/packages/uibar/gravatar)

This package is a quick and simple way to implement Gravatar in your Laravel project. Enjoy!

##Install
1. Get the package

```php
composer require uibar/gravatar
```

2. Add the Service Provider and the Facade to your config/app.php file
    
```php
'providers' => [
    'Uibar\Gravatar\GravatarServiceProvider',
```

```php
'aliases' => [
    'Gravatar' => 'Uibar\Gravatar\Facades\Gravatar',
```

##Use
In your views file where you want to display the Gravatar just write:

```php

// First the short version:
Gravatar::get('user@domain.com');

// Or if you'd like by chaining methods:
Gravatar::email('your@email.com')->make();
```

This will return a default of 80x80 avatar url string to your Gravatar.

##Customize
To get a more customized image just pass in the additional parameters:

```php
    Gravatar::get($email, $size, $default, $rating, $image, $attributes);
```

$email      =>      The email of the Gravatar

$size       =>      The size in pixels \[1 - 2048\]

$defaults    =>      Default image set to use if avatar not found \[404 | mm | identicon | monsterid | wavatar\]

$rating     =>      Accepted image rating  \[g | pg | r | x\]

$image      =>      TRUE or FALSE if you want or not to return the full image tag instead of the image URL

$attributes =>      The extra attributes you need for the image tag if you chose this way

##Method Chaining
You can use method chaing to customize your Gravatar. The same method names are used as the var names above. Let's see an example:

```php
Gravatar::email('custom@email.com')->size(40)->defaults('identicon')->rating('x')->make();
```

Please note that in method chaining we use make() as the end of the statement not get() and it accepts no arguments.
Still for the make() method to work only the email should be set before.

**For the moment, the image and attributes values cannot be set trough method chaining so you won't be able to generate
a full image tag trough this method.**

##License
This package is released under the MIT license and is free for all.

##Thank you!
Thanks to these amazing people and their packages I got inspired to write my own representation of Gravatar Helper.

- [GRAVATARLIB - by emberlabs](https://github.com/emberlabs/gravatarlib)
- [LARAVEL-GRAVATAR - by thomaswelton](https://github.com/thomaswelton/laravel-gravatar)
- [GRAVATAR - by creativeorange](https://github.com/creativeorange/gravatar)

Thank you!
