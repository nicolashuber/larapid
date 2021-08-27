<?php

namespace App\Larapid\Entities;

use App\Larapid\Fields\BelongsTo;
use App\Larapid\Fields\Text;
use App\Larapid\Fields\Textarea;
use App\Models\Post;

class PostEntity extends Entity
{
    /**
     * Entity model
     *
     * @var string
     */
    public static $model = Post::class;

    /**
     * Define entity fields.
     *
     * @return array
     */
    public function fields() {
        return [
            Text::make('Title')->placeholder('Title')->validators('required'),
            Textarea::make('Content')->validators('required'),
            BelongsTo::make('User'),
            BelongsTo::make('Category'),
        ];
    }
}
