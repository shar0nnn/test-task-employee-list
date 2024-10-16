<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'position_id', 'manager_id', 'hired_at',
        'phone', 'email', 'salary', 'photo', 'admin_created_id',
        'admin_updated_id'
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
