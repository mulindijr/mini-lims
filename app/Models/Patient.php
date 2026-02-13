<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'created_by',
    ];

    // Relationship to the User who created the patient record
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
