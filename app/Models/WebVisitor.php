<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Malico\LaravelNanoid\HasNanoids;

class WebVisitor extends Model
{
    use HasFactory, HasNanoids;

    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'raw_data' => 'array',
    ];
    protected $keyType = 'string';
    public $incrementing = false;
    public $nanoidLength = 21;
    public $nanoidAlphabet = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    protected $hidden = ['raw_data'];
}
