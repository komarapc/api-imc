<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malico\LaravelNanoid\HasNanoids;

class GaleryFile extends Model
{
    use HasFactory, HasNanoids, SoftDeletes;

    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $keyType = 'string';
    public $incrementing = false;

    public function galery()
    {
        return $this->belongsTo(Galery::class, 'galery_id', 'id');
    }
}
