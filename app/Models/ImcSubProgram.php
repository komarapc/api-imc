<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malico\LaravelNanoid\HasNanoids;

class ImcSubProgram extends Model
{
    use HasFactory, HasNanoids, SoftDeletes;

    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function program()
    {
        return $this->belongsTo(ImcProgram::class, 'program_id', 'id');
    }

    public function subProgramGaleries()
    {
        return $this->hasMany(ImcSubProgramGalery::class, 'sub_program_id', 'id');
    }
}
