<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ProductsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if (empty($row['name']) || empty($row['sku'])) {
                continue;
            }

            $categoryId = null;

            if (!empty($row['category'])) {
                $category = Category::where('name', trim($row['category']))->first();

                if ($category) {
                    $categoryId = $category->id;
                }
            }

            Product::updateOrCreate(
                [
                    'SKU' => trim($row['sku'])
                ],
                [
                    'name'               => trim($row['name']),
                    'slug' => Str::slug($row['name']) . '-' . uniqid(),
                    'category_id'        => $categoryId,
                    'short_description'  => $row['short_description'] ?? null,
                    'long_description'   => $row['long_description'] ?? null,
                    'status'             => $row['status'] ?? 1,
                ]
            );
        }
    }
}
