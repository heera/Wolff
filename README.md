<h1 align="center">
  <br>
  <img src="http://usbac.com.ve/wp-content/uploads/2019/04/wolff-small.png" alt="Wolff logo" width="200">
  <br>
  Wolff
  <br>
</h1>

<h4 align="center">Ridiculously small PHP framework.</h4>

<p align="center">
<img src="https://img.shields.io/badge/stability-stable-green.svg"> <img src="https://img.shields.io/badge/version-0.9.9.1-blue.svg"> <img src="https://img.shields.io/badge/license-MIT-orange.svg">
</p>

Wolff is a ridiculously small and lightweight PHP framework with useful functions and utilities like a template, route, extensions and language system. 

It is intended for those who want to build light websites without having to do everything from scratch or using too large/complicated frameworks and libraries.

Wolff complies with the PSR-1, PSR-2 and PSR-4 coding standards :)

## Features

* **Fast**: Due to its small size and simplicity, you don’t have to worry about loading times or resource usage.

* **Simple**: It’s not only small, but simple as well; with a clean documentation and easy way to use.

* **Extensible**: Take advantage of the custom extensions and templates you can make in Wolff to expand your page.

* **Clean**: The routes system allows you to have clean and friendly URLs, and the template system makes the php code cleaner while separating the logic from the view.

* **Dynamic**: You can work however you want without strictly following the Wolff design.

## Utilities

* **Cache**: An optional cache system which can increase the overall loading speed of your pages.

* **Route**: A route system that allows you to have clean URLs, make redirections and block certain pages recursively.

* **Template**: With the optional template system you can write cleaner code in your views and avoid things like the php tags.

* **Query builder**: Easql is the small query builder that comes in Wolff which reduces the code repetition and makes easier the process of running queries.

* **Uploader**: Simplify and optimize the process of uploading files with the uploader system of Wolff.

* **Session**: Have cleaner code using the session class instead of managing the php session variables directly.

* **Extension**: An useful and descriptive extension system which gives you more control over your site.

* **Language**: For managing multiple languages easily and quickly.

And more...

## CLI

Take advantage of the CLI application of Wolff named Wolffie to do a lot of tasks in a fast and easy way using short commands.<br>
With it you can create extensions, controllers, routes, export queries to csv files, look at the available extensions, change the project configuration, delete elements like controllers, languages and much more.

<p align="center">
<img src="http://usbac.com.ve/wp-content/uploads/2019/05/wolffie-cli2-min.PNG" alt="Wolff cli" width="400">
</p>

## Requirements

* PHP version 7.0 or higher.

* Composer

## Install

You must have [composer](https://getcomposer.org/) in your system for installing Wolff, once you have it.

Open your favorite terminal, move to the folder where you want Wolff to be installed and run the following command:

```
composer create-project "usbac/Wolff @dev"
```

This will download the whole project with everything ready to run!

You can see more information about the installation process in the [Wiki - install](https://github.com/Usbac/Wolff/wiki/Installation) page.

## Documentation

First time using it? Read the [Wiki page](https://github.com/Usbac/Wolff/wiki).

## Contributing

Currently Wolff is quite stable but it's still a work in progress, new features will be added soon and the core structure may change a little over time.

Any contribution or support to this project in the form of a pull request or message will be highly appreciated.

Don't be shy :)

## License

Wolff is open-source software licensed under the [MIT license](https://github.com/Usbac/Wolff/blob/master/LICENSE).
