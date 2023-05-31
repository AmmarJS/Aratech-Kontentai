# Aratech-Kontentai

## Summary
A simple `Wrapper Class` to the already existing [Delivery Client](https://github.com/kontent-ai/delivery-sdk-php/tree/master) that is provided by the lovely people at the Kontent.ai team.

## Developers
Developed By [Ammar Jlies](https://github.com/AmmarJS), [Jimmy Jradeh](https://github.com/ssl3nd3r).

## Installation Process
You must have a Laravel Application before you can install this package.
After installing your laravel application you can run:

```sh
composer require aratech/kontentai
```

or adjust your `composer.json` file:

```sh
{
    "require": {
        "aratech/kontentai": "dev-main"
    }
}
```

## Create a Kontent-ai Client
Creating a `Kontent.ai Client` is simple and easy, start by adding your Kontent.ai project key to your .env file, and name it `KONTENT_AI_KEY`:
```php
KONTENT_AI_KEY = "8320c77c-2ed5-0020-97a8-2a6c956379d5"
```

Now, you can create a Kontent.ai Client and assign it to a variable ($app in the example below):
```php
use Aratech\Kontentai;

$app = Kontentai::createClient();
```

## Using our solution for querying
To query an item from your Kontent.ai project just use the -> operator:
```php
use Aratech\Kontentai;

$result = $app->about_us;
```

If you want to query multiple items, you can (almost) treat the querying process as if you are doing a query using the Laravel Query Builder Class:
```php
use Aratech\Kontentai;

$app->where("name", "article");
```
Returned type is a Kontentai Object (the same variable $app).

So, you can chain as many methods as you like on the $app client, and when you're done just use the fetch function to fetch the results:
```php
use Aratech\Kontentai;

$results = $app->language('es-ES')->where("name", "article")->fetch();
```
Returned type here is a Laravel collection conatining all the items that are returned from the query.

One `Special use case` we can do, is using the fetch method without any chained methods behind it:
```php
use Aratech\Kontentai;

$results = $app->fetch();
```
This will return all the items that are available in your Kontent.ai project.

## Available Methods
  `where($key, $value)`
  `find($id)`

## What's the idea behind this class?
The idea is to provide a way to chain methods on top of each other as if you are using the Laravel built-in Query Builder class.

You can also use the Methods that are already built in the DeliveryClient provided by Kontent-ai and chain them with our provided methods:
```php
use Aratech\Kontentai;

$results = $app->language('es-ES')->where("name", "article")->orderAsc('elements.product_name')->limit(10)->fetch();
```

# And That's it for now, Have fun!










