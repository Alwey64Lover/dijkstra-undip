<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Irs extends Model
{
    use HasFactory,
        HasUlids,
        SoftDeletes;

    protected $guarded = [
        'id', 'created_at'
    ];

    public const STATUSES = [
        'opened' => 'Dibuka',
        'closed' => 'Ditutup',
    ];

    public const ACTIONS = [
        'waiting',
        'accepted',
        'rejected',
    ];
}
