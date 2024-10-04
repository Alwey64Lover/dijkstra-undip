<?php

namespace App\Models;
use App\Models\CourseDepartmentDetail;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory,
        HasUlids,
        SoftDeletes;

    protected $guarded = [
        'id', 'created_at'
    ];

    public function courseDepartmentDetail(){
        return $this->hasMany(CourseDepartmentDetail::class);
    }
}
