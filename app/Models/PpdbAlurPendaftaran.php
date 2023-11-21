<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malico\LaravelNanoid\HasNanoids;

class PpdbAlurPendaftaran extends Model
{
    use HasFactory, SoftDeletes, HasNanoids;
    protected $guarded =  [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $incrementing = false;
    protected $keyType = 'string';
    protected $nanoidAlphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
}
