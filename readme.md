# Gravatar for Laravel 5

[![Build Status](https://travis-ci.org/uibar/gravatar.svg?branch=master)](https://travis-ci.org/uibar/gravatar)
[![Latest Stable Version](https://poser.pugx.org/uibar/gravatar/v/stable)](https://packagist.org/packages/uibar/gravatar)
[![Total Downloads](https://poser.pugx.org/uibar/gravatar/downloads)](https://packagist.org/packages/uibar/gravatar)
[![Latest Unstable Version](https://poser.pugx.org/uibar/gravatar/v/unstable)](https://packagist.org/packages/uibar/gravatar)
[![License](https://poser.pugx.org/uibar/gravatar/license)](https://packagist.org/packages/uibar/gravatar)

This package is a quick and simple way to implement Gravatar in your Laravel project. Enjoy!

##Features
* URL generation with customized parameters
* Full img tags generation with customized parameters and HTML attributes
* Supports method chaining

## Future Features
I am planning to implement the following feature in the future:
* Gravatar Profiles handling

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
To get the Gravatar URL it's as simple as:
```php
$gravatar_url = Gravatar::make('user@domain.com');
```

Of course we can also generate a full image tag. For your ease we can do this in multiple ways. Either way, the email is required to be specified.
```php
// We can directly specify some HTML tags as the second parameter of the
// make() method like this:
{!! Gravatar::make('email@address.com', ['class' => 'img-circle']) !!}
// We could specify the email using Method Chaining and then passing TRUE
// to the make() method
{!! Gravatar::email('user@domain.com')->make(TRUE) !!}
// Or we can pass an array as the first parameter containing the email and
// the image key as TRUE like this:
{!! Gravatar::make(['email' => Auth::user()->email, 'image' => TRUE]) !!}
```

All of these will return a default of 80x80 Gravatar.

##Customize
To be able to customize your Gravatar return you can refer to the following elements:

$email      =>      The email of the Gravatar

$size       =>      The size in pixels \[1 - 2048\]

$defaults    =>      Default image set to use if avatar not found \[404 | mm | identicon | monsterid | wavatar\]

$rating     =>      Accepted image rating  \[g | pg | r | x\]

$image      =>      TRUE or FALSE if you want or not to return the full image tag instead of the image URL

$attributes =>      The extra attributes you need for the image tag if you chose this way

These elements can be changed either by passing them in the first parameter of the make() method as array keys (the order doesn't matter), by Method Chaining or trough the get() method params.

Here are three customized examples with the same effect that illustrates the customization methods:
```php
// The following will output a full image tag with custom size, rating and
// attributes for the img tag:
{!! Gravatar::make([
    'email' => 'user@domain.com',
    'size' => 40,
    'rating' => 'x',
    'image' => TRUE,
    'attributes' => ['class' => 'img-circle']
]) !!}
// The same effect could be accomplished by passing the attributes for the
// img tag as second parameter of the make method and thus not specifying the
// image key as TRUE anymore
{!! Gravatar::make([
    'email' => 'user@domain.com',
    'size' => 40,
    'rating' => 'x'
], ['class' => 'img-circle']) !!}
// Using the get() method
{!! Gravatar::get('user@domain.com', 40, 'identicon', 'x', TRUE,
            ['class' => 'img-circle']); !!}
// The order of the elements using this way DOSE MATTER. It will not work unless
// you use it using this exact order:
$url = Gravatar::get($email, $size, $default, $rating, $image, $attributes);
```
It's up to you to chose the one that best fits your needs.

##Method Chaining
You can use method chaining to customize your Gravatar. The same method names are used as the element names above. Let's see an example:

```php
// For custom URLs:
$custom_url = Gravatar::email('custom@email.com')->size(40)
    ->defaults('identicon')->rating('x')->make();
// For custom img tag:
{!! Gravatar::email('custom@email.com')->size(40)->rating('x')
    ->attributes(['class' => 'img-circle'])->make(TRUE) !!}
// Or as learned above we could do:
{!! Gravatar::size(40)->rating('x')->make('user@domain.com', ['class' => 'img-circle']) !!}
```

Please note that in method chaining we use make() as the end of the statement not get().

##License
This package is released under the MIT license and thus it's free for all to use, distribute and upgrade.

##Thank you!
Thanks to these amazing people and their packages I got inspired to write my own representation of Gravatar Helper.

- [LARAVEL-GRAVATAR - by thomaswelton](https://github.com/thomaswelton/laravel-gravatar)
- [GRAVATARLIB - by emberlabs](https://github.com/emberlabs/gravatarlib)
- [GRAVATAR - by creativeorange](https://github.com/creativeorange/gravatar)

Thank you!
