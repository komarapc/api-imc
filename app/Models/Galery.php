<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malico\LaravelNanoid\HasNanoids;

class Galery extends Model
{
    use HasFactory, HasNanoids, SoftDeletes;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $keyType = 'string';
    public $incrementing = false;

    public function jenjang()
    {
        return $this->belongsTo(GenericCode::class, 'generic_code_id', 'generic_code_id');
    }

    public function galery_files()
    {
        return $this->hasMany(GaleryFile::class, 'galery_id', 'id');
    }
}
