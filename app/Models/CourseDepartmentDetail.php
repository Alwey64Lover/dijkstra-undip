<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class CourseDepartmentDetail extends Model
{
    use HasFactory,
        HasUlids,
        SoftDeletes,
        HasJsonRelationships;

    protected $guarded = [
        'id', 'created_at'
    ];

    public const STATUSES = [
        'mandatory' => 'Wajib',
        'optional' => 'Pilihan',
    ];

    protected $casts = [
        'lecturer_ids' => 'json',
    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function courseClasses(){
        return $this->hasMany(CourseClass::class);
    }
    public function courseDepartment(){
        return $this->belongsTo(CourseDepartment::class);
    }

    public function lecturers(){
        return $this->belongsToJson(Lecturer::class, 'lecturer_ids', 'id');
    }
}
