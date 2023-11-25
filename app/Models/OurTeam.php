<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malico\LaravelNanoid\HasNanoids;

class OurTeam extends Model
{
    use HasFactory, SoftDeletes, HasNanoids;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $nanoidLength = 21;
    protected $nanoidAlphabet = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    protected $hidden = ['profile_picture'];
}
