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

This package is highly customizable and easy to use. Let's take a look at a short usage example.
```php
ShareButtons::page('https://site.com', 'Page title', [
        'title' => 'Page title',
        'rel' => 'nofollow noopener noreferrer',
    ])
    ->facebook()
    ->linkedin(['rel' => 'follow'])
    ->render();
```

The code above will result into the following HTML code:
```html
<div id="social-links">
    <ul>
        <li><a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fsite.com&quote=Page+title" class="social-button" title="Page title" rel="nofollow noopener noreferrer"><span class="fab fa-facebook-square"></span></a></li>
        <li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=https%3A%2F%2Fsite.com&title=Page+title&summary=" class="social-button" title="Page title" rel="follow"><span class="fab fa-linkedin"></span></a></li>
    </ul>
</div>
```

### Fluent interface

The `ShareButtons` instance provides a fluent interface. The fluent interface is a pattern based on method chaining.
To start a method chaining you just need to use one of the methods listed below (the start chaining methods).
```
page($url, $title = '', $options = [])                  # Creates a method chaining with a given URL and a given page title
createForPage($url, $title = '', $options = [])         # Does the same (is an alias os the page() method)
currentPage($title = '', $options = [])                 # Creates a method chaining with the current page URL and a given page title
createForCurrentPage($title = '', $options = [])        # Does the same (is an alias of the currentPage() method)
```

### Add buttons

To create a single social media share button, you just need to add one of the following methods to the method chaining. Each of these
methods accepts an array of options (you can find more information about the options in the [Optional parameters](#optional-parameters) section).

[//]: # (@todo don't forget to update these methods)
```
facebook($options)      # Generates a Facebook share button
twitter($options)       # Generates a Twitter share button
linkedin($options)      # Generates a LinkedIn share button
telegram($options)      # Generates a Telegram share button
whatsapp($options)      # Generates a WhatsApp share button
reddit($options)        # Generates a Reddit share button
hackernews($options)    # Generates a Hacker News share button
vkontakte($options)     # Generates a VKontakte share button
pinterest($options)     # Generates a Pinterest share button
pocket($options)        # Generates a Pocket share button
evernote($options)      # Generates an Evernote share button
skype($options)         # Generates a Skype share button
xing($options)          # Generates a Xing share button
copylink($options)      # Generates a copy to the clipboard share button
mailto($options)        # Generates a send by mail share button
```

These methods are a part of the fluent interface. Therefore, to create multiple social media share buttons you just need to chain them.

### Getting the result

You can use a ShareButtons instance as a string or cast it to a string to get the HTML code. However, this is not the best way
how to use it. If you want to be clear in your intentions, use `render` or `getShareButtons` methods to get the prepared result.
```php
render()                # Returns a generated share buttons HTML code
getShareButtons()       # Does the same (is an alias of the render() method)
```

### Getting the raw links

Sometimes, you may only want the raw links without any HTML. In such a case, just use the `getRawLinks` method.
```php
getRawLinks()           # Returns an array of generated links
```

## Parameters

There is the possibility to provide different options at different levels to style and decorate the resulting HTML code.

### Main parameters (global options)

Every time a chaining method is called it takes several arguments, including a page URL (it depends on the exact method),
a page title, and an array of options. These are global options that will be used to form the visual representation and 
URLs of share buttons. They will be applied to every element during processing. These options include:
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

Each of the [share button methods](#add-buttons) takes several arguments. These are local options that will be applied to
the specific element only. The local options have a **higher priority**. Therefore, they will overwrite the global options
if there is any overlap. At the moment, the package supports the following local options:
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
