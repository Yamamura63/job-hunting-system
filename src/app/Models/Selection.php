<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Selection extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'step',
        'selection_datetime',
        'place',
        'station',
        'carfare',
        'carfare_price',
        'clothing',
        'items',
        'free_memo',
        'result_period',
        'status',
    ];

    protected $casts = [
        'selection_datetime' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
