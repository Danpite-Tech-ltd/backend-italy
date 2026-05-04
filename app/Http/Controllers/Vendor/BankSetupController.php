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
