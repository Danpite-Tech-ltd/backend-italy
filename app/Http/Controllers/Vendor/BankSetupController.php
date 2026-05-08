<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\BankSetup;
use App\Models\Vendor;
use App\Models\Vendorwithdraw;
use App\Models\WalletVendor;
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
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'routing_number' => 'nullable|string|max:255',
            'iban_number' => 'nullable|string|max:255',
            'swift_code' => 'nullable|string|max:255',
            'branch_city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
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
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'routing_number' => 'nullable|string|max:255',
            'iban_number' => 'nullable|string|max:255',
            'swift_code' => 'nullable|string|max:255',
            'branch_city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $bankSetup = BankSetup::where('vendor_id', Auth::guard('vendor')->id())
            ->firstOrFail();

        $bankSetup->update($validated);

        return back()->with('success', 'Bank information updated successfully.');
    }

    public function withdraw()
    {
        $balance = Vendor::where('id', Auth::guard('vendor')->id())->first()->balance;
        return view('vendor.bank.withdraw', compact('balance'));
    }

    public function withdrawSubmit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $vendor_id = Auth::guard('vendor')->id();
        $bank = BankSetup::where('vendor_id', $vendor_id)->first();

        if (!$bank) {
            return back()->with('error', 'Please set up your bank information before requesting a withdrawal.');
        }

        $balance = Vendor::where('id', $vendor_id)->first()->balance;
        if ($request->amount > $balance) {
            return back()->with('error', 'You do not have enough balance to make this withdrawal request.');
        }

        $vendor_withdraw = new WalletVendor();
        $vendor_withdraw->vendor_id = $vendor_id;
        $vendor_withdraw->type = 'withdraw';
        $vendor_withdraw->amount = $request->amount;
        $vendor_withdraw->bank_id = $bank->id;
        $vendor_withdraw->note = $request->note;
        $vendor_withdraw->status = 'pending';
        $vendor_withdraw->save();

        return redirect()->back()->with('success', 'Your withdrawal request has been submitted successfully.');
    }

    public function pendingWithdraw(){
        $withdraw = WalletVendor::where('vendor_id', Auth::guard('vendor')->id())->where('status', 'pending')->latest()->get();
        return view('vendor.bank.pending_withdraw', compact('withdraw'));
    }
    public function approvedWithdraw(){
        $withdraw = WalletVendor::where('vendor_id', Auth::guard('vendor')->id())->where('status', 'approved')->latest()->get();
        return view('vendor.bank.approved_withdraw', compact('withdraw'));
    }
}
