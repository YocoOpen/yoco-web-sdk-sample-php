# Yoco Sample Implementations

This repo provides some samples of how to implement the Yoco payment gateway on your website.  The following implementations are provided

  * [vanilla-app](#vanilla-app "vanilla-app"), a simple, low-dependancy php stand alone implementation
  * [laravel-app](#laravel-app "laravel-app"), a small, laravel implementation

The vanilla-app implementation uses the [yoco/yoco-php](https://github.com/yoco/yoco-php) 
composer package and the laravel-app implementation uses the [yoco/yoco-php-laravel](https://github.com/yoco/yoco-php-laravel) composer package.


## Demo

Once you have run one of the samples below, you will be able to see demo's of the 2 frontend options interacting with the PHP backend.

| Inline Payment | Popup Payment |
| ------ | ------ |
| ![Inline Payment](https://gitlab.com/yoco/online-payments/yoco-web-sdk-sample-php/-/raw/develop/docs/inline.gif) | ![Popup Payment](https://gitlab.com/yoco/online-payments/yoco-web-sdk-sample-php/-/raw/develop/docs/popup.gif) |

<a name="vanilla-app"></a>
## Vanilla PHP Implementation

To run the stand alone php implementation, clone this repository, run [composer](https://getcomposer.org/) install and run the built in PHP server as follows

```bash
git clone https://github.com/yoco/yoco-web-sdk-sample-php.git
cd yoco-web-sdk-sample-php/vanilla-app
composer install
php -S localhost:8000
````
Now use your browser to go to http://localhost:8000 and run through the demo using the inline and popup payment variants.

### Configuring Keys

By default, the implementation uses the test keys from (https://developer.yoco.com/online/resources/testing-info).  These keys can be changed by editing

`lib/config.php`

The following files perform the following functions

  * `yoco/demo/chooser/index.php` loads the frontend chooser
  * `yoco/demo/inline/index.php` loads the inline payment demo
  * `yoco/demo/popup/index.php` loads the popup payment demo
  * `yoco/charge/index.php` handles the charge api call from the above demo payment pages

<a name="laravel-app"></a>
## Laravel PHP Implementation

To run the laravel php implementation, clone this repository, run [composer](https://getcomposer.org/) install, setup environment and use artisan to run the internal php server

```bash
git clone https://github.com/yoco/yoco-web-sdk-sample-php.git
cd yoco-web-sdk-sample-php/laravel-app
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
````

Now use your browser to go to http://localhost:8000 and run through the demo using the inline and popup payment variants.

### Configuring Keys

By default, the implementation uses the test keys from (https://developer.yoco.com/online/resources/testing-info).  These keys can be changed by editing

`config/yoco.php`

The following files perform the following functions

  * `resources/views/yoco/demo/chooser.blade.php` contains the frontend chooser
  * `resources/views/yoco/demo/inline.blade.php` contains the inline payment demo
  * `resources/views/yoco/demo/popup.blade.php` contains the popup payment demo
  * `app/Http/Controllers/ChargeController.php` handles the charge api call from the above demo payment pages

## Libraries

The libraries used in these implementations have their own documentation and are as follows

  * [yoco/yoco-php](https://github.com/yoco/yoco-php) for the vanilla php demo
  * [yoco/yoco-php-laravel](https://github.com/yoco/yoco-php-laravel) for the laravel demo
  
