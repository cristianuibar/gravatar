# Gravatar - A helper for Laravel 5
A quick and simple implementation of Gravatar for Laravel. Use it to display Gravatars in your web-app.

##Install
1. Get the package

    ```php
        composer require uibar/gravatar
    ```

2. Add the Service Provider and the Facade to your config/app.php file
    
    ```php
    'providers' => [
        'Creativeorange\Gravatar\GravatarServiceProvider'
    ```
    
    ```php
    'aliases' => [
        'Gravatar' => 'Creativeorange\Gravatar\Facades\Gravatar',
    ```

##Use
In your views file where you want to display the Gravatar just write:

```php
    Gravatar::url('user@domain.com');
```

This will return a default of 80x80 avatar url string to your Gravatar.

##Customize
To get a more customized image just pass in the additional parameters:

```php
    Gravatar::url($email, $size, $default, $rating, $image, $attributes);
```

$email      =>      The email of the Gravatar

$size       =>      The size in pixels \[ 1 - 2048 \]

$default    =>      Default image set to use if avatar not found \[ 404 | mm | identicon | monsterid | wavatar \]

$rating     =>      Accepted image rating  \[ g | pg | r | x \]

$image      =>      TRUE or FALSE if you want or not to return the full image tag instead of the image URL

$attributes =>      The extra attributes you need for the image tag if you chose this way

##License
This package is released under the MIT license and is free for all.

##Thank you!
Thanks to these amazing people and their packages I got inspired to write my own representation of Gravatar Helper.

- [GRAVATARLIB - by emberlabs](https://github.com/emberlabs/gravatarlib)
- [LARAVEL-GRAVATAR - by thomaswelton](https://github.com/thomaswelton/laravel-gravatar)
- [GRAVATAR - by creativeorange](https://github.com/creativeorange/gravatar)

Thank you!
