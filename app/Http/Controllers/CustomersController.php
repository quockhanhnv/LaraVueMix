<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomersController extends Controller
{
    public function all()
    {
        $customers = Customer::orderBy('created_at', 'desc')->get();

        return response()->json([
            "customers" => $customers
        ], 200);
    }

    public function get($id)
    {
        $customer = Customer::whereId($id)->first();

        return response()->json([
            "customer" => $customer
        ], 200);
    }

    public function new(CreateCustomerRequest $request)
    {
        $customer = Customer::create($request->only(["name", "email", "phone", "website"]));

        return response()->json([
            "customer" => $customer
        ], 200);
    }
}
