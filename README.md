

<h1 align="center">Laravel general-db</h1>

<p align="center">:heart: This package helps you smiple CRUD</p>

<p align="center">
<a href="https://packagist.org/packages/dongm2ez/general-db"><img src="https://poser.pugx.org/dongm2ez/general-db/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/dongm2ez/general-db"><img src="https://poser.pugx.org/dongm2ez/general-db/v/unstable.svg" alt="Latest Unstable Version"></a>
<a href="https://packagist.org/packages/dongm2ez/general-db"><img src="https://poser.pugx.org/dongm2ez/general-db/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/dongm2ez/general-db"><img src="https://poser.pugx.org/dongm2ez/general-db/license" alt="License"></a>
</p>

# Requirement

- PHP >= 7.0

# Installation

```shell
$ composer require dongm2ez/general-db
```

After installing the library, register the `Dongm2ez\Db\DbServiceProvider` in your `config/app.php` file:

  ```php
  'providers' => [
      // Other service providers...
      Dongm2ez\Db\DbServiceProvider::class,
  ],
  ```

As optional if you want to modify the default configuration, you can publish the configuration file:

```shell
$ php artisan vendor:publish --provider='Dongm2ez\Db\DbServiceProvider' --tag="config"
```

# Usage

```php

<?php 

namespace App\Repositories;

class ExampleRepository extends \Dongm2ez\Db\AbstractRepository
{
    protected function init() 
    {
        $this->model = new ExampleModel();
    }
}
```

```php
<?php 

namespace App\Services;

class ExampleService extends \Dongm2ez\Db\AbstractService
{
    public function getAllList($params)
    {
        $extends = $this->listParamsFormat($params);
        $input = $this->listFillableFromArray($params, [
            'id',
            'user_id',
            'create_at',
            'update_at',
        ]);

        $result = (new \App\Repositories\ExampleRepository())->getList(array_merge($input, ['_extends' => $extends]));

        return $result;
    }
}

```

```php
<?php

namespace App\Http\Controller;


class ExampleController extends Controller 
{
    public function lists(Request $request)
    {
        $masterData = (new \App\Services\ExampleService)->getAllList($request->all());
    }
}
```

# License

MIT