

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

## 传值格式

`字段{条件}=值`

条件不传默认为 = 查询

例子：

`id{!}=1`,意思为取 id 不等于1的所有

## 支持查询条件

###一元查询

`{>}` 大于，`?pay_money{>}=100`

`{ge}` 大于等于, `?pay_money{ge}=100`

`{<}` 小于, `?pay_money{<}=100`

`{le}` 小于等于, `?pay_money{le}=100`

`{!}` 不等于, `?pay_money{!}=100`

`{~}` like 查询, `?pay_money{~}=100`

`{!~}` not like 查询, `?pay_money{!~}=100`

`{#}` is null 查询, `?delete_at{#}=nulll`,表示`delete_at is null`

`{!#}` is not null 查询, `?delete_at{!#}=null`,表示`delete_at is not null)`

### 二元查询

`{<>}` between 查询, `?create_date{<>}=2017-10-01,2017-10-02`,表示`create_date between(2017-10-01,2017-10-02)`

`{><}` not between 查询, `?create_date{><}=2017-10-01,2017-10-02`,表示`create_date not between(2017-10-01,2017-10-02)`

### 多元查询

订单合单类型在做 `{@}`、`{!@}` 查询时使用 `**` 表示中间连接符，如 `goods,event**goods` 表示查询商品与活动和商品合单

`{@}` in 查询, `?id{@}=1,2,3,4`,表示`id IN(1,2,3,4)`

`{!@}` not in 查询, `?id{!@}=1,2,3,4`,表示`id IN(1,2,3,4)`

### 扩展条件

`_page` 页码，默认1

`_limit` 分页大小，默认15

`_sort` 排序字段，默认id

`_order` 排序方式，默认DESC

`_group` 分组字段，默认空

`_fields` 查询字段，默认 *

`_type` 查询类型，列表默认 page 分页，可选 offset 方式

`_version` 版本，默认 V1

用法：

?_type=offset&_page=200&_limit=10 偏移量模式，_page 是偏移量，_limit 是取多少

# License

MIT
