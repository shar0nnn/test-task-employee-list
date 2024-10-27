<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    const PHOTO_PATH = 'images/';

    protected $fillable = [
        'full_name', 'position_id', 'manager_id', 'hired_at',
        'phone', 'email', 'salary', 'photo', 'rank', 'admin_created_id',
        'admin_updated_id'
    ];

    protected $casts = [
        'created_at' => 'date:d.m.Y',
        'updated_at' => 'date:d.m.Y',
        'hired_at' => 'date'
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function photoPath(): Attribute
    {
        return Attribute::make(
            fn() => self::PHOTO_PATH . $this->id . '/'
        );
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }
}
