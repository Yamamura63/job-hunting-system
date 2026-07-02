<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    protected $fillable = [
            'user_id',
            'name',
            'level',
            'address',
            'industry',              
            'salary',
            'start_time',    
            'end_time',
            'break_time',
            'training_period',
            'ses_level',
            'benefits_memo',
            'free_memo',
        ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function urls(): HasMany
    {
        return $this->hasMany(CompanyUrl::class);
    }

    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class);
    }

    public function selection(): HasOne
    {
        return $this->hasOne(Selection::class);
    }
}
