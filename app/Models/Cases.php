<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model {
   
    protected $fillable = [
        'id',
        'external_ref',
        'status',
        'priority',
        'arrival_ts',
        'checkpoint_id',
        'origin_country',
        'destination_country',
        'risk_flags',
        'declarant_id',
        'consignee_id',
        'vehicle_id',
        'hs_code',
    ];


    protected $casts = [
        'risk_flags' => 'array',
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicles::class, 'vehicle_id');
    }

    public function declarant() {
        return $this->belongsTo(Parties::class, 'declarant_id');
    }

    public function consignee() {
        return $this->belongsTo(Parties::class, 'consignee_id');
    }

    public function inspections() {
        return $this->hasMany(Inspections::class, 'case_id');
    }

    public function documents() {
        return $this->hasMany(Documents::class, 'case_id');
    }
}

