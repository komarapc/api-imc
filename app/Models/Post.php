<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Malico\LaravelNanoid\HasNanoids;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasNanoids;
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $nanoidLength = 21;
    protected $nanoidAlphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public $keyType = 'string';
    public $incrementing = false;

    public function typePost()
    {
        return $this->belongsTo(GenericCode::class, 'type_post_id', 'generic_code_id');
    }

    public function category()
    {
        return $this->belongsTo(GenericCode::class, 'category_id', 'generic_code_id');
    }

    public function status()
    {
        return $this->belongsTo(GenericCode::class, 'status_id', 'generic_code_id');
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by', 'id');
    }
}
