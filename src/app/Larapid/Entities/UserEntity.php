<?php

namespace App\Larapid\Entities;

use App\Larapid\Fields\Password;
use App\Larapid\Fields\Text;
use App\Models\User;

class UserEntity extends Entity
{
    public static $model = User::class;

    public function fields() {
        return [
            Text::make('Name')->validators('required'),
            Text::make('Email'),
            Password::make('Password'),
        ];
    }
}
