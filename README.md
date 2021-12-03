# Goers Trial Day - Backend Engineer

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

This repository is a pretest backend engineer Goers. This project contains a web service with a RESTful API type developed using the Lumen Microframework.

```
   ...    *    .   _  .
*  .  *     .   * (_)   *
  .      |*  ..   *   ..
   .  * \|  *  ___  . . *
*   \/   |/ \/{o,o}     .
  _\_\   |  / /)  )* _/_ *
      \ \| /,--"-"---  ..
_-----`  |(,__,__/__/_ .
       \ ||      ..
        ||| .            *
        |||
goers   |||
  , -=-~' .-^- _
```

## Requirements
 - [PHP v7.3+|v8.0+](https://www.php.net/)
 - [Composer](https://yarnpkg.com/en/docs/install)
 - [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth)
 - [laravel-validation-rules/credit-card](https://github.com/laravel-validation-rules/credit-card)

## Getting started
### Clone the repo:
```bash
git clone --depth 1 https://github.com/denikn/goers-trial-day
cd goers-trial-day
rm -rf .git
```

### Set environment variables:
```bash
cp .env.example .env
```

### Install dependencies:
```bash
composer install
```

### Database migration and seed:
```bash
php artisan migrate
php artisan db:seed
```

### Generate JWT secret:
```bash
php artisan jwt:secret
```

### Running locally:
```bash
php -S localhost:8000 -t public
```

## Documentation
This documentation uses postman.

<a href="https://documenter.getpostman.com/view/3134681/UVJhCEEP" target="_blank">
Goers Trial Day RESTful API Documentation
</a>

## Assumptions
```
1. Assuming the image and avatar already exist
2. Users make payments using credit or debit cards
3. Credit or debit cards used are Visa and Master Card
4. Gender must choose between men and women
5. There is no voucher or discount, so the discount value is 0
6. The user has received the information via email
```

## License and Copyright

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).