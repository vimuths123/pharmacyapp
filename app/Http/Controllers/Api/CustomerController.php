<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::with('creator');

        // Pagination
        $perPage = $request->input('per_page', 15); // Default to 15 items per page

        return CustomerResource::collection($query->paginate($perPage));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $medication = Customer::create($request->validated());

        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => new CustomerResource($medication)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customer->load('creator');

        return CustomerResource::make($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return response()->json([
            'message' => 'Medication updated successfully',
            'medication' => new CustomerResource($customer)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(['message' => 'Medication deleted successfully'], 200);
    }

    /**
     * Permanently delete the medication.
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyPermanently(string $id)
    {
        $customer = Customer::withTrashed()->find($id);

        if (!$customer) {
            return response()->json(['error' => 'No customer found with the given ID'], 404);
        }

        $customer->forceDelete();

        return response()->json(['message' => 'Customer permanently deleted'], 200);
    }
}
