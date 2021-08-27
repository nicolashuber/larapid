<?php

namespace App\Larapid\Entities;

use App\Larapid\Fields\Password;
use App\Larapid\Fields\Text;
use App\Models\User;

class UserEntity extends Entity
{
    /**
     * Entity model
     *
     * @var string
     */
    public static $model = User::class;

    /**
     * Define entity fields.
     *
     * @return array
     */
    public function fields() {
        return [
            Text::make('Name')->placeholder('Name')->validators('required'),
            Text::make('Email')->placeholder('Email')->validators('required|email'),
            Password::make('Password')->placeholder('Password')->validators('required|confirmed'),
        ];
    }
}
