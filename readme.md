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

#Usages

#Validation available
1. Required as `required`
2. Maximum Value as `max:size`
3. Minimum Value as `min:size`
4. Digits Between as `digits_between:min,max`
5. Maximum Length as `len:max`
6. Minimum Length as `len:min`
7. Length Between as `len_between:min,max`
8. Email as `email`
9. URL as `url`
10. Date as `date:formate`
11. Is Number URL as `num`
12. Digits Only as `digits`
13. Credit Card as `cc`
14. Equal To as `equalTo`
15. Remote Validation as `remote`