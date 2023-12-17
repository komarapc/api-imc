<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malico\LaravelNanoid\HasNanoids;

class ImcSubProgramGalery extends Model
{
    use HasFactory, HasNanoids, SoftDeletes;

    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function subProgram()
    {
        return $this->belongsTo(ImcSubProgram::class, 'sub_program_id', 'id');
    }
}
