<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parties extends Model
{
    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'type',
        'name',
        'reg_code',
        'vat',
        'country',
        'email',
        'phone',
    ];

    public function casesAsDeclarant()
    {
        return $this->hasMany(Cases::class, 'declarant_id');
    }

    public function casesAsConsignee()
    {
        return $this->hasMany(Cases::class, 'consignee_id');
    }
}

