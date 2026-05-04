<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $table_rows = array(
            [
                'group_name' => 'Dashboard',
                'permissions' => [
                    'Admin Dashboard',
                ]
            ],

            [
                'group_name' => 'Admin',
                'permissions' => [
                    'View Admin',
                    'Create Admin',
                    'Edit Admin',
                    'Delete Admin',
                ]
            ],

            [
                'group_name' => 'Role',
                'permissions' => [
                    'View Role',
                    'Create Role',
                    'Edit Role',
                    'Delete Role',
                    'Assign Permission'
                ]
            ],

            [
                'group_name' => 'Permission',
                'permissions' => [
                    'View Permission',
                ]
            ],

            [
                'group_name' => 'User',
                'permissions' => [
                    'View User',
                    'Create User',
                    'Edit User',
                    'Delete User',
                ]
            ],

            [
                'group_name' => 'Subscription',
                'permissions' => [
                    'View Subscription',
                ]
            ],

            [
                'group_name' => 'Affiliate',
                'permissions' => [
                    'View Affiliate',
                    'Create Affiliate',
                    'Edit Affiliate',
                    'Delete Affiliate',
                    'Show Affiliate'
                ]
            ],
            //Product Management
            [
                'group_name' => 'Category',
                'permissions' => [
                    'View Category',
                    'Create Category',
                    'Edit Category',
                    'Delete Category',
                ]
            ],

            [
                'group_name' => 'Subcategory',
                'permissions' => [
                    'View Subcategory',
                    'Create Subcategory',
                    'Edit Subcategory',
                    'Delete Subcategory',
                ]
            ],

            [
                'group_name' => 'Child Category',
                'permissions' => [
                    'View Child Category',
                    'Create Child Category',
                    'Edit Child Category',
                    'Delete Child Category',
                ]
            ],

            [
                'group_name' => 'Brand',
                'permissions' => [
                    'View Brand',
                    'Create Brand',
                    'Edit Brand',
                    'Delete Brand',
                ]
            ],

            [
                'group_name' => 'Product Type',
                'permissions' => [
                    'View Type',
                ]
            ],


            [
                'group_name' => 'Product',
                'permissions' => [
                    'View Product',
                    'Create Product',
                    'Edit Product',
                    'Delete Product',
                    'Status Product'
                ]
            ],

            [
                'group_name' => 'Color',
                'permissions' => [
                    'View Color',
                    'Create Color',
                    'Edit Color',
                    'Delete Color',
                    'Status Color'
                ]
            ],

            [
                'group_name' => 'Variant',
                'permissions' => [
                    'View Variant',
                    'Create Variant',
                    'Edit Variant',
                    'Delete Variant',
                    'Status Variant'
                ]
            ],

            //Order Management

            [
                'group_name' => 'Coupon',
                'permissions' => [
                    'View Coupon',
                    'Create Coupon',
                    'Edit Coupon',
                    'Delete Coupon',
                ]
            ],

            [
                'group_name' => 'Order',
                'permissions' => [
                    'View Order',
                    'Create Order',
                    'Edit Order',
                    'Delete Order',
                    'Status Order'
                ]
            ],

            //Inventory Manage
            [
                'group_name' => 'Supplier',
                'permissions' => [
                    'View Supplier',
                    'Create Supplier',
                    'Edit Supplier',
                    'Delete Supplier',
                ]
            ],

            [
                'group_name' => 'Purchase',
                'permissions' => [
                    'View Purchase',
                    'Create Purchase',
                    'Edit Purchase',
                    'Delete Purchase',
                ]
            ],

            [
                'group_name' => 'Inventory',
                'permissions' => [
                    'View Inventory',
                ]
            ],

            // Wholesale
            [
                'group_name' => 'Wholesale Customer',
                'permissions' => [
                    'View wCustomer',
                    'Create wCustomer',
                    'Edit wCustomer',
                    'Delete wCustomer',
                ]
            ],

            [
                'group_name' => 'Wholesale',
                'permissions' => [
                    'View Wholesale',
                    'Create Wholesale',
                    'Edit Wholesale',
                    'Delete Wholesale',
                ]
            ],

            [
                'group_name' => 'Wholesale Stocks',
                'permissions' => [
                    'View wStocks',
                ]
            ],

            [
                'group_name' => 'Slider',
                'permissions' => [
                    'View Slider',
                    'Create Slider',
                    'Edit Slider',
                    'Delete Slider',
                ]
            ],

            [
                'group_name' => 'Banner',
                'permissions' => [
                    'View Banner',
                    'Create Banner',
                    'Edit Banner',
                    'Delete Banner',
                ]
            ],

            //API
            [
                'group_name' => 'API',
                'permissions' => [
                    'Courier API',
                    'SMS Gateway',
                    'Payment Gateway',

                ]
            ],

            //Blog
            [
                'group_name' => 'Blog',
                'permissions' => [
                    'View Blog',
                    'Create Blog',
                    'Edit Blog',
                    'Delete Blog',
                ]
            ],

            //Page
            [
                'group_name' => 'Page',
                'permissions' => [
                    'View Page',
                    'Create Page',
                    'Edit Page',
                    'Delete Page',
                ]
            ],

            //Reports
            [
                'group_name' => 'Report',
                'permissions' => [
                    'Sales Report',
                ]
            ],

            //Settings
            [
                'group_name' => 'Settings',
                'permissions' => [
                    'Basic Info',
                    'Shipping Charge',
                    'Order Status',
                    'Pixel',
                    'Google Tag',
                ]
            ],

        );

        foreach ($table_rows as $i => $iValue) {
            $group_name = $iValue['group_name'];

            foreach ($iValue['permissions'] as $j => $jValue) {
                Permission::create([
                    'name' => $iValue['permissions'][$j],
                    'group_name' => $group_name
                ]);
            }
        }

    }
}
