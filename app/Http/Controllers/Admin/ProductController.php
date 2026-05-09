<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicInfo;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Productcolor;
use App\Models\ProductType;
use App\Models\Productvariant;
use App\Models\Subcategory;
use App\Models\Variant;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Sabberworm\CSS\Value\Size;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [

            new Middleware('permission:View Product', only: ['index']),
            new Middleware('permission:Create Product', only: ['store', 'create']),
            new Middleware('permission:Edit Product', only: ['update', 'edit']),
            new Middleware('permission:Delete Product', only: ['destroy']),
            new Middleware('permission:Status Product', only: ['changeProductStatus']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $products = Product::with([
                'category' => function ($query) {
                    $query->select('id', 'name');
                },
                'vendor' => function ($query) {
                    $query->select('id', 'company_name');
                },
                'branch' => function ($query) {
                    $query->select('id', 'name');
                },
                'warehouse' => function ($query) {
                    $query->select('id', 'name');
                },
                'type'
            ])
                ->where('status', 1);

            return DataTables::eloquent($products)
                ->addColumn('status', function ($admin) {
                    if (Auth::user()->can('Status Product')) {
                        if ($admin->status == 1) {
                            return ' <a class="status" id="adminStatus" href="javascript:void(0)"
                                               data-id="' . $admin->id . '" data-status="' . $admin->status . '"> <i
                                                        class="fa-solid fa-toggle-on fa-2x"></i>
                                            </a>';
                        } else {
                            return '<a class="status" id="adminStatus" href="javascript:void(0)"
                                               data-id="' . $admin->id . '" data-status="' . $admin->status . '"> <i
                                                        class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                                            </a>';
                        }
                    }
                    return '';
                })
                ->addColumn('product_price', function ($admin) {
                    return $admin->productvariants->first()->sale_price ?? 0;
                })


                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Edit Product')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="' . route('admin.product.edit', $admin->id) . '">
                                   <i class="fas fa-edit"></i></a>';
                    }
                    if (Auth::user()->can('Delete Product')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }
                    return '<div class="gap-3 d-flex"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'front_status', 'status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.product.index');
    }


    public function pendingProducts()
    {
        if (request()->ajax()) {
            $products = Product::with([
                'category' => function ($query) {
                    $query->select('id', 'name');
                },
                'vendor' => function ($query) {
                    $query->select('id', 'company_name');
                },
                'branch' => function ($query) {
                    $query->select('id', 'name');
                },
                'warehouse' => function ($query) {
                    $query->select('id', 'name');
                },
                'type'
            ])
                ->where('status', 0);

            return DataTables::eloquent($products)
                ->addColumn('status', function ($admin) {
                    if (Auth::user()->can('Status Product')) {
                        if ($admin->status == 1) {
                            return ' <a class="status" id="adminStatus" href="javascript:void(0)"
                                               data-id="' . $admin->id . '" data-status="' . $admin->status . '"> <i
                                                        class="fa-solid fa-toggle-on fa-2x"></i>
                                            </a>';
                        } else {
                            return '<a class="status" id="adminStatus" href="javascript:void(0)"
                                               data-id="' . $admin->id . '" data-status="' . $admin->status . '"> <i
                                                        class="fa-solid fa-toggle-off fa-2x" style="color: grey"></i>
                                            </a>';
                        }
                    }
                    return '';
                })
                ->addColumn('product_price', function ($admin) {
                    return $admin->productvariants->first()->sale_price ?? 0;
                })


                ->addColumn('action', function ($admin) {
                    $editAction = '';
                    $deleteAction = '';

                    if (Auth::user()->can('Edit Product')) {
                        $editAction = '<a class="editButton btn btn-sm btn-info" href="' . route('admin.product.edit', $admin->id) . '">
                                   <i class="fas fa-edit"></i></a>';
                    }
                    if (Auth::user()->can('Delete Product')) {
                        $deleteAction = '<a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                   data-id="' . $admin->id . '" id="deleteAdminBtn"">
                                   <i class="fas fa-trash"></i></a>';
                    }
                    return '<div class="gap-3 d-flex"> ' . $editAction . $deleteAction . '</div>';
                })
                ->rawColumns(['action', 'front_status', 'status', 'role'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.product.pendingProducts');
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

                return '<div class="gap-3 d-flex"> ' . $editAction . $deleteAction . '</div>';
            })
            ->addColumn('stockInfo', function ($admin) {
                return "<span>Total stock: <span class='font-weight-bold'>$admin->total_stock</span></span><br><br>
                        <span>Available stock: <span class='font-weight-bold'>$admin->available_stock</span></span><br><br>
                        <span>Sold stock: <span class='font-weight-bold'>$admin->sold_stock</span></span>";
            })
            ->addColumn('pro_image', function ($admin) {
                return '<img src="' . asset($admin->product->thumbnail_img) . '" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">';
            })
            ->rawColumns(['action', 'pro_image', 'stockInfo'])
            ->addIndexColumn()
            ->make(true);
    }

    public function deleteProductVariant(string $id)
    {
        Productvariant::find($id)->delete();

        return response()->json(['status' => 'success', 'message' => 'Product Variant deleted successfully'], 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $vendors = Vendor::where('status', 'approved')->get();
        $productTypes = ProductType::where('status', 1)->get();
        $warehouses = Warehouse::where('status', 1)->get();
        $branches = Branch::where('status', 1)->get();

        return view('admin.pages.product.create.basic-info', compact('categories', 'brands', 'productTypes', 'vendors', 'warehouses', 'branches'));
    }

    public function SKUGenerator(string $id)
    {
        // Get the last product (or null if none exists)
        $lastProduct = Product::latest()->first();
        $prefix = Category::where('id', $id)->first()->SKU_prefix ?? 'default';

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
        //      dd($request->all());
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
        $product->branch_id = $request->branch_id ?? null;
        $product->warehouse_id = $request->warehouse_id ?? null;
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


        return redirect()->route('admin.pro-variant-page', $product->id);
    }

    public function proVariantPage(string $id)
    {
        return view('admin.pages.product.create.variant-info', compact('id'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
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
        $warehouses = Warehouse::where('status', 1)->get();
        $branches = Branch::where('status', 1)->get();
        $id = $product->id;


        return view('admin.pages.product.edit.basic-info', compact('product', 'categories', 'brands', 'productTypes', 'id', 'vendors', 'warehouses', 'branches'));
    }

    public function editProductVariant(string $id)
    {
        $productVariant = Productvariant::with('product.productcolors', 'product.productvariants', 'productcolor')->findOrFail($id);
        $productColor = Productcolor::findOrFail($productVariant->productcolor_id);
        $colors = Color::where('status', 1)->get();
        $productVariants = Variant::where('status', 1)->get();

        return view('admin.pages.product.edit.variant-info', compact('productColor', 'productVariant', 'productVariants', 'colors'));
    }

    public function updateProductVariant(Request $request, string $id)
    {
        $productVariant = Productvariant::findOrFail($id);

        $request->validate([
            'productcolor_id' => 'required|exists:colors,id',
            'variant_id' => 'required|integer',
            'RegularPrice' => 'required|numeric',
            'Discount' => 'required|numeric',
        ]);

        $selectedColor = Color::findOrFail($request->productcolor_id);
        $productColor = Productcolor::findOrFail($productVariant->productcolor_id);
        $productColor->color_id = $selectedColor->id;
        $productColor->color_name = $selectedColor->name;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/images/variant/'), $filename);
            $productColor->Image = 'public/admin/images/variant/' . $filename;
        }

        if ($request->hasFile('images')) {
            $imgPaths = [];
            foreach ($request->file('images') as $key => $img) {
                $imgName = time() . '_' . $key . '_' . $img->getClientOriginalName();
                $img->move(public_path('admin/images/variant/'), $imgName);
                $imgPaths[] = 'public/admin/images/variant/' . $imgName;
            }
            $productColor->Images = json_encode($imgPaths);
        }

        $productColor->save();

        $productVariant->productcolor_id = $productColor->id;
        $productVariant->variant_id = $request->variant_id;
        $productVariant->regular_price = $request->RegularPrice;
        $productVariant->sale_price = $request->Discount;

        $variant = Variant::find($request->variant_id);
        if ($variant) {
            $productVariant->variant_name = $variant->name;
        }

        $productVariant->save();

        return response()->json(['status' => 'success', 'message' => 'Variant updated successfully']);
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
        $product->branch_id = $request->branch_id ?? null;
        $product->warehouse_id = $request->warehouse_id ?? null;
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

        return redirect()->route('admin.pro-variant-page', ['id' => $product->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Now delete the product itself
        $product->delete();

        return response()->json(['status' => 'success', 'message' => 'Product deleted successfully'], 200);
    }


    public function changeProductStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        if ($status == 1) {
            $stat = 0;
        } else {
            $stat = 1;
        }

        $page = Product::findOrFail($id);
        $page->status = $stat;
        $page->save();

        return response()->json(['message' => 'success', 'status' => $stat, 'id' => $id]);
    }

    public function createVariant()
    {
        return view('admin.pages.product.create.variant-info');
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
}
