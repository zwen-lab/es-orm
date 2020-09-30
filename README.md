ES-ORM
======

ES-ORM 是通过ORM的方式查询ElasticSearch的工具类，无须编写写繁琐的DSL语句等，直接通过ORM的方式进行查询。


### 安装

使用 Composer 安装:

```
composer require zwen-lab/es-orm v0.0.1
```

### 使用（laravel）

1.添加provider

```php
\Zwen\EsOrm\EsServiceProvider::class,
```

2.配置门面

```php
'ES' => Zwen\EsOrm\Support\Facades\ES::class,
```

3.发布配置文件 elasticsearch.php

```
 php artisan vendor:publish
```

4.配置文件修改

```php
return [
    /**
     * es的版本号
     */
    'version' => '5.x',

    /**
     * es地址
     */
    'host' => ['127.0.0.1:80'],
];
```



5.查询Elasticsearch

```php
//DSL直接查询
$result = \ES::select($dsl)
		
//支持分页
$result = \ES::table('index-20200914/flow_type')->where('host', 'www.baidu.com')->where('create_time', '>=', 1600048800)->where('create_time', '<=', 1600049100)->forPage(11,1)->get();
$result = \ES::table('index-20200914/flow_type')->where('host', 'www.baidu.com')->where('create_time', '>=', 1600048800)->where('create_time', '<=', 1600049100)->offset(10)->limit(1)->get();

//指定返回的字段
$result = \ES::table('index-20200914/flow_type')->where('host', 'www.baidu.com')->get(['country', 'create_time', 'req_flow']);
$result = \ES::table('index-20200914/flow_type')->where('host', 'www.baidu.com')->select(['country', 'create_time', 'req_flow'])->get();
		
//group by
$result = \ES::table('index-20200914/flow_type')->where('host', 'www.baidu.com')->where('create_time', '>=', 1600048800)->where('create_time', '<=', 1600049100)->groupBy(['create_time', 'mtype'])->get();
		
//group by sum
$result = \ES::table('index-20200914/flow_type')->where('host', 'www.baidu.com')->where('create_time', '>=', 1600048800)->where('create_time', '<=', 1600049100)->groupBy(['create_time', 'mtype'])->selectRaw('create_time,mtype,sum(req_flow) as req_flow,sum(flow) as flow')->get();
$result = \ES::table('index-20200914/flow_type')->where('host', 'www.baidu.com')->where('create_time', '>=', 1600048800)->where('create_time', '<=', 1600049100)->groupBy(['create_time', 'mtype'])->selectRaw('create_time,mtype,sum(req_flow) as req_flow')->get();
```

#### 说明

在 v0.* 版本中暂时还不支持ORM的方式进行Elasticsearch操作，v0.*版本目前已经完成了通过查询构造器的进行Elasticsearch查询, 在v1.0 以上版本中会支持ORM的方式进行查询，v1.0版本正在开发中。



#### 交流

QQ:291235020

