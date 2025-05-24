<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $primaryKey = 'PatientID';

    protected $fillable = [
        'PatientCode',          // New unified identifier
        'RegistrationType',     // Individual, Family, or Company
        'Surname',
        'FirstName',
        'MiddleName',
        'DOB',
        'Age',
        'Gender',
        'MaritalStatus',
        'Nationality',
        'LGA',
        'Status'
    ];

    protected $casts = [
        'DOB' => 'date',
        'Age' => 'integer',
    ];
}
