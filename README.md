<p align="center">
    <a href="https://www.vecteezy.com/free-vector/medicine-bag" target="_blank">
        <img src="https://github.com/mpernia/pouch-scanner/blob/main/docs/pouches.png" style="width: 100%" alt="POUCH SCANNER" title="Image Medicine Bag Vectors by Vecteezy">
    </a>
</p>
<h1 align="center">Pouch Scanner</h1>
<p align="center">
    <a href="https://www.php.net/">
        <img src="https://img.shields.io/badge/PHP-8.1-blue.svg?style=flat&logo=php&logoColor=white&logoWidth=20" alt="PHP">
    </a>
    <a href="https://laravel.com/"> 
        <img src="https://img.shields.io/badge/Laravel-9.1-blue.svg?style=flat&logo=laravel&logoColor=white&logoWidth=20" alt="Laravel">
    </a>
  <a href="https://github.com/mpernia/pouch-scanner/blob/main/LICENSE">
        <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
    </a>
    <a href="#">
        <img src="https://img.shields.io/badge/Version-1.0.2-orange.svg" alt="License">
    </a>
</p>




This repository is developed for Laravel Framework 9 or higher.

## Contents

- [Contents](#contents)
- [Installation](#installation)
- [Configuration](#configuration)
  - [Host connection](#host-connection)
  - [Storage settings](#storage-settings)
  - [Publish files](#publish-files)
- [Demo](#demo)

## Installation
* Create a new Laravel project with the following command:
    ```shell
    composer create-project laravel/laravel project-name
    ```
* Open your project installation root directory in the terminal and run:
    ```sh
    composer require mpernia/pouch-scanner
    ```


## Configuration



### Host connection


```php
$connection = new Connection(
    hostname: 'slim',
    username: 'admin',
    password: 'password',
    protocol: 'http',
    port: 8080
);

```


### Storage settings

```php
$settings = new StorageSetting(
    storageDirectory:'roll-requests',
    downloadImageDirectory: 'pouch-images',
    storageDisk: 'local',
    storageRequest: true,
    downloadImages: true
);

```





### Publish files
The **vendor:publish** command is used to publish any assets that are available from third-party vendor packages.

The following commands lists and describes each of:
* Config
    ```sh
    php artisan vendor:publish --tag=pouch-scanner-config
    ```





## Demo

[Pouch Scanner Demo](https://github.com/mpernia/demo-pouch-scanner/)

