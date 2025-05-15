<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $primaryKey = 'ContactID';  // Matches your primary key column

    protected $fillable = [
        'PatientID',         // Changed from patient_id
        'PhoneNumber',       // Changed from phone_number
        'SecondaryPhone',    // Changed from secondary_phone
        'EmailAddress',      // Changed from email_address
        'Address',           // Changed from address
        'City',              // Changed from city
        'State',             // Changed from state
        'PostalCode',        // Changed from postal_code
        'Country'           // Changed from country
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }

    // Optional: Add casts for specific fields
    protected $casts = [
        'PatientID' => 'integer',
        'ContactID' => 'integer',
    ];
}