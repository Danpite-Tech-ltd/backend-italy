<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Productcolor;
use App\Models\ProductType;
use App\Models\Productvariant;
use App\Models\Subcategory;
use App\Models\Variant;
use App\Models\Vendor;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    $vendor = Auth::guard('vendor')->user();

    if (!$vendor) {
        return redirect()->route('vendor.login');
    }

    if (request()->ajax()) {

        $products = Product::with([
                'category:id,name',
                'vendor:id,company_name',
                'type',
                'productvariants:id,product_id,sale_price'
            ])
            ->where('vendor_id', $vendor->id); // ✅ ONLY AUTH VENDOR DATA

        return DataTables::eloquent($products)
            ->addColumn('status', function ($product) {

                if ($product->status == 1) {
                    return '
                        <a class="status" href="javascript:void(0)"
                           data-id="' . $product->id . '" data-status="' . $product->status . '">
                           <i class="fa-solid fa-toggle-on fa-2x"></i>
                        </a>';
                }

                return '
                    <a class="status" href="javascript:void(0)"
                       data-id="' . $product->id . '" data-status="' . $product->status . '">
                       <i class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                    </a>';
            })

            ->addColumn('product_price', function ($product) {
                return $product->productvariants->first()->sale_price ?? 0;
            })

            ->addIndexColumn()
            ->rawColumns(['status'])
            ->make(true);
    }

    return view('vendor.pages.product.index');
}



    /**
     * Show the form for creating a new resource.
     */
  public function create()
{
    $vendor = Auth::guard('vendor')->user(); // singular

    if (!$vendor || $vendor->status !== 'approved') {
        abort(403, 'Vendor not approved');
    }

    $categories   = Category::where('status', 1)->get();
    $brands       = Brand::where('status', 1)->get();
    $productTypes = ProductType::where('status', 1)->get();

    return view(
        'vendor.pages.product.create.basic-info',
        compact('categories', 'brands', 'productTypes', 'vendor')
    );
}

 public function SKUGenerator(string $id)
    {
        // Get the last product (or null if none exists)
        $lastProduct = Product::latest()->first();
        $prefix = Category::where('id',$id)->first()->SKU_prefix ?? 'default';

        // Generate numeric part
        $nextId = $lastProduct ? $lastProduct->id + 1 : 1;


        // Return prefix + padded number
        return $prefix . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
    }


    /**
     * Store a newly created resource in storage.
     */
      public function store(Request $request)
    {
    //  dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcatergory_id' => 'nullable',
            // 'childcategory_id' => 'nullable',
            // 'brand_id' => 'nullable',
            'vendor_id' => 'required',
            'product_type_id' => 'required',
            'short_description' => 'nullable',
            'long_description' => 'required',
            'shipping_return_text' => 'nullable|string',
            'additional_info_text' => 'nullable|string',
            'youtube_link' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'google_schema' => 'nullable|string',
            'affiliate_commission' => 'numeric',
            // 'thumbnail_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail_img' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name ?? 'default') . uniqid();
        $product->SKU = $this->SKUGenerator($request->category_id);
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id ?? null;
        $product->childcategory_id = $request->childcategory_id ?? null;
        $product->brand_id = $request->brand_id ?? null;
        $product->vendor_id = $request->vendor_id ?? null;
        $product->product_type_id = $request->product_type_id ?? null;

        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;

        $product->shipping_return_text = $request->shipping_return_text;
        $product->additional_info_text = $request->additional_info_text;
        $product->youtube_link = $request->youtube_link;

        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->google_schema = $request->google_schema;

        $product->affiliate_commission = $request->affiliate_commission;

        if ($request->hasFile('thumbnail_img')) {

            $file = $request->file('thumbnail_img');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . uniqid() . '.' . $extension;
            $file->move('public/admin/upload/products/', $filename);
            $product->thumbnail_img = 'public/admin/upload/products/' . $filename;
        }

        if ($request->hasFile('meta_image')) {

            $file = $request->file('meta_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . uniqid() . '.' . $extension;
            $file->move('public/admin/upload/products/', $filename);
            $product->meta_image = 'public/admin/upload/products/' . $filename;
        }



        $product->save();




        return redirect()->route('vendor.pro-variant-page', $product->id);

    }

    public function proVariantPage(string $id)
    {
        return view('vendor.pages.product.create.variant-info', compact('id'));
    }

    public function getSubCategoryByCategory(string $id)
    {
        $subcategories = Subcategory::where('category_id', $id)->where('status', 1)->get();

        return response()->json(['status' => 'success', 'message' => 'Subcategories fetched successfully', 'data' => $subcategories], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Product $product)
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $vendors = Vendor::where('status', 'approved')->get();
        $productTypes = ProductType::where('status', 1)->get();
        $id = $product->id;


        return view('vendor.pages.product.edit.basic-info', compact('product', 'categories', 'brands', 'productTypes', 'id', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'nullable',
        'brand_id' => 'nullable',
        'vendor_id' => 'required',
        'product_type_id' => 'nullable',
        'long_description' => 'required',
        'affiliate_commission' => 'numeric',
        'thumbnail_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $product->name = $request->name;
    $product->SKU = $request->SKU;
    $product->category_id = $request->category_id;
    $product->subcategory_id = $request->subcategory_id ?? null;
    $product->brand_id = $request->brand_id ?? null;
    $product->vendor_id = $request->vendor_id ?? null;
    $product->product_type_id = $request->product_type_id ?? null;

    $product->short_description = $request->short_description;
    $product->long_description = $request->long_description;

    $product->shipping_return_text = $request->shipping_return_text;
    $product->additional_info_text = $request->additional_info_text;
    $product->youtube_link = $request->youtube_link;

    $product->meta_title = $request->meta_title;
    $product->meta_description = $request->meta_description;
    $product->meta_keywords = $request->meta_keywords;
    $product->google_schema = $request->google_schema;
    $product->affiliate_commission = $request->affiliate_commission;

 // Thumbnail image
if ($request->hasFile('thumbnail_img')) {
    // Delete old file
    if ($product->thumbnail_img && file_exists(public_path($product->thumbnail_img))) {
        unlink(public_path($product->thumbnail_img));
    }

    $file = $request->file('thumbnail_img');
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    // Move file to public folder
    $file->move(public_path('public/admin/upload/products/'), $filename);

    // Save path in DB
    $product->thumbnail_img = 'public/admin/upload/products/' . $filename;
}


    // **Meta image**
    if ($request->hasFile('meta_image')) {
        if ($product->meta_image && file_exists(public_path($product->meta_image))) {
            unlink(public_path($product->meta_image));
        }

        $file = $request->file('meta_image');
        $filename = time() . '.' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('admin/upload/products/'), $filename);
        $product->meta_image = 'admin/upload/products/' . $filename;
    }

    $product->save();

   return redirect()->route('vendor.pro-variant-page', ['id' => $product->id]);

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

     public function storeVariant(Request $request)
    {
//        dd($request->all());
        $product_id = $request->product_id;
        $time = time();

        if ($request->variant) {
            $variants = $request->variant;
        }

        if ($request->color) {
            $color = $request->color;
        }

        $savedVariants = [];

        if (!empty($color)) {
            foreach ($color as $vr) {
                $variant = new Productcolor();
                $variant->product_id = $product_id;
                $variant->color_id = $vr['mediaID'];
                $variant->color_name = $vr['color'];
                $variantImg = $vr['image'];

                if ($variantImg) {
                    $imgnamev = $time . $variantImg->getClientOriginalName();
                    $imguploadPathv = ('public/admin/images/variant/');
                    $variantImg->move($imguploadPathv, $imgnamev);
                    $variantImgUrl = $imguploadPathv . $imgnamev;
                    $variant->Image = $variantImgUrl;
                }

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $key => $img) {
                        $imgnamev = $time . $key . '_' . $img->getClientOriginalName();
                        $img->move(public_path('admin/images/variant'), $imgnamev);
                        $imgPaths[] = 'public/admin/images/variant/' . $imgnamev; // store as string path
                    }
                    $variant->Images = json_encode($imgPaths);
                }

                $variant->save();
                $savedVariants[] = $variant;

            }
        }

        if (!empty($variants)) {
            foreach ($variants as $si) {
                $size = new Productvariant();
                $size->product_id = $product_id;
                $size->variant_id = $si['sizeID'];
                $size->productcolor_id = $savedVariants[0]->id;
                $size->variant_name = $si['size'];
                $size->regular_price = $si['RegularPrice'];
                $size->sale_price = $si['Discount'];
                $size->save();
            }
        }

        $response['status'] = 'success';
        $response['message'] = 'Product Create Successfully';

        return json_encode($response);
    }

     public function productColors(Request $request)
    {
        $query = Color::query()->where('status', 1); // active only

        // Search filter
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $variants = $query->get();

        // Format for select2 or similar
        $variantList = [];
        foreach ($variants as $item) {
            $variantList[] = [
                'id' => $item->id,
                'text' => $item->name
            ];
        }

        return response()->json([
            'data' => $variantList
        ]);
    }

     public function productVariants(Request $request)
    {
        $query = Variant::query()->where('status', 1); // active only

        // Search filter
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $variants = $query->get();

        // Format for select2 or similar
        $variantList = [];
        foreach ($variants as $item) {
            $variantList[] = [
                'id' => $item->id,
                'text' => $item->name
            ];
        }

        return response()->json([
            'data' => $variantList
        ]);
    }

     public function variantProducts(string $id, Request $request)
    {
        $variants = Productvariant::with('product', 'variant', 'productcolor')->where('product_id', $id);

        return DataTables::eloquent($variants)
            ->addColumn('action', function ($admin) {
                $editAction = '';
                $deleteAction = '';
//                  $subcategoriesAction = '<a class="editButton btn btn-sm btn-danger" href="'.route('admin.subcategory.index',$admin->id).'">
//                                   <i class="fas fa-edit"></i></a>';

                $editAction = '<a class="editButton btn btn-sm btn-info" href="' . route('admin.edit-product-variant', $admin->id) . '" >
                                   <i class="fas fa-edit"></i></a>';

                $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';


//              if(Auth::guard('admin')->user()->can('Edit Admin')) {
//
//                  $editAction= '<a class="editButton btn btn-sm btn-primary" href="javascript:void(0)"
//                                    data-id="'.$admin->id.'" data-bs-toggle="modal" data-bs-target="#editAdminModal">
//                                    <i class="fas fa-edit"></i></a>';
//
//              }
//
//              if(Auth::guard('admin')->user()->can('Delete Admin')) {
//
//                  $deleteAction= '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
//                                    data-id="'.$admin->id.'" id="deleteAdminBtn"">
//                                    <i class="fas fa-trash"></i></a>';
//
//              }

                return '<div class="d-flex gap-3"> ' . $editAction . $deleteAction . '</div>';
            })
            ->addColumn('stockInfo',function ($admin)
            {
                return "<span>Total stock: <span class='font-weight-bold'>$admin->total_stock</span></span><br><br>
                        <span>Available stock: <span class='font-weight-bold'>$admin->available_stock</span></span><br><br>
                        <span>Sold stock: <span class='font-weight-bold'>$admin->sold_stock</span></span>";
            })
            ->addColumn('pro_image', function ($admin) {
                return '<img src="' . asset($admin->product->thumbnail_img) . '" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">';
            })
            ->rawColumns(['action', 'pro_image','stockInfo'])
            ->addIndexColumn()
            ->make(true);
    }

    public function deleteProductVariant(string $id)
    {
        Productvariant::find($id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Product Variant deleted successfully'], 200);
    }

}
