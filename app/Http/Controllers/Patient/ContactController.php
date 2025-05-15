<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Patient\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Store the contact information for a patient.
    public function store(Request $request)
    {
        $request->validate([
            'PatientID' => 'required|exists:patients,PatientID',
            'PhoneNumber' => 'required|string|max:15',
            'SecondaryPhone' => 'nullable|string|max:15',
            'EmailAddress' => 'nullable|email|max:100',
            'Address' => 'required|string',
            'City' => 'required|string|max:50',
            'State' => 'required|string|max:50',
            'PostalCode' => 'nullable|string|max:10',
            'Country' => 'required|string|max:50',
        ]);

        $contact = Contact::create([
            'PatientID' => $request->PatientID,
            'PhoneNumber' => $request->PhoneNumber,
            'SecondaryPhone' => $request->SecondaryPhone,
            'EmailAddress' => $request->EmailAddress,
            'Address' => $request->Address,
            'City' => $request->City,
            'State' => $request->State,
            'PostalCode' => $request->PostalCode,
            'Country' => $request->Country,
        ]);

        return response()->json($contact, 201);
    }

    // Update the contact information of a patient.
    public function update(Request $request, $contactId)
    {
        $contact = Contact::find($contactId);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $request->validate([
            'PhoneNumber' => 'sometimes|string|max:15',
            'SecondaryPhone' => 'nullable|string|max:15',
            'EmailAddress' => 'nullable|email|max:100',
            'Address' => 'sometimes|string',
            'City' => 'sometimes|string|max:50',
            'State' => 'sometimes|string|max:50',
            'PostalCode' => 'nullable|string|max:10',
            'Country' => 'sometimes|string|max:50',
        ]);

        $contact->update($request->only([
            'PhoneNumber', 'SecondaryPhone', 'EmailAddress', 'Address', 
            'City', 'State', 'PostalCode', 'Country'
        ]));

        return response()->json($contact);
    }

    // Delete a specific contact information.
    public function destroy($contactId)
    {
        $contact = Contact::find($contactId);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->delete();
        return response()->json(['message' => 'Contact information deleted successfully']);
    }
}