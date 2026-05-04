<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmsGateway;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SmsGatewayController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:SMS Gateway', only: ['index','store']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Bulksmsbd = SmsGateway::where('type', 'Bulksmsbd')->first();

        return view('admin.pages.api.sms.index',compact('Bulksmsbd'));
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
    public function store(Request $request)
    {
        $update_data = SmsGateway::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status?1:0;
        $update_data->update($input);


        return redirect()->back()->with('success','Sms Gateway Updated Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SmsGateway $smsGateway)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SmsGateway $smsGateway)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SmsGateway $smsGateway)
    {
        $update_data = SmsGateway::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        return redirect()->back()->with('success','Data update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SmsGateway $smsGateway)
    {
        //
    }
}
