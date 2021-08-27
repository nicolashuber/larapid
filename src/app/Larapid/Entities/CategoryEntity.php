<?php

namespace App\Larapid\Entities;

use App\Larapid\Fields\Text;
use App\Models\Category;

class CategoryEntity extends Entity
{
    /**
     * Entity model
     *
     * @var string
     */
    public static $model = Category::class;

    /**
     * Define entity fields.
     *
     * @return array
     */
    public function fields() {
        return [
            Text::make('Name')->placeholder('Name')->validators('required')
        ];
    }
}
