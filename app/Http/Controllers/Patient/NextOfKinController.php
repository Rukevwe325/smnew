<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\NextOfKin;
use Illuminate\Http\Request;

class NextOfKinController extends Controller
{
    // Store the next of kin information for a patient.
    public function store(Request $request)
    {
        $request->validate([
            'PatientID' => 'required|exists:patients,PatientID',
            'Name' => 'required|string|max:100',
            'Relationship' => 'required|string|max:50',
            'PhoneNumber' => 'required|string|max:15',
            'Address' => 'nullable|string',
        ]);

        $nextOfKin = NextOfKin::create([
            'PatientID' => $request->PatientID,
            'Name' => $request->Name,
            'Relationship' => $request->Relationship,
            'PhoneNumber' => $request->PhoneNumber,
            'Address' => $request->Address,
        ]);

        return response()->json($nextOfKin, 201);
    }

    // Get all next of kin information for a specific patient.
    public function show($patientId)
    {
        $nextOfKinRecords = NextOfKin::where('PatientID', $patientId)->get();

        if ($nextOfKinRecords->isEmpty()) {
            return response()->json(['message' => 'No next of kin found for this patient'], 404);
        }

        return response()->json($nextOfKinRecords);
    }

    // Update the next of kin information.
    public function update(Request $request, $nextOfKinId)
    {
        $nextOfKin = NextOfKin::find($nextOfKinId);

        if (!$nextOfKin) {
            return response()->json(['message' => 'Next of kin not found'], 404);
        }

        $request->validate([
            'Name' => 'sometimes|string|max:100',
            'Relationship' => 'sometimes|string|max:50',
            'PhoneNumber' => 'sometimes|string|max:15',
            'Address' => 'nullable|string',
        ]);

        $nextOfKin->update($request->only([
            'Name', 'Relationship', 'PhoneNumber', 'Address'
        ]));

        return response()->json($nextOfKin);
    }

    // Delete the next of kin information.
    public function destroy($nextOfKinId)
    {
        $nextOfKin = NextOfKin::find($nextOfKinId);

        if (!$nextOfKin) {
            return response()->json(['message' => 'Next of kin not found'], 404);
        }

        $nextOfKin->delete();
        return response()->json(['message' => 'Next of kin information deleted successfully']);
    }
}
