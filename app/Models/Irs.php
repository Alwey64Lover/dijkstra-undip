<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PDO;

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

    public function irsDetails(){
        return $this->hasMany(irsDetail::class);
    }

    public function herRegistration(){
        return $this->belongsTo(herRegistration::class);
    }
}
