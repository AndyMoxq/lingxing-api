# LingXing Laravel Package

## Installation

> Compatible with Laravel 8.x and above

We recommend installing the package locally using the following command:

```bash
composer require thank-song/lingxing
> 适配 Laravel 8.x 及以上版本

```

## ⚙️ 配置 Configuration
直接在环境文件(.env)中新增  
`LINGXING_APP_ID=YOUR-APP-ID-HERE` ,
`LINGXING_APP_SECRET=YOUR-APP-SECRET-HERE`

或发布配置文件到主项目：

```bash
php artisan vendor:publish --tag=lingxing
```

在 `config/lingxing.php` 中配置：

```php
return [
    // 使用 .env 中的配置自动初始化
    'appId'=>env('LINGXING_APP_ID','YOUR-APP-ID-HERE'),
    'appSecret'=>env('LINGXING_APP_SECRET','YOUR-APP-SECRET-HERE'),
    'host' => env('LINGXING_HOST','https://openapi.lingxing.com')
];
```

## 🚀 使用方式 Usage

### 📝 示例：获取产品列表
```php

use ThankSong\LingXing\LingXing;

$res = LingXing::getProducts();
dump($res -> getData());
dump($res -> hasMore());
```
## 📚 License

MIT
