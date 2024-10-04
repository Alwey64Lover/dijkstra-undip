<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HerRegistration extends Model
{
    use HasFactory,
        HasUlids,
        SoftDeletes;

    protected $guarded = [
        'id', 'created_at'
    ];

    const STATUSES = [
        'active' => 'Aktif',
        'leave' => 'Cuti',
        'drop_out' => 'Keluar(DO)',
    ];
}
