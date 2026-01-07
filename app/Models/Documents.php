<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'case_id',
        'filename',
        'mime_type',
        'category',
        'pages',
        'uploaded_by',
    ];

    public function case()
    {
        return $this->belongsTo(Cases::class, 'case_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
