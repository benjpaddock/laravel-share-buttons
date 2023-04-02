# Laravel Share Buttons ![test workflow](https://github.com/kudashevs/laravel-share-buttons/actions/workflows/run-tests.yml/badge.svg)

The Laravel Share Buttons package was originated from [Laravel Share](https://github.com/jorenvh/laravel-share). This package
provides the functionality to create a block of social media share buttons for your site in a flexible and convenient way.

[//]: # (@todo don't forget to update these services)
### Available services

* Facebook
* Twitter
* LinkedIn
* Telegram
* WhatsApp
* Reddit
* Hacker News
* VKontakte
* Pinterest
* Pocket
* Evernote
* Skype
* Xing
* Copy the link
* Mail the link

## Installation

You can install the package via composer:
```bash
composer require kudashevs/laravel-share-buttons
```

If you don't use auto-discovery just add a ServiceProvider to the `config/app.php`
```php
'providers' => [
    Kudashevs\ShareButtons\Providers\ShareButtonsServiceProvider::class,
];
```

If you want to add a Laravel Facade just add it to the `aliases` array in the `config/app.php`
```php
'aliases' => [
    'ShareButtons' => Kudashevs\ShareButtons\Facades\ShareButtonsFacade::class,
];
```
by default, it binds a `ShareButtons` class instance to the `sharebuttons` alias.

Don't forget to publish the package configuration and resource files.
```bash
php artisan vendor:publish --provider="Kudashevs\ShareButtons\Providers\ShareButtonsServiceProvider"
```
> **_NOTE:_** In case of major changes, it is recommended to back up your config file and republish a new one from scratch.

### Assets

By default, this package relies on Font Awesome icons and the jQuery library. However, you can easily integrate any fonts, CSS, or JS.

To enable the Font Awesome icons, use the code sample below. For further information on how to use Font Awesome, please read the [introduction](https://fontawesome.com/docs/web/setup/get-started).
```html
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
```

To enable the jQuery library, use the code sample below. Then copy a `resources/assets/js/share-buttons.js` file to the `public/js` folder, or add this file into your assets compiling flow.
```html
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script src="{{ asset('js/share-buttons.js') }}"></script>
```

## Usage

The package is really easy and convenient to use. Just to prove it, let's take a look at a short usage example.
```php
ShareButtons::page('https://site.com', 'Page title', [
        'title' => 'Page title',
        'rel' => 'nofollow noopener noreferrer',
    ])
    ->facebook()
    ->linkedin(['rel' => 'follow'])
    ->render();
```

This call will result into the following HTML code:
```html
<div id="social-links">
    <ul>
        <li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fsite.com&quote=Page+title" class="social-button" title="Page title" rel="nofollow noopener noreferrer"><span class="fab fa-facebook-square"></span></a></li>
        <li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fsite.com&title=Page+title&summary=" class="social-button" title="Page title" rel="follow"><span class="fab fa-linkedin"></span></a></li>
    </ul>
</div>
```

The package is easy and convenient to use. It provides a fluent interface to build an HTML code of share buttons.
To start a method chaining you just need to use one of the methods (start chaining methods). These methods are:
```
page($url, $title = '', $options = [])
currentPage($title = '', $options = [])
createForPage($url, $title = '', $options = [])
createForCurrentPage($title = '', $options = [])
```

### Share button methods

To create a single share button, you just need to add one of the following methods to the method chaining. Each of these
methods accepts an array of options (you can find more information about the options in the [Optional parameters](#optional-parameters) section).

[//]: # (@todo don't forget to update these methods)
```
* facebook($options)            # Generate a Facebook share button
* twitter($options)             # Generate a Twitter share button
* linkedin($options)            # Generate a LinkedIn share button
* telegram($options)            # Generate a Telegram share button
* whatsapp($options)            # Generate a WhatsApp share button
* reddit($options)              # Generate a Reddit share button
* hackernews($options)          # Generate a Hacker News share button
* vkontakte($options)           # Generate a VKontakte share button
* pinterest($options)           # Generate a Pinterest share button
* pocket($options)              # Generate a Pocket share button
* evernote($options)            # Generate an Evernote share button
* skype($options)               # Generate a Skype share button
* xing($options)                # Generate a Xing share button
* copylink($options)            # Generate a copy to the clipboard share button
* mailto($options)              # Generate a send by mail share button
```

### Share a specific page
```php
ShareButtons::page('https://site.com/', 'Page title')->facebook();           # Create a facebook button with the provided URL
ShareButtons::createForPage('https://site.com/', 'Page title')->facebook();  # An alias to the page() method
```

### Share a current page
```php
ShareButtons::currentPage('Page title')->twitter();                          # Creates a twitter button with the current page URL
ShareButtons::createForCurrentPage('Page title')->twitter();                 # An alias to the currentPage() method
```

### Creating multiple share buttons

In case you want to create multiple share buttons, you just need to chain different methods in a sequence.
```php
ShareButtons::page('https://site.com', 'Page title')
    ->facebook()
    ->twitter()
    ->linkedin(['summary' => 'Extra linkedin summary can be passed here'])
    ->whatsapp();
```

This sequence will generate the following HTML code:
```html
<div id="social-links">
    <ul>
        <li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fsite.com&quote=Page+title" class="social-button"><span class="fab fa-facebook-square"></span></a></li>
        <li><a href="https://twitter.com/intent/tweet?text=Page+title&url=https%3A%2F%2Fsite.com" class="social-button"><span class="fab fa-twitter"></span></a></li>
        <li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fsite.com&title=Page+title&summary=Extra+linkedin+summary+can+be+passed+here" class="social-button"><span class="fab fa-linkedin"></span></a></li>
        <li><a href="https://wa.me/?text=https%3A%2F%2Fsite.com%20Page+title" class="social-button" target="_blank"><span class="fab fa-whatsapp"></span></a></li>
    </ul>
</div>
```

### Getting the result

You can use a ShareButtons object as a string or cast it to a string to get the share buttons HTML code. However,
this is not the preferred way how to use it. If you want to be clear in your intentions, use the `getShareButtons`
method to get the prepared result.
```php
ShareButtons::page('https://site.com', 'Share title')
    ->facebook()
    ->getShareButtons();
```

### Getting the raw links

Sometimes, you may only want the raw links without any HTML. In such a case, just use the `getRawLinks` method.
```php
ShareButtons::page('https://site.com', 'Share title')
    ->facebook()
    ->getRawLinks();
```

## Parameters

The package allows you to provide different options to decorate and improve the resulting share buttons HTML code.

### Main parameters (global options)

Every time a chaining method is called it takes several arguments, including a page URL (it depends on the exact method),
a page title, and an array of options. These are global options that will be used to form the visual representation and 
URLs of share buttons. They will be applied to every share buttons element during processing. These options include:
```
'block_prefix' => 'tag'          # Sets a share buttons block prefix (default is <ul>)
'block_suffix' => 'tag'          # Sets a share buttons block suffix (default is </ul>)
'element_prefix' => 'tag'        # Sets an element prefix (default is <li>)
'element_suffix' => 'tag'        # Sets an element suffix (default is </li>)
'id' => 'value'                  # Adds an HTML id attribute to the output links
'class' => 'value'               # Adds an HTML class attribute to the output links
'title' => 'value'               # Adds an HTML title attribute to the output links
'rel' => 'value'                 # Adds an HTML rel attribute to the output links
```

### Optional parameters (local options)

Each of the [share button methods](#share-button-methods) takes several arguments. These are local options that will be
applied to a specific element only. The local options have a higher priority, therefore they will overwrite the global
options if there is any overlap. At the moment, the package supports the following local options:
```
'id' => 'value'                  # Adds an HTML id attribute to the button link
'class' => 'value'               # Adds an HTML class attribute to the button link
'title' => 'value'               # Adds an HTML title attribute to the button link
'rel' => 'value'                 # Adds an HTML rel attribute to the button link
'summary' => 'value'             # Adds a summary text to the URL (linkedin button only)
```

#### A detailed usage example
```php
ShareButtons::page('https://site.com', 'Page title', [
        'block_prefix' => '<ul>',
        'block_suffix' => '</ul>',
        'class' => 'my-class',
        'id' => 'my-id',
        'title' => 'my-title',
        'rel' => 'nofollow noopener noreferrer',
    ])
    ->facebook()
    ->linkedin(['id' => 'linked', 'class' => 'hover', 'rel' => 'follow', 'summary' => 'cool summary']);
```

will result into the following HTML code
```html
<ul>
    <li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fsite.com&quote=Page+title" class="social-button my-class" id="my-id" title="my-title" rel="nofollow noopener noreferrer"><span class="fab fa-facebook-square"></span></a></li>
    <li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fsite.com&title=Page+title&summary=cool+summary" class="social-button hover" id="linked" title="my-title" rel="follow"><span class="fab fa-linkedin"></span></a></li>
</ul>
```

## Configuration

The package comes with some configuration settings. These are:

### Representation section
```
'block_prefix' => 'value'           # Sets a share buttons block prefix (default is <ul>)
'block_suffix' => 'value'           # Sets a share buttons block suffix (default is </ul>)
'element_prefix' => 'value'         # Sets an element prefix (default is <li>)
'element_suffix' => 'value'         # Sets an element suffix (default is </li>)
```

### Share buttons section

Each share button has some settings that can be configured.
```
'url' => 'value'                    # A share button URL template (used to form a button's URL)
'text' => 'value'                   # A default text for the title (used when the page title is empty)
'extra' => []                       # Extra options which are required by some specific buttons
```

### Templates section

Each share button has a link representation represented by a corresponding template. A template contains some elements
will be changed during processing. The format of substituted elements depends on the package templater.
```
:url                                # Will be replaced with a prepared share button URL
:id                                 # Will be replaced with an id attribute
:class                              # Will be replaced with a class attribute
:title                              # Will be replaced with a title attribute
:rel                                # Will be replaced with a rel attribute
```

## Testing
```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
