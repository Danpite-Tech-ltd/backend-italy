<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\ProductTag;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    // home page category wise products
    public function frontCategoriesProducts()
    {
        $products = Category::where('status', 1)->where('front_status', 1)
            ->orderBy('id', 'DESC')
            ->with(['products', 'products.firstvariant'])
            ->select('id', 'name', 'slug')
            ->limit(24)
            ->get();

        return $this->success(
            message: 'Category by products',
            data: $products
        );
    }

    public function searchProduct($keyword)
    {
        $products = Product::where('status', 1)
            ->where('name', 'LIKE', "%{$keyword}%")
            ->with(['firstvariant'])
            ->select('id', 'name', 'slug', 'thumbnail_img')
            ->orderBy('id', 'DESC')
            ->limit(24)
            ->get();

        return $this->success(
            message: 'Search result for "' . $keyword . '"',
            data: $products
        );
    }

    public function productDetails($slug)
    {
        $products = Product::where(['slug' => $slug, 'status' => 1])
            ->with(['productcolors', 'productvariants', 'vendor', 'reviews'])
            ->firstOrFail();

        return $this->success(
            message: 'Product Details',
            data: $products
        );
    }

    public function relatedProducts($slug)
    {
        $product = Product::where(['slug' => $slug, 'status' => 1])->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->with(['firstvariant'])
            ->select('id', 'category_id', 'name', 'slug', 'thumbnail_img')
            ->orderBy('id', 'DESC')
            ->limit(24)
            ->get();

        return $this->success(
            message: 'Related products',
            data: $relatedProducts
        );
    }

    public function brandProducts($slug)
    {
        $brand = Brand::where('slug', $slug)->where('status', 1)->firstOrFail();

        $products = Product::where(['status' => 1, 'brand_id' => $brand->id])
            ->with(['firstvariant'])
            ->select('id', 'name', 'brand_id', 'slug', 'thumbnail_img')
            ->orderBy('id', 'DESC')
            ->paginate(24);

        return response()->json([
            'status' => true,
            'massage' => 'Brand wise product',
            'brand' => $brand,
            'data' => $products
        ]);
    }
    public function categoryProducts(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $products = Product::query();

        $products->where('products.status', 1)
            ->where('products.category_id', $category->id)

            ->leftJoin('productvariants', 'products.id', '=', 'productvariants.product_id')

            ->with('firstVariant')

            ->distinct()

            ->select(
                'products.id',
                'products.category_id',
                'products.name',
                'products.slug',
                'products.thumbnail_img',
                'products.tag_names',
                'products.created_at'
            );

        /*
        |--------------------------------------------------------------------------
        | Tag Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tags')) {

            $products->where(function ($query) use ($request) {

                foreach ($request->tags as $tag) {
                    $query->orWhereJsonContains('products.tag_names', $tag);
                }

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        switch ($request->filter) {

            case 'price_asc':
                $products->orderBy('productvariants.sale_price', 'ASC');
                break;

            case 'price_dsc':
                $products->orderBy('productvariants.sale_price', 'DESC');
                break;

            case 'newest':
                $products->orderBy('products.id', 'DESC');
                break;

            case 'oldest':
                $products->orderBy('products.id', 'ASC');
                break;

            default:
                $products->orderBy('products.id', 'DESC');
                break;
        }

        $products = $products->paginate(24);

        return response()->json([
            'status' => true,
            'message' => 'Category wise products',
            'category' => $category,
            'data' => $products
        ]);
    }

    public function subcategoryProducts(Request $request, $slug)
    {
        // Subcategory Find
        $subcategory = Subcategory::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        // Product Query
        $products = Product::query();

        $products->where('products.status', 1)
            ->where('products.subcategory_id', $subcategory->id)

            // Variant Join
            ->leftJoin('productvariants', 'products.id', '=', 'productvariants.product_id')

            // Relation Load
            ->with('firstVariant')

            // Remove Duplicate
            ->distinct()

            ->select(
                'products.id',
                'products.subcategory_id',
                'products.category_id',
                'products.branch_id',
                'products.name',
                'products.slug',
                'products.thumbnail_img',
                'products.tag_names',
                'products.created_at'
            );

        /*
        |--------------------------------------------------------------------------
        | Tag Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tags')) {

            $products->where(function ($query) use ($request) {

                foreach ($request->tags as $tag) {
                    $query->orWhereJsonContains('products.tag_names', $tag);
                }

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting Filter
        |--------------------------------------------------------------------------
        */

        switch ($request->filter) {

            case 'price_asc':
                $products->orderBy('productvariants.sale_price', 'ASC');
                break;

            case 'price_dsc':
                $products->orderBy('productvariants.sale_price', 'DESC');
                break;

            case 'newest':
                $products->orderBy('products.id', 'DESC');
                break;

            case 'oldest':
                $products->orderBy('products.id', 'ASC');
                break;

            default:
                $products->orderBy('products.id', 'DESC');
                break;
        }

        // Pagination
        $products = $products->paginate(24);

        // Response
        return response()->json([
            'status' => true,
            'message' => 'subcategory wise product',
            'subcategory' => $subcategory,
            'data' => $products
        ]);
    }

    public function childcategoryProducts($slug)
    {
        $category = ChildCategory::where('slug', $slug)->where('status', 1)->firstOrFail();
        $products = Product::where(['status' => 1, 'childcategory_id' => $category->id])
            ->with(['productcolors', 'productvariants'])
            ->orderBy('id', 'DESC')
            ->paginate(24);

        return $this->success(
            message: 'Child Category Products',
            data: $products
        );
    }

    public function flashSale()
    {
        $products = Product::where(['status' => 1, 'product_type_id' => 1])
            ->with(['firstvariant'])
            ->select('id', 'name', 'slug', 'thumbnail_img')
            ->orderBy('id', 'DESC')
            ->limit(24)
            ->get();

        return $this->success(
            message: 'Flash sale products',
            data: $products
        );
    }

    public function dailyDeals()
    {
        $products = Product::where(['status' => 1, 'product_type_id' => 2])
            ->with(['firstvariant'])
            ->select('id', 'name', 'slug', 'thumbnail_img')
            ->orderBy('id', 'DESC')
            ->limit(24)
            ->get();

        return $this->success(
            message: 'Daily deals products',
            data: $products
        );
    }

    public function productTags()
    {
        $tags = ProductTag::where('status', 1)->get();

        return $this->success(
            message: 'Product Tags',
            data: $tags
        );
    }
}
