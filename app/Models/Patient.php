<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Patient extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'created_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Log only fillable fields
            ->logOnlyDirty() // Log only changed fields
            ->dontSubmitEmptyLogs() // Don't log if there are no changes
            ->setDescriptionForEvent(fn(string $eventName) => "Patient record has been {$eventName}");
    }

    // Relationship to the User who created the patient record
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
