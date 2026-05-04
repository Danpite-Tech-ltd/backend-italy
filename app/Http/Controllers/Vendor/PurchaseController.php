<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Productvariant;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Supplier;
use App\Models\Vendor;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    public function index()
    {

        $vendor = Auth::guard('vendor')->user();

        if (!$vendor) {
            return redirect()->route('vendor.login');
        }

        if (\request()->ajax()) {

            $purchases1 = Purchase::with(['suppliers', 'purchaseProducts'])->where('vendor_id', $vendor->id);

            return DataTables::eloquent($purchases1)
                ->addColumn('invoice', function ($purchases) {
                    return $purchases->date . '<br>' . $purchases->invoiceID;
                })
                ->addColumn('supplier', function ($purchases) {
                    return $purchases->suppliers->name . '<br>' . $purchases->suppliers->email . '<br>' . $purchases->suppliers->phone;
                })
                ->addColumn('quantityall', function ($purchases) {
                    return $purchases->purchaseProducts->sum('product_quantity');
                })
                //                ->editColumn('products', function ($purchases) {
                //                    $orderProducts = '';
                //                    foreach ($purchases->purcheseProducts as $product) {
                //                        $orderProducts = $orderProducts . $product->product_quantity . ' x ' . $product->product_name . '<br><span style="color:black;"> Variant: ' . $product->variant . ', Quantity: ' . $product->product_quantity . ', Price: ' . $product->product_price . '</span><br>';
                //                    }
                //                    return rtrim($orderProducts, '<br>');
                //                })

                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';


                    $editAction = '<a class="editButton btn btn-sm btn-info" href="' . route('vendor.purchase.edit', $admin->id) . '"
                                  data-id="' . $admin->id . '" >
                                   <i class="fas fa-edit"></i>
                                   </a>';


                    $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                                        data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                                        <i class="fas fa-trash"></i></a>';


                    return '<div class="gap-3 d-flex"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'status', 'invoice', 'supplier'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('vendor.pages.purchase.index');
    }

    public function create()
    {
        $suppliers = Supplier::where('status', 1)->get();
        $vendors = Vendor::where('status', 'approved')->get();

        return view('vendor.pages.purchase.create', compact('suppliers', 'vendors'));
    }

    public function productsForPurchase(Request $request)
    {

        if (isset($request['q'])) {
            $type0 = DB::table('productvariants')
                ->select(
                    'productvariants.*',
                    'products.name',
                    'products.SKU',
                    'products.thumbnail_img',
                    'productcolors.color_name as color_name',

                )
                ->join('products', 'products.id', '=', 'productvariants.product_id')
                ->leftJoin('productcolors', 'productcolors.id', '=', 'productvariants.productcolor_id')
                ->where('name', 'like', '%' . $request['q'] . '%')->get();
        } else {
            $type0 = DB::table('productvariants')
                ->select(
                    'productvariants.*',
                    'products.name',
                    'products.SKU',
                    'products.thumbnail_img',
                    'productcolors.color_name as color_name',

                )
                ->join('products', 'products.id', '=', 'productvariants.product_id')
                ->leftJoin('productcolors', 'productcolors.id', '=', 'productvariants.productcolor_id')
                ->where('name', 'like', '%' . $request['q'] . '%')->get();
        }

        $products = $type0;

        foreach ($products as $item) {

            if (App::environment('local')) {
                $item->thumbnail_img = url($item->thumbnail_img);
            } else {
                $item->thumbnail_img = url($item->thumbnail_img);
            }
            $product[] = array(
                "id" => $item->product_id,
                "size_id" => $item->id,
                "text" => $item->name,
                "color" => $item->color_name,
                "size" => $item->variant_name,
                "image" => $item->thumbnail_img,
                "productCode" => $item->SKU,
                "productPrice" => intval($item->sale_price)
            );
        }

        $data['data'] = $product;
        return $data;
    }

    public function store(Request $request)
    {
        //        dd($request->all());

        // \Log::info($request->all());
        $purchaseProducts = $request['data']['products'];

        $purchase = new Purchase();
        $purchase->invoiceID = uniqid();
        $purchase->delivery_charge = $request['data']['deliveryCharge'];
        $purchase->date = $request['data']['orderDate'];
        $purchase->supplier_id = $request['data']['supplier_id'];
        $purchase->vendor_id = $request['data']['vendor_id'];
        $purchase->paid_amount = $request['data']['paid'];
        $purchase->due_amount = $request['data']['due'];
        $purchase->total_amount = $request['data']['paid'] + $request['data']['due'];
        $purchase->admin_id = Auth::guard('vendor')->id();
        $result = $purchase->save();


        if ($result) {
            foreach ($purchaseProducts as $product) {
                $orderProducts = new PurchaseProduct();
                $orderProducts->purchase_id = $purchase->id;
                $orderProducts->product_id = $product['productID'];
                $orderProducts->product_SKU = $product['productCode'];
                $orderProducts->productvariant_id = $product['sizeID'];
                $orderProducts->product_variant = $product['productSize'];
                $orderProducts->product_name = $product['productName'];
                $orderProducts->product_quantity = $product['productQuantity'];
                $orderProducts->product_price = $product['productPrice'];
                $orderProducts->total = $product['productPrice'] * $product['productQuantity'];
                $success = $orderProducts->save();
                if ($success) {
                    $size = Productvariant::where('id', $product['sizeID'])->first();

                    $size->total_stock += $product['productQuantity'];
                    $size->available_stock += $product['productQuantity'];
                    $size->save();
                }
            }
        }



        $supplier = Supplier::find($request['data']['supplier_id']);
        $supplier->paid_amount += $request['data']['paid'];
        $supplier->due_amount += $request['data']['due'];
        $supplier->total_amount += $request['data']['paid'] + $request['data']['due'];
        $supplier->update();
        $response['status'] = 'success';
        $response['message'] = 'Successfully Complete Purchese';
        return json_encode($response);
    }

    public function edit(string $id)
    {
        $suppliers = Supplier::where('status', 1)->get();

        $purchases = DB::table('purchases')
            ->select('purchases.*', 'suppliers.name', 'suppliers.phone', 'suppliers.address', 'users.name')
            ->leftJoin('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->leftJoin('users', 'users.id', '=', 'purchases.admin_id')
            ->where('purchases.id', '=', $id)->get()->first();

        $products = DB::table('purchase_products')->where('purchase_id', '=', $id)->get();
        $purchases->products = $products;
        $purchases->id = $id;

        return view('vendor.pages.purchase.edit')->with([
            'purchase' => $purchases,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // \Log::info($request->all());

        $purcheseproducts = $request['data']['products'];
        $purchase = Purchase::findOrfail($id);
        $purchase->delivery_charge = $request['data']['deliveryCharge'];
        $purchase->paid_amount = $request['data']['paid'];
        $purchase->supplier_id = $request['data']['supplier_id'];
        if ($purchase->due_amount == $request['data']['due']) {
        } else {
            if ($purchase->due_amount > $request['data']['due']) {
                $supplier = Supplier::find($request['data']['supplier_id']);
                $supplier->due_amount -= $purchase->due_amount - $request['data']['due'];
                $supplier->total_amount -= $purchase->due_amount - $request['data']['due'];
                $supplier->update();

                $purchase->due_amount = $request['data']['due'];
            } else {
                $supplier = Supplier::find($request['data']['supplier_id']);
                $supplier->due_amount += $request['data']['due'] - $purchase->due_amount;
                $supplier->total_amount += $request['data']['due'] - $purchase->due_amount;
                $supplier->update();
                $purchase->due_amount = $request['data']['due'];
            }
        }

        $purchase->total_amount = $request['data']['paid'] + $request['data']['due'];
        $purchase->admin_id = Auth::guard('vendor')->id();
        $result = $purchase->save();


        if ($result) {
            foreach ($purcheseproducts as $product) {
                $orderProducts = PurchaseProduct::where('id', $product['ppid'])->first();

                if ($orderProducts->quantity == $product['productQuantity']) {
                } else {
                    if ($orderProducts->quantity > $product['productQuantity']) {
                        $size = Productvariant::where('id', $product['sizeID'])->first();
                        $size->total_stock -= $orderProducts->product_quantity - $product['productQuantity'];
                        $size->available_stock -= $orderProducts->product_quantity - $product['productQuantity'];
                        $size->save();
                    } else {
                        $size = Productvariant::where('id', $product['sizeID'])->first();
                        $size->total_stock += $product['productQuantity'] - $orderProducts->product_quantity;
                        $size->available_stock += $product['productQuantity'] - $orderProducts->product_quantity;
                        $size->save();
                    }
                }

                $orderProducts->product_quantity = $product['productQuantity'];
                $orderProducts->product_price = $product['productPrice'];
                $orderProducts->total = $product['productPrice'] * $product['productQuantity'];
                $success = $orderProducts->save();
            }
        }


        $response['status'] = 'success';
        $response['message'] = 'Successfully Complete Purchase';
        return json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        DB::beginTransaction();
        try {
            $purchaseProducts = PurchaseProduct::where('purchase_id', $purchase->id)->get();

            foreach ($purchaseProducts as $purchaseProduct) {
                $product = Productvariant::where('id', $purchaseProduct->productvariant_id)->first();
                if ($product->total_stock >= $purchaseProduct->product_quantity && $product->available_stock >= $purchaseProduct->product_quantity) {
                    $product->total_stock -= $purchaseProduct->product_quantity;
                    $product->available_stock -= $purchaseProduct->product_quantity;
                    $product->save();
                }
            }

            // rollback supplier balance
            $supplier = Supplier::find($purchase->supplier_id);
            if ($supplier) {
                $supplier->due_amount = max(0, $supplier->due_amount - $purchase->due_amount);
                $supplier->total_amount = max(0, $supplier->total_amount - $purchase->total_amount);
                $supplier->save();
            }

            $purchaseProducts->each->delete();
            $purchase->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Deleted Purchase'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to Delete Purchase'
            ], 500);
        }
    }
}
