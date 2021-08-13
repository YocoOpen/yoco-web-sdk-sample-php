# Yoco Sample Implementations

This project provides PHP sample implementations that show how to integrate our payment gateway into custom built websites.

The following implementations are provided

  * [vanilla-app](#vanilla-app "vanilla-app"): a simple stand-alone PHP implementation
  * [laravel-app](#laravel-app "laravel-app"): a basic Laravel implementation

The `vanilla-app` uses our simple PHP client library ([yoco/yoco-php](https://github.com/YocoOpen/yoco-php)), while the `laravel-app` uses a wrapper for the client library ([yoco/yoco-php-laravel](https://github.com/YocoOpen/yoco-php-laravel)). Both libraries are available as composer packages.


## Inline and Popup Demos

Running the samples below will show demos for the inline and popup card forms.

| Inline Form | Popup Form |
| ------ | ------ |
| ![Inline Payment](https://raw.githubusercontent.com/YocoOpen/yoco-web-sdk-sample-php/main/docs/inline.gif) | ![Popup Payment](https://raw.githubusercontent.com/YocoOpen/yoco-web-sdk-sample-php/main/docs/popup.gif) |

On the right-hand side of the screen we provide a panel with test credit card details, the currently configured API keys, and an activity monitor for logging out debug information.

<a name="vanilla-app"></a>
## Vanilla Implementation

To run the stand-alone PHP implementation, clone this repository, run [composer](https://getcomposer.org/) install, and run the built-in PHP server as follows:

```bash
git clone https://github.com/YocoOpen/yoco-web-sdk-sample-php.git
cd yoco-web-sdk-sample-php/vanilla-app
composer install
php -S localhost:8000
````
Now visit http://localhost:8000 in your browser and try out the demos!

### Configuring API Keys

By default, the implementation uses our documentation\'s [global test keys](https://developer.yoco.com/online/resources/testing-info).  These keys can be changed by editing the values in
`lib/config.php`.

### Main Files

Here is a description of the main files in the `vanilla-app`:

  * `yoco/demo/chooser/index.php`: the landing page
  * `yoco/demo/inline/index.php`: the inline payment form
  * `yoco/demo/popup/index.php`: the popup payment form
  * `yoco/charge/index.php`: handles the back-end charge call

<a name="laravel-app"></a>
## Laravel Implementation

To run the Laravel implementation, clone this repository, run [composer](https://getcomposer.org/) install, setup the environment, and use `artisan` to run the internal PHP server:

```bash
git clone https://github.com/YocoOpen/yoco-web-sdk-sample-php.git
cd yoco-web-sdk-sample-php/laravel-app
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
````

Now visit http://localhost:8000 in your browser and try out the demos!

### Configuring API Keys

By default, the implementation uses our documentation\'s [global test keys](https://developer.yoco.com/online/resources/testing-info).  These keys can be changed by editing the values in
`config/yoco.php`.

### Main Files

Here is a description of the main files in the `laravel-app`:

  * `resources/views/yoco/demo/chooser.blade.php`: the landing page
  * `resources/views/yoco/demo/inline.blade.php`: the inline payment form
  * `resources/views/yoco/demo/popup.blade.php`: the popup payment form
  * `app/Http/Controllers/ChargeController.php`: handles the back-end charge call


## Libraries

The client libraries used in these implementations have their own documentation, which can be found at:

  * [yoco/yoco-php](https://github.com/YocoOpen/yoco-php)
  * [yoco/yoco-php-laravel](https://github.com/YocoOpen/yoco-php-laravel)
  
