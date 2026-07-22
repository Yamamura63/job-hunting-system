<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Internship extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'name',
        'start_datetime',
        'end_datetime',
        'place',
        'station',
        'content',
        'carfare',
        'lunch',
        'applied',
        'joined',
        'joined_memo'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'start_datetime' => 'datetime',
            'end_datetime' => 'datetime',
            'carfare' => 'boolean',
            'lunch' => 'boolean',
            'applied' => 'boolean',
            'joined' => 'boolean',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
