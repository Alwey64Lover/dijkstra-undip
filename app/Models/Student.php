<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory,
        HasUlids,
        SoftDeletes;

    protected $guarded = [
        'id', 'created_at'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function lecturer(){
        return $this->belongsTo(Lecturer::class, "academic_advisor_id");
    }

    public function herRegistrations(){
        return $this->hasMany(HerRegistration::class);
    }
}
