<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
 
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'plate_no',
        'country',
        'make',
        'model',
        'vin',
    ];

    public function cases()
    {
        return $this->hasMany(Cases::class, 'vehicle_id');
    }
}
