<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lab_test_id',
        'result_value',
        'reference_range',
        'remarks',
        'verified_by',
        'verified_at',
    ];

    // Relationships
    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
