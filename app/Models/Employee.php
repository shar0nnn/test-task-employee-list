<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    const PHOTO_PATH = 'images/';

    protected $fillable = [
        'full_name', 'position_id', 'manager_id', 'hired_at',
        'phone', 'email', 'salary', 'photo', 'rank', 'admin_created_id',
        'admin_updated_id'
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function photoPath(): Attribute
    {
        return Attribute::make(
            fn() => self::PHOTO_PATH . $this->id . '/'
        );
    }
}
