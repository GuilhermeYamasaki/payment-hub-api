<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Debt extends Model
{
    use HasFactory, HasUuids, Notifiable;

    protected $fillable = [
        'id',
        'name',
        'government_id',
        'email',
        'amount',
        'due_date_at',
        'notify_at',
        'generate_slip_at',
    ];

    protected function casts(): array
    {
        return [
            'government_id' => 'integer',
            'due_date_at' => 'datetime',
            'notify_at' => 'datetime',
            'generate_slip_at' => 'datetime',
        ];
    }
}
