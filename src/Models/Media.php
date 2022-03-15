<?php

namespace Internexus\Larapid\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'url',
        'mime_type',
        'width',
        'height',
        'filesize',
        'group_id',
    ];

    public function resizes()
    {
        return $this->hasMany(MediaResize::class);
    }
}
