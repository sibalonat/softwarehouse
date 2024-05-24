<?php

namespace App\Http\Controllers;

use App\Http\Requests\Developers\HireDeveloper;
use App\Http\Requests\SalesForce\HireSalesPerson;
use App\Models\Developer;
use App\Models\SalesPeople;
use Illuminate\Http\Request;

class HumanResourcesController extends Controller
{
    public function developers()
    {
        return inertia('HumanResources/HRScreenDevelopers', [
            'developers' => Developer::paginate(5)->withQueryString()
        ]);
    }

    public function salesforce()
    {
        return inertia('HumanResources/HRScreenSalesPeople', [
            'salesforce' => SalesPeople::paginate(5)->withQueryString()
        ]);
    }

    public function hireSalesPerson(SalesPeople $salesPerson, HireSalesPerson $request)
    {
        $data = $request->validated();
        $salesPerson->update($data);

        return redirect()->route('hr.salesforce');
    }

    public function hireDeveloper(Developer $developer, HireDeveloper $request)
    {
        $data = $request->validated();
        $developer->update($data);

        return redirect()->route('hr.developers');
    }
}
