<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    /**
     * Primary key is a string `id` (not auto-incrementing).
     */
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'id',
        'plate_no',
        'country',
        'make',
        'model',
        'vin',
    ];

    /**
     * Cases associated with this vehicle.
     * Note: ensure `cases` table has a `vehicle_id` column.
     */
    public function cases()
    {
        return $this->hasMany(Cases::class, 'vehicle_id');
    }
