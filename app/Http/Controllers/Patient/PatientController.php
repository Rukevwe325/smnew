<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
            'RegistrationType' => 'required|string|max:20',
            'LGA' => 'required|string|max:50',
            // Optional fields validation
            'MiddleName' => 'nullable|string|max:50',
            'Nationality' => 'nullable|string|max:50',
            'ProfilePhoto' => 'nullable|string',
            'FamilyID' => 'nullable|integer',
            'CompanyID' => 'nullable|integer',
        ]);

        // Calculate age from DOB
        $age = Carbon::parse($request->DOB)->age;

        $patient = Patient::create([
            'FamilyID' => $request->FamilyID,
            'CompanyID' => $request->CompanyID,
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
            'ProfilePhoto' => $request->ProfilePhoto,
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

        $updateData = $request->only([
            'FamilyID', 'CompanyID', 'RegistrationType', 'Surname', 'FirstName', 
            'MiddleName', 'DOB', 'Gender', 'MaritalStatus', 'Nationality', 'LGA', 
            'ProfilePhoto', 'Status'
        ]);

        // Recalculate age if DOB is being updated
        if ($request->has('DOB')) {
            $updateData['Age'] = Carbon::parse($request->DOB)->age;
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