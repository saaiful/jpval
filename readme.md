# Jpval

Jquery and Laravel Server Side Validation.
### Installation
Begin by installing this package through Composer. Edit your project's `composer.json` file to require `saaiful/jpval` and then install using `composer update` / `composer install`
```
"require": {
    ...
    "saaiful/jpval": "dev-master"
}
```

You need to add following line at `config/app.php` in `providers` array:

```
'Saaiful\Jpval\JpvalServiceProvider',
```

Now add the alias.
```
'Jpval' => 'Saaiful\Jpval\Facades\Jpval',
```

For testing use default show method (Auto Generated) as Following
```
return Jpval::show();
```