# Teapplix Laravel Package

## Installation

> Compatible with Laravel 8.x and above

We recommend installing the package locally using the following command:

```bash
composer require thank-song/teapplix
> 适配 Laravel 8.x 及以上版本

```

## ⚙️ 配置 Configuration
直接在环境文件(.env)中新增  `TEAPPLIX_API_TOKEN=93***-*****-*****-*****-*****-*****-*9d3` 变量：

或发布配置文件到主项目：

```bash
php artisan vendor:publish --tag=teapplix
```

在 `config/teapplix.php` 中配置：

```php
return [
    // 使用 .env 中的配置自动初始化
    'api_token'=>env('TEAPPLIX_API_TOKEN','YOUR-API-TOKEN-HERE')
];
```

## 🚀 使用方式 Usage

### 📝 示例：获取产品列表
```php

use ThankSong\Teapplix\Teapplix;

$res = Teapplix::getProducts();
dump($res -> getData());
dump($res -> getPage());
dump($res -> getPageSize());
dump($res -> hasMore());
```
## 📚 License

MIT
