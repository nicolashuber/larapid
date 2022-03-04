# Larapid

A simple free alternative for Laravel Nova.

*Working in progress*

## Install

```
composer require internexus/larapid
```

## Usage

### Create a service provider
```php
<?php

namespace App\Providers;

use App\Entities\UserEntity;
use Illuminate\Support\ServiceProvider;
use Internexus\Larapid\Facades\Larapid;

class LarapidServiceProvider extends ServiceProvider
{
    public function register()
    {
        Larapid::entities([
            UserEntity::class,
        ]);
    }
}
```

### Create an entity
```php
<?php

namespace App\Entities;

use App\Models\User;
use Internexus\Larapid\Entities\Entity;
use Internexus\Larapid\Fields\Text;

class UserEntity extends Entity
{
    public static $model = User::class;

    public static $title = 'Usuários';

    public function fields() {
        return [
            Text::make('Nome', 'name')->rules('required'),
        ];
    }
}
```
