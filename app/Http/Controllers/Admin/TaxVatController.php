<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use App\Models\Vat;
use Illuminate\Http\Request;

class TaxVatController extends Controller
{
    public function tax()
    {
        $tax = Tax::where('id', 1)->first();
        return view('admin.tax.update_tax', compact('tax'));
    }

    public function updateTax(Request $request)
    {
        $request->validate([
            'tax_rate' => 'required|numeric|min:0',
        ]);

        $tax = Tax::where('id', 1)->first();
        $tax->rate = $request->tax_rate;
        $tax->save();

        return redirect()->back()->with('success', 'Tax updated successfully.');
    }

    public function vat()
    {
        $vat = Vat::where('id', 1)->first();
        return view('admin.vat.update_vat', compact('vat'));
    }

    public function updateVat(Request $request)
    {
        $request->validate([
            'vat_rate' => 'required|numeric|min:0',
        ]);

        // Assuming there's a Vat model similar to Tax
        $vat = Vat::where('id', 1)->first();
        $vat->rate = $request->vat_rate;
        $vat->save();

        return redirect()->back()->with('success', 'VAT updated successfully.');
    }
}
