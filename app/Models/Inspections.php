<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspections extends Model
{
   
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'case_id',
        'type',
        'requested_by',
        'start_ts',
        'location',
        'checks',
        'assigned_to',
        'risk_level',
        'risk_flag',
        'decision',
        'comments',
        'justifications',
        'end_ts',
    ];

    protected $casts = [
        'checks' => 'array',
        'start_ts' => 'datetime',
    ];

    public function case()
    {
        return $this->belongsTo(Cases::class, 'case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
