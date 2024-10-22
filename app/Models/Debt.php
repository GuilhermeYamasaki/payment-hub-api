<?php

namespace App\Models;

use App\Enums\DebtStatusEnum;
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
        'due_date',
        'status_enum',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'status_enum' => DebtStatusEnum::class,
        ];
    }
}
