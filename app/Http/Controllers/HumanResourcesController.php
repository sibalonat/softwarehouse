<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesForce\HireSalesPerson;
use App\Models\SalesPeople;
use Illuminate\Http\Request;

class HumanResourcesController extends Controller
{
    public function developers()
    {
        return inertia('HumanResources/HRScreenDevelopers');
    }

    public function salesforce()
    {
        return inertia('HumanResources/HRScreenSalesPeople', [
            'salesforce' => SalesPeople::paginate(6)->withQueryString()
        ]);
    }

    public function hireSalesPerson(SalesPeople $salesPerson, HireSalesPerson $request)
    {
        $data = $request->validated();
        $salesPerson->update($data);

        return redirect()->route('hr.salesforce');
    }
}
