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
        'FamilyID',
        'CompanyID',
        'RegistrationType',
        'Surname',
        'FirstName',
        'MiddleName',
        'DOB',
        'Age',
        'Gender',
        'MaritalStatus',
        'Nationality',
        'LGA',
        'ProfilePhoto',
        'Status'
    ];

    protected $casts = [
        'DOB' => 'date',
        'FamilyID' => 'integer',
        'CompanyID' => 'integer',
        'Age' => 'integer',
    ];

    // If you want to disable timestamps (since your table has them as nullable)
    // public $timestamps = false;
    
    // If you need to customize the timestamp column names:
    // const CREATED_AT = 'created_at';
    // const UPDATED_AT = 'updated_at';
}