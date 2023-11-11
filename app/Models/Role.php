<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Malico\LaravelNanoid\HasNanoids;

class Role extends Model
{
    use HasFactory;
    use HasNanoids;

    protected $guarded = [];
}
