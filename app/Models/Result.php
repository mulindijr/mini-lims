<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Result extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'lab_test_id',
        'result_value',
        'reference_range',
        'remarks',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Log only fillable fields
            ->logOnlyDirty() // Log only changed fields
            ->dontSubmitEmptyLogs() // Don't log if there are no changes
            ->setDescriptionForEvent(fn(string $eventName) => "Result record has been {$eventName}"); // Customize the log description for better readability
    }

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
