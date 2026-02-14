<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LabTest extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'sample_id',
        'test_code',
        'test_name',
        'status',
        'assigned_to',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($test) {
            $test->updateQuietly([
                'test_code' => 'SMP-TEST-' . str_pad($test->id, 4, '0', STR_PAD_LEFT)
            ]);
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Log only fillable fields
            ->logOnlyDirty() // Log only changed fields
            ->dontSubmitEmptyLogs() // Don't log if there are no changes
            ->setDescriptionForEvent(fn(string $eventName) => "Lab test has been {$eventName}"); // Customize the log description for better readability
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
