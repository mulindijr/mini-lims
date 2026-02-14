<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Sample extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'patient_id',
        'sample_code',
        'sample_type',
        'status',
        'received_at',
        'created_by',
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Log only fillable fields
            ->logOnlyDirty() // Log only changed fields
            ->dontSubmitEmptyLogs() // Don't log if there are no changes
            ->setDescriptionForEvent(fn(string $eventName) => "Sample record has been {$eventName}"); // Customize the log description for better readability
    }

    protected static function booted()
    {
        static::created(function ($sample) {
            if (!$sample->sample_code) {
                $sample->updateQuietly([
                    'sample_code' => 'SMP-' . str_pad($sample->id, 4, '0', STR_PAD_LEFT)
                ]);
            }
        });
    }

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
