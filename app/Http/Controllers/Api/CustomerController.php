<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::with('creator');

        if ($request->input('with_trashed', false)) {
            $query->withTrashed();
        }

        if ($request->input('only_trashed', false)) {
            $query->onlyTrashed();
        }

        // Pagination
        $perPage = $request->input('per_page', 15); // Default to 15 items per page

        return CustomerResource::collection($query->latest()->paginate($perPage));
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
        $validatedData = $request->validated();
        $validatedData['created_by'] = auth()->id();

        $customer = Customer::create($validatedData);

        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => new CustomerResource($customer)
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
            'message' => 'Customer updated successfully',
            'customer' => new CustomerResource($customer)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully'], 200);
    }
    
     /**
     * Restore a soft deleted customer. Here we are not using Route Model binding since it will not consider 
     * soft deleted items
     *
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(string $id)
    {
        $customer = Customer::withTrashed()->find($id);

        if (!$customer) {
            return response()->json(['error' => 'No Customer found with the given ID'], 404);
        }
        $customer->restore();

        return response()->json(['message' => 'Customer restored successfully'], 200);
    }

    /**
     * Permanently delete the customer. Here we are not using Route Model binding since it will not consider 
     * soft deleted items
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
