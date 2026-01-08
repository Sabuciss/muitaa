<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'can_view_documents',
        'can_view_inspections',
        'can_view_vehicles',
        'can_view_cases',
    ];

    protected $casts = [
        'can_view_documents' => 'boolean',
        'can_view_inspections' => 'boolean',
        'can_view_vehicles' => 'boolean',
        'can_view_cases' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
