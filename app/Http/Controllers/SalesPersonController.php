<?php

namespace App\Http\Controllers;

use App\Models\SalesPeople;
use Illuminate\Http\Request;

class SalesPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Sales/SalesScreen', [
            'salesforce' => SalesPeople::whereHired(true)->paginate(5)->withQueryString(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesPeople $salesPerson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesPeople $salesPerson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesPeople $salesPerson)
    {
        //
    }
}
