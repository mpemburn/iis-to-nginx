# IIS to Nginx

A Laravel project to convert IIS web.config files into redirect format for `nginx`.

## Requirements:
**IIS to Nginx** was created in **Laravel version 11.x** and requires the following:

* **PHP** >= 8.1
* **Composer** >= 2.5.5
* **npm** >= 9.7.2

## Installation:
Install **IIS to Nginx** locally with the following command:

`git clone git@github.com:mpemburn/iis-to-nginx.git`

Change to the `iis-to-nginx` directory and run:

`composer install`

...to install the PHP dependencies.

`npm install`

...to install modules needed to compile the JavaScript and CSS assets.

`npm run build`

...to do the asset compiling.

Copy `.env.example` to `.env` and make all necessary changes.

You will need to run a web server to run **IIS to Nginx** in a browser.
I recommend [**Laravel Valet**](https://laravel.com/docs/10.x/valet), but you can do it simply by going to the project
directory and running:

`php artisan:serve`

This will launch a server on `http://127.0.0.1:8000`

## How it Works:

- When you have **IIS to Nginx** running in a browser, click the **Choose File** (or **Browse**) button the select your `web.config` file.
- By default, the output file will be called `redirect.conf`, but you can call it anything you like.
- Click the **Convert** button to do the conversion.  If everything is good, you'll see the **Download** button.
- Click the **Download** button, and your converted file will download.
- That's it!

The **Clear** button will let you begin again.

**IIS to Nginx** uses a version of a Python script ported to PHP.  You can see the original here:
https://github.com/ismai1/iis-to-nginx/tree/master
