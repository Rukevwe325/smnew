<?php

namespace App\Models\Patient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    use HasFactory;

    protected $table = 'next_of_kin';  // Matches your table name exactly

    protected $primaryKey = 'NextOfKinID';  // Matches your primary key column

    protected $fillable = [
        'PatientID',  // Matches your column name
        'Name',       // Changed from next_of_kin_name
        'Relationship',  // Changed from next_of_kin_relationship
        'PhoneNumber',   // Changed from next_of_kin_phone
        'Address'       // Changed from next_of_kin_address
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientID', 'PatientID');
    }
}