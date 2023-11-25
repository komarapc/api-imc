<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malico\LaravelNanoid\HasNanoids;

class StatisticTeacherStudent extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $primaryKey = 'tahun_ajaran_kode';
    public $incrementing = false;
    protected $keyType = 'string';
}
