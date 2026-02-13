<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabTest extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'sample_id',
        'test_name',
        'status',
        'assigned_to',
        'completed_at'
    ];

    protected static function booted()
    {
        static::creating(function ($test) {
            if (!$test->test_code) {
                $count = self::count() + 1;
                $test->test_code = 'SMP-TEST-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function sample()
    {
        return $this->belongsTo(Sample::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
