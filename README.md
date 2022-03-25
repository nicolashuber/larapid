# Larapid

![Status](https://img.shields.io/badge/Status-working%20in%20progress-1abc9c.svg "Status")
![Stars](https://img.shields.io/github/stars/nicolashuber/larapid.svg "Stars")

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white "Laravel")
![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D "Vue.js")


A simple free alternative for Laravel Nova.

## Install

### Installing via Composer
```
composer require internexus/larapid
```

### Publish packages resources
```
php artisan vendor:publish --tag=larapid
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
use Internexus\Larapid\Fields\Email;
use Internexus\Larapid\Fields\Password;
use Internexus\Larapid\Fields\Text;

class UserEntity extends Entity
{
    public static $model = User::class;

    public static $title = 'Usuários';

    public function fields() {
        return [
            Text::make('Nome', 'name')->rules('required'),
            Email::make('E-mail', 'email')->rules('required|email|max:255'),
            Password::make('Senha', 'password')->rules('required|min:6|max:255'),
        ];
    }
}
```

## Fields

### Text
```php
Text::make('Label', 'column')
```
### Date
```php
Date::make('Created at', 'created_at')
```
### Datetime
```php
Datetime::make('Created at', 'created_at')
```
### Boolean
```php
Boolean::make('Public')
```
### Email
```php
Email::make('E-mail')
```
### Password
```php
Password::make('Password')
```
### Url
```php
Url::make('Url')
```
### Money
```php
Money::make('Price')
```
### Number
```php
Number::make('Price')->min(10)->max(100)
```
### Select
```php
Select::make('Status')->options([1 => 'Approved', 2 => 'Cancelled'])
```
### Textarea
```php
Textarea::make('Content')
```
### Media
```php
Media::make('Featured image', 'media_id')
     ->accept(['jpg', 'png'])
     ->maxSize(100000) // in bytes
     ->minDimension(100, 100)
     ->maxDimension(1920, 1080)
```
### HasMany
```php
HasMany::make('User posts', 'user_id', PostEntity::class, 'posts')
```
### BelongsTo
```php
BelongsTo::make('User role', 'role_id', UserEntity::class)
```

## Available Fields methods

### Attributes
 - `help(string $text)`
 - `readOnly()`
 - `placeholder(string $placeholder)`

### Validations
 - `rules(array $rules)`
 - `creationRules(array $rules)`
 - `updateRules(array $rules)`

### Visibility
 - `showOnIndex()`
 - `showOnDetail()`
 - `showOnCreating()`
 - `showOnUpdating()`
 - `hideFromIndex()`
 - `hideFromDetail()`
 - `hideWhenCreating()`
 - `hideWhenUpdating()`
 - `onlyOnIndex()`
 - `onlyOnDetail()`
 - `onlyOnForms()`
 - `exceptOnForms()`

### Search and sort
 - `sortable()`
 - `searchable()`

## Available Entity methods
### Visibility
 - `fieldsForIndex()`
 - `fieldsForDetail()`
 - `fieldsForCreating()`
 - `fieldsForUpdating()`

### Actions
 - `enableEditing()`
 - `enableDetail()`
 - `enableDeleting()`

### Hooks
 - `beforeSaving()`
 - `afterCreated()`
 - `afterUpdated()`

### Redirects
 - `redirectAfterCreate(Model $model)`
 - `redirectAfterUpdate(Model $model)`
 - `redirectAfterDelete(Model $model)`
