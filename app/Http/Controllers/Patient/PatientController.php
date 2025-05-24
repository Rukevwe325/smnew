<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    // Display a listing of the patients.
    public function index()
    {
        $patients = Patient::all();
        return response()->json($patients);
    }

    // Store a newly created patient.
    public function store(Request $request)
    {
        $request->validate([
            'Surname' => 'required|string|max:50',
            'FirstName' => 'required|string|max:50',
            'DOB' => 'required|date',
            'Gender' => 'required|string|max:10',
            'MaritalStatus' => 'required|string|max:20',
            'RegistrationType' => 'required|string|in:Individual,Family,Company',
            'LGA' => 'required|string|max:50',
            'MiddleName' => 'nullable|string|max:50',
            'Nationality' => 'nullable|string|max:50',
            'Status' => 'nullable|string|max:20',
        ]);

        // Calculate age from DOB
        $age = Carbon::parse($request->DOB)->age;

        // Generate PatientCode prefix based on RegistrationType
        $prefixMap = [
            'Individual' => 'IND',
            'Family' => 'FAM',
            'Company' => 'COM',
        ];

        $prefix = $prefixMap[$request->RegistrationType];

        // Generate unique 5-digit code (simple method)
        do {
            $randomNumber = rand(10000, 99999);
            $patientCode = $prefix . $randomNumber;
        } while (Patient::where('PatientCode', $patientCode)->exists());

        $patient = Patient::create([
            'PatientCode' => $patientCode,
            'RegistrationType' => $request->RegistrationType,
            'Surname' => $request->Surname,
            'FirstName' => $request->FirstName,
            'MiddleName' => $request->MiddleName,
            'DOB' => $request->DOB,
            'Age' => $age,
            'Gender' => $request->Gender,
            'MaritalStatus' => $request->MaritalStatus,
            'Nationality' => $request->Nationality,
            'LGA' => $request->LGA,
            'Status' => $request->Status ?? 'Active',
        ]);

        return response()->json($patient, 201);
    }

    // Display a specific patient.
    public function show($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    // Update a specific patient.
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $request->validate([
            'Surname' => 'sometimes|string|max:50',
            'FirstName' => 'sometimes|string|max:50',
            'DOB' => 'sometimes|date',
            'Gender' => 'sometimes|string|max:10',
            'MaritalStatus' => 'sometimes|string|max:20',
            'RegistrationType' => 'sometimes|string|in:Individual,Family,Company',
            'LGA' => 'sometimes|string|max:50',
            'MiddleName' => 'nullable|string|max:50',
            'Nationality' => 'nullable|string|max:50',
            'Status' => 'nullable|string|max:20',
        ]);

        $updateData = $request->only([
            'RegistrationType', 'Surname', 'FirstName', 'MiddleName', 'DOB', 
            'Gender', 'MaritalStatus', 'Nationality', 'LGA', 'Status'
        ]);

        // If RegistrationType changes, update PatientCode accordingly
        if (isset($updateData['RegistrationType']) && $updateData['RegistrationType'] !== $patient->RegistrationType) {
            $prefixMap = [
                'Individual' => 'IND',
                'Family' => 'FAM',
                'Company' => 'COM',
            ];
            $prefix = $prefixMap[$updateData['RegistrationType']];
            do {
                $randomNumber = rand(10000, 99999);
                $patientCode = $prefix . $randomNumber;
            } while (Patient::where('PatientCode', $patientCode)->exists());
            $updateData['PatientCode'] = $patientCode;
        }

        // Recalculate age if DOB updated
        if (isset($updateData['DOB'])) {
            $updateData['Age'] = Carbon::parse($updateData['DOB'])->age;
        }

        $patient->update($updateData);

        return response()->json($patient);
    }

    // Remove a specific patient.
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $patient->delete();
        return response()->json(['message' => 'Patient deleted successfully']);
    }
}
