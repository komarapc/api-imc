<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Malico\LaravelNanoid\HasNanoids;

class Banner extends Model
{
    use HasFactory, HasNanoids;

    protected $fillable = [
        'title',
        'description',
        'video_url'
    ];

    protected $casts = [
        'id' => 'string'
    ];
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
