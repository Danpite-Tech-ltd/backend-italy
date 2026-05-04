<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Productvariant;
use App\Models\Variant;
use App\Models\Wsale;
use App\Models\Wsalestock;
use App\Models\Wcustomer;
use App\Models\Size;
use Illuminate\Http\Request;
use App\Models\Wsaleproduct;
use App\Models\Wpayment;
use DataTables;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Basicinfo;
use App\Models\Incomehistory;

class WsaleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Wholesale', only: ['index','wsaledata']),
            new Middleware('permission:Create Wholesale', only: ['store', 'create']),
            new Middleware('permission:Edit Wholesale', only: ['update', 'edit']),
            new Middleware('permission:Delete Wholesale', only: ['destroy']),
        ];
    }


    public function index()
    {
        $products = Product::where('status', 'Active')->get();
        $wcustomers = Wcustomer::where('status', 'Active')->get();
        return view('admin.pages.wholesale.wsale.wsale', ['products' => $products, 'wcustomers' => $wcustomers]);
    }


    public function wsaledata()
    {
        $wsales = Wsale::with(['wsaleproducts', 'wcustomers'])->get();

        return Datatables::of($wsales)
            ->addColumn('invoice', function ($wsales) {
                return $wsales->date . '<br>' . $wsales->invoiceID;
            })
            ->addColumn('wcustomer', function ($wsales) {
                return $wsales->wcustomers->wcustomerName . '<br>' . $wsales->wcustomers->wcustomerAddress . '<br>' . $wsales->wcustomers->wcustomerPhone;
            })
            ->addColumn('quantityall', function ($wsales) {
                return $wsales->wsaleproducts->sum('quantity');
            })
            ->editColumn('products', function ($wsales) {
                $orderProducts = '';
                foreach ($wsales->wsaleproducts as $product) {
                    $orderProducts = $orderProducts . $product->quantity . ' x ' . $product->product_name . '<br><span style="color:black;"> Variant: ' . $product->size . ', Quantity: ' . $product->quantity . ', Price: ' . $product->product_price . '</span><br>';
                }
                return rtrim($orderProducts, '<br>');
            })
            ->addColumn('action', function ($wsales) {
                return '<a href="#" type="button" id="editWsaleBtn" data-id="' . $wsales->id . '" class="btn btn-primary btn-sm btn-editwsale"><i class="fas fa-edit" ></i></a>';
            })
            ->rawColumns(['action', 'invoice', 'wcustomer', 'quantityall', 'products'])
            ->make(true);
    }

    public function create()
    {
        $uniqueId = $this->uniqueID();
        $wcustomers = Wcustomer::where('status', 'Active')->get();
        return view('admin.pages.wholesale.wsale.create', ['uniqueId' => $uniqueId, 'wcustomers' => $wcustomers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $wsaleproducts = $request['data']['products'];
        $wsale = new Wsale();
        $wsale->invoiceID = $this->uniqueID();
        $wsale->deliveryCharge = $request['data']['deliveryCharge'];
        $wsale->date = $request['data']['orderDate'];
        $wsale->wcustomer_id = $request['data']['wcustomer_id'];
        $wsale->paid = $request['data']['paid'];
        $wsale->due = $request['data']['due'];
        $wsale->totalAmount = $request['data']['paid'] + $request['data']['due'];
        $wsale->admin_id = Auth::user()->id;
        $result = $wsale->save();


        if ($result) {
            foreach ($wsaleproducts as $product) {
                $orderProducts = new Wsaleproduct();
                $orderProducts->wsale_id = $wsale->id;
                $orderProducts->product_id = $product['productID'];
                $orderProducts->product_code = $product['productCode'];
                $orderProducts->size_id = $product['sizeID'];
                $orderProducts->size = $product['productSize'];
                $orderProducts->product_name = $product['productName'];
                $orderProducts->quantity = $product['productQuantity'];
                $orderProducts->product_price = $product['productPrice'];
                $orderProducts->total = $product['productPrice'] * $product['productQuantity'];
                $success = $orderProducts->save();
                if ($success) {
                    $size = Productvariant::where('id', $product['sizeID'])->first();

                    $stock = new Wsalestock();
                    $stock->wsale_product_id = $wsale->id;
                    $stock->product_id = $product['productID'];
                    $stock->product_name = $product['productName'];
                    $stock->size_id = $product['sizeID'];
                    $stock->size = $product['productSize'];
                    $stock->wsale = $product['productQuantity'];
                    $stock->stock = $size->available_stock - $product['productQuantity'];
                    $stock->initial_stock = $size->available_stock;
                    $stock->total_stock = $size->total_stock;
                    $stock->save();

                    $size->available_stock -= $product['productQuantity'];
                    $size->sold_stock += $product['productQuantity'];
                    $size->update();
                }
            }
        }


        if ($request['data']['paid'] != '' && $request['data']['paymentTypeID'] != '') {
            $wcustomerPayment = new Wpayment();
            $wcustomerPayment->wcustomer_id = $request['data']['wcustomer_id'];
            $wcustomerPayment->wsale_id = $wsale->id;;
            $wcustomerPayment->date = $request['data']['orderDate'];
            $wcustomerPayment->amount = $request['data']['paid'];
            $wcustomerPayment->trx_id = $request['data']['invoiceID'];
            $wcustomerPayment->payment_type = $request['data']['paymentTypeID'];
            $wcustomerPayment->admin_id = Auth::user()->id;
            $wcustomerPayment->comments = $request['data']['comments'];
            $wcustomerPaymentUpdate = $wcustomerPayment->save();
        }

        $wcustomer = Wcustomer::find($request['data']['wcustomer_id']);
        $wcustomer->wcustomerPaidAmount += $request['data']['paid'];
        $wcustomer->wcustomerDueAmount += $request['data']['due'];
        $wcustomer->wcustomerTotalAmount += $request['data']['paid'] + $request['data']['due'];
        $wcustomer->update();

//        if ($request['data']['paid'] != '' && $request['data']['paymentTypeID'] != '') {
//            if ($wcustomerPaymentUpdate) {
//                $account = Basicinfo::first();
//                $account->account_balance += $request['data']['paid'];
//                $account->update();
//                $income = new Incomehistory();
//                $income->from = 'Wholesale';
//                $income->date = date('Y-m-d');
//                $income->amount = $request['data']['paid'];
//                $income->admin_id = Auth::guard('admin')->user()->id;
//                $income->comments = 'Payment receive from wholesale INV: ' . $wsale->invoiceID . 'CT-Paid: ' . $wcustomer->wcustomerPaidAmount . 'CT-Due: ' + $wcustomer->wcustomerDueAmount;
//                $income->save();
//            }
//        }

        $response['status'] = 'success';
        $response['message'] = 'Successfully Complete Wsale';
        return json_encode($response);
        die();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Wsale $wsale
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $wsales = DB::table('wsales')
            ->select('wsales.*', 'wcustomers.wcustomerName', 'wcustomers.wcustomerPhone', 'wcustomers.wcustomerAddress', 'admins.name')
            ->leftJoin('wcustomers', 'wcustomers.id', '=', 'wsales.wcustomer_id')
            ->leftJoin('admins', 'wsales.admin_id', '=', 'admins.id')
            ->where('wsales.id', '=', $id)->get()->first();
        $products = DB::table('wsaleproducts')->where('wsale_id', '=', $id)->get();
        $wsales->products = $products;
        $wsales->id = $id;
        return view('admin.pages.wholesale.wsale.edit')->with('wsale', $wsales);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Wsale $wsale
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Wsale $wsale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wsale = Wsale::where('id', $id)->first();
        $wsale->delete();
        return response()->json('delete success');
    }

    public function wcustomers(Request $request)
    {
        if (isset($request['q'])) {
            $wcustomers = Wcustomer::query()->where([
                ['wcustomerName', 'like', '%' . $request['q'] . '%'],
                ['status', 'like', 'Active']
            ])->get();
        } else {
            $wcustomers = Wcustomer::query()->where('status', 'like', 'Active')->get();
        }
        $wcustomer = array();
        foreach ($wcustomers as $item) {
            $wcustomer[] = array(
                "id" => $item['id'],
                "text" => $item['wcustomerName']
            );
        }
        return json_encode($wcustomer);
    }

    public function uniqueID()
    {
        $lastWsale = Wsale::latest('id')->first();
        if ($lastWsale) {
            $WsaleID = $lastWsale->id + 1;
        } else {
            $WsaleID = 1;
        }

        return 'WSINV' . $WsaleID;
    }

    public function productsForSale(Request $request)
    {
        $query = DB::table('productvariants')
            ->select(
                'productvariants.*',
                'products.name',
                'products.SKU',
                'products.thumbnail_img',
                'productcolors.color_name as color_name'
            )
            ->join('products', 'products.id', '=', 'productvariants.product_id')
            ->leftJoin('productcolors', 'productcolors.id', '=', 'productvariants.productcolor_id');

        // Apply search if exists
        if ($request->has('q') && !empty($request->q)) {
            $query->where('products.name', 'like', '%' . $request->q . '%');
        }

        $products = $query->get();

        $productData = [];

        foreach ($products as $item) {
            // Convert image path to full URL
            $item->thumbnail_img = url($item->thumbnail_img);

            // 🔹 Check stock availability
            if ($item->available_stock > 0) {
                $productData[] = [
                    "id" => $item->product_id,
                    "size_id" => $item->id,
                    "text" => $item->name,
                    "color" => $item->color_name,
                    "size" => $item->variant_name,
                    "image" => $item->thumbnail_img,
                    "productCode" => $item->SKU,
                    "productPrice" => intval($item->sale_price),
                    "status" => "Available",
                ];
            } else {
                $productData[] = [
                    "id" => $item->product_id,
                    "size_id" => $item->id,
                    "text" => $item->name . ' (Not Available)',
                    "color" => $item->color_name,
                    "size" => $item->variant_name,
                    "image" => $item->thumbnail_img,
                    "productCode" => $item->SKU,
                    "productPrice" => intval($item->sale_price),
                    "status" => "Not Available",
                ];
            }
        }

        return ['data' => $productData];
    }

}
