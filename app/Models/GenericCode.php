<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GenericCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $primaryKey = 'generic_code_id';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $keyType = 'string';
    public $incrementing = false;
    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'generic_code_id', 'generic_code_id');
    }
}
