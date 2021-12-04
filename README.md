<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Addresses
## Requirements
- Local Server (Laragon, Xamp, etc...)
- Composer
- MySQL
- In case you do not have a local server, run the command (when installing dependencies):
```
php artisan serve
```
## Installation
Create database, run the following commands:
- Login to MySQL
```
mysql -u {USER} -p {PASSWORD}
```
- Or Default User
```
mysql -u root -p

```
- Create Data Base
```
mysql CREATE DATABASE addresses;
```
- In the project folder, execute the following commands

Install project dependencies
```
composer install
```

Run migrations and seeders
```
php artisan migrate:fresh --seed
```

# End Points
Request that returns records from the state table.
Optional parameters:
- limit: Sets a limit on the response (integer).
- page: Sets what the current page is (integer).
```
GET /api/states?limit={limit}&page={page}
```


Request that returns records from the address table.
Optional parameters:
- limit: Sets a limit on the response (integer).
- page: Sets what the current page is (integer).
- code: Returns items with the same zip code (string).
- municipality: Returns elements with the same municipality (string).
- city: Returns items with the same city (string).
```
GET /api/addresses?limit={limit}&page={page}&code={zip_code}
            &=municipality={municipality}&=city={city}
```


# Test
To run the tests, execute the following command:
```
php artisan test
```

# Demo
- States
https://addresses.adsnetlog.com/api/states?limit=40&page=2
- Address
https://addresses.adsnetlog.com/api/addresses?limit=5&page=2
- Zip Code
https://addresses.adsnetlog.com/api/addresses?code=06143
- Municipality
https://addresses.adsnetlog.com/api/addresses?municipality=nihil
- city
  https://addresses.adsnetlog.com/api/addresses?city=South%20Kristofershire
