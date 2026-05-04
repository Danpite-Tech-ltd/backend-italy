<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wsale;
use App\Models\Wcustomer;
use App\Models\Wpayment;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WcustomerController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View wCustomer', only: ['index']),
            new Middleware('permission:Create wCustomer', only: ['store', 'create']),
            new Middleware('permission:Edit wCustomer', only: ['update', 'edit']),
            new Middleware('permission:Delete wCustomer', only: ['destroy']),
        ];
    }

    public function index()
    {
        return view('admin.pages.wholesale.wcustomer.wcustomer');
    }


    public function wcustomerLedger($id)
    {
        $wcustomer = Wcustomer::where('id', $id)->first();
//        $payment_types = Paymenttype::where('status', 'Active')->get();
        $wpayment = Wpayment::where('wcustomer_id', $wcustomer->id)->get();
        $orders = Wsale::where('wcustomer_id', $id)->get();

        return view('admin.pages.wholesale.wcustomer.ledger',
            [
                'orders' => $orders,
                'wcustomer' => $wcustomer,
                'wpayment' => $wpayment,
            ]);
    }

    public function wcustomerdata()
    {
        $wcustomers = Wcustomer::all();
        return Datatables::of($wcustomers)
            ->addColumn('action', function ($wcustomers) {
                $ledgerRoute = route('admin.wsale.ledger', $wcustomers->id);
                $editAction = '';
                $deleteAction = '';
                $ledgerBtn = '<a href=" ' . $ledgerRoute . ' "  id=""    class="btn btn-primary btn-sm"  style="margin-bottom:2px;"><i class="fas fa-eye"></i></a>';


                if (Auth::user()->can('Edit wCustomer')) {
                    $editAction = '<a href="#" type="button" id="editWcustomerBtn" data-id="' . $wcustomers->id . '" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editmainWcustomer" ><i class="fas fa-edit" ></i></a>';
                }

                if (Auth::user()->can('Delete wCustomer')) {
                    $deleteAction = '<a href="javascript:void(0)" type="button" id="deleteWcustomerBtn" data-id="' . $wcustomers->id . '" class="btn btn-danger btn-sm"  ><i class="fas fa-trash" ></i></a>';
                }



                return '<div class="d-flex gap-3"> ' . $ledgerBtn . $editAction . $deleteAction . '</div>';

            })
            ->make(true);
    }


    public function store(Request $request)
    {
        $wcustomer = Wcustomer::create($request->all());
        return response()->json($wcustomer, 200);
    }


    public function edit($id)
    {
        $wcustomer = Wcustomer::findOrfail($id);
        return response()->json($wcustomer, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Wcustomer $wcustomer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $wcustomer = Wcustomer::where('id', $id)->first();
        $wcustomer->wcustomerName = $request->wcustomerName;
        $wcustomer->wcustomerPhone = $request->wcustomerPhone;
        $wcustomer->wcustomerEmail = $request->wcustomerEmail;
        $wcustomer->wcustomerAddress = $request->wcustomerAddress;
        $wcustomer->wcustomerCompanyName = $request->wcustomerCompanyName;
        $wcustomer->save();
        return response()->json($wcustomer, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Wcustomer $wcustomer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wcustomer = Wcustomer::where('id', $id)->first();
        $wcustomer->delete();
        return response()->json('delete success');
    }

    public function updatestatus(Request $request)
    {

        $wcustomer = Wcustomer::Where('id', $request->wcustomer_id)->first();
        $wcustomer->status = $request->status;
        $wcustomer->save();

        return response()->json($wcustomer, 200);
    }
}
