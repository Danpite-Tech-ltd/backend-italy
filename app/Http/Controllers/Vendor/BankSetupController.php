<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\BankSetup;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankSetupController extends Controller
{
    public function index()
    {
        $bankSetup = BankSetup::with('vendor')
        ->where('vendor_id', Auth::guard('vendor')->id())
        ->first();
        return view('vendor.bank.index', compact('bankSetup'));
    }

 public function store(Request $request)
{
    $validated = $request->validate([
        'bank_name'     => 'required|string|max:255',
        'branch_name'   => 'required|string|max:255',
        'account_name'  => 'required|string|max:255',
        'account_number'=> 'required|string|max:255',
        'routing_number'=> 'nullable|string|max:255',
        'iban_number'   => 'nullable|string|max:255',
        'swift_code'    => 'nullable|string|max:255',
        'branch_city'   => 'nullable|string|max:255',
        'country'       => 'nullable|string|max:255',
    ]);

    $bankSetup = new BankSetup();
    $bankSetup->bank_name = $request->bank_name;
    $bankSetup->branch_name = $request->branch_name;
    $bankSetup->account_name = $request->account_name;
    $bankSetup->account_number = $request->account_number;
    $bankSetup->routing_number = $request->routing_number;
    $bankSetup->iban_number = $request->iban_number;
    $bankSetup->swift_code = $request->swift_code;
    $bankSetup->branch_city = $request->branch_city;
    $bankSetup->country = $request->country;
    $bankSetup->vendor_id = Auth::guard('vendor')->id();

    $bankSetup->save();

    return back()->with('success', 'Bank information added successfully.');
}
 public function update(Request $request)
{
    $validated = $request->validate([
        'bank_name'     => 'required|string|max:255',
        'branch_name'   => 'required|string|max:255',
        'account_name'  => 'required|string|max:255',
        'account_number'=> 'required|string|max:255',
        'routing_number'=> 'nullable|string|max:255',
        'iban_number'   => 'nullable|string|max:255',
        'swift_code'    => 'nullable|string|max:255',
        'branch_city'   => 'nullable|string|max:255',
        'country'       => 'nullable|string|max:255',
    ]);

    $bankSetup = BankSetup::where('vendor_id', Auth::guard('vendor')->id())
        ->firstOrFail();

    $bankSetup->update($validated);

    return back()->with('success', 'Bank information updated successfully.');
}

public function withdraw()
{



    return view('vendor.bank.withdraw');
}




}
