<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malico\LaravelNanoid\HasNanoids;

class ImcProgram extends Model
{
    use HasFactory, HasNanoids, SoftDeletes;
    protected $guarded = [];
    protected $dates = ['created_at', 'udated_at', 'deleted_at'];

    public function subPrograms()
    {
        return $this->hasMany(ImcSubProgram::class, 'program_id', 'id');
    }
}
