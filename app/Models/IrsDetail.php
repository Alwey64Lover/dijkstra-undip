<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IrsDetail extends Model
{
    use HasFactory,
        HasUlids,
        SoftDeletes;

    protected $guarded = [
        'id', 'created_at'
    ];


    public function khss(){
        return $this->hasMany(khs::class);
    }

    public function irs(){
        return $this->belongsTo(irs::class);
    }

    public function courseClass(){
        return $this->belongsTo(CourseClass::class);
    }
}
