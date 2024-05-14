<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicationRequest;
use App\Http\Requests\UpdateMedicationRequest;
use App\Http\Resources\MedicationResource;
use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Medication::with('creator');

        if ($request->input('with_trashed', false)) {
            $query->withTrashed();
        }

        if ($request->input('only_trashed', false)) {
            $query->onlyTrashed();
        }

        // Pagination
        $perPage = $request->input('per_page', 15); // Default to 15 items per page

        return MedicationResource::collection($query->latest()->paginate($perPage));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicationRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['created_by'] = auth()->id();

        $medication = Medication::create($validatedData);

        return response()->json([
            'message' => 'Medication created successfully',
            'medication' => new MedicationResource($medication)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Medication $medication)
    {
        $medication->load('creator');

        return MedicationResource::make($medication);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medication $medication)
    {
        //
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicationRequest $request, Medication $medication)
    {
        $medication->update($request->validated());

        return response()->json([
            'message' => 'Medication updated successfully',
            'medication' => new MedicationResource($medication)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medication $medication)
    {
        $medication->delete();

        return response()->json(['message' => 'Medication deleted successfully'], 200);
    }

    /**
     * Restore a soft deleted medication.
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Medication $medication)
    {
        $medication->restore();

        return response()->json(['message' => 'Medication restored successfully'], 200);
    }

    /**
     * Permanently delete the medication.
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyPermanently(string $id)
    {
        $medication = Medication::withTrashed()->find($id);

        if (!$medication) {
            return response()->json(['error' => 'No medication found with the given ID'], 404);
        }

        $medication->forceDelete();

        return response()->json(['message' => 'Medication permanently deleted'], 200);
    }
}
