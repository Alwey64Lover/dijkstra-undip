<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseClass extends Model
{
    use HasFactory,
        HasUlids,
        SoftDeletes;

    protected $guarded = [
        'id', 'created_at'
    ];

    public const DAYS = [
        'monday' => 'Senin',
        'tuesday' => 'Selasa',
        'wednesday' => 'Rabu',
        'thursday' => 'Kamis',
        'friday' => 'Jumat',
    ];

    public function CourseDepartmentDetail(){
        return $this->belongsTo(CourseDepartmentDetail::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function irsInfo(){
        return $this->hasMany(IrsDetail::class);
    }

    public function irsDetail()
    {
        return $this->hasMany(IrsDetail::class)
            ->where('irs_id', activeIrs()->id)
            ->whereHas('irs', function($query) {
                $query->whereHas('herRegistration', function($query) {
                    $query->where('student_id', user()->student->id);
                });
            });
    }
}
