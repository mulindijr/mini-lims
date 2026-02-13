<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sample extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'sample_code',
        'sample_type',
        'status',
        'received_at',
        'created_by',
    ];

    // Relationship to Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relationship to the User who created the sample record
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
