<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseDepartment extends Model
{
    use HasFactory,
        HasUlids,
        SoftDeletes;

    protected $guarded = [
        'id', 'created_at'
    ];

    public const ACTIONS = [
        'waiting',
        'accepted',
        'rejected',
    ];

    public function courseDepartmentDetails(){
        return $this->hasMany(CourseDepartmentDetail::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
