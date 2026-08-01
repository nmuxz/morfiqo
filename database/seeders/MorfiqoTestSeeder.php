<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\CustomerBodyProfile;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MorfiqoTestSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Create Roles
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $storeOwnerRole = Role::create(['name' => 'store_owner']);
        $customerRole = Role::create(['name' => 'customer']);

        // 1. Create Users & Assign Roles
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@morfiqo.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole($superAdminRole);

        $owner = User::create([
            'name' => 'Store Owner',
            'email' => 'owner@morfiqo.com',
            'password' => Hash::make('password')
        ]);
        $owner->assignRole($storeOwnerRole);

        $store = Store::create([
            'user_id' => $owner->id,
            'name' => 'Distro Gaul',
            'domain' => 'distrogaul'
        ]);

        // 2. Create a Product
        $product = Product::create([
            'store_id' => $store->id,
            'name' => 'Kaos Oblong Basic',
            'type' => 'top',
            'description' => 'Kaos oblong nyaman dipakai.'
        ]);

        // 3. Create Product Sizes (S, M, L, XL)
        // Lebar dada M = 50cm, Lingkar dada = 100cm
        ProductSize::create(['product_id' => $product->id, 'size_label' => 'S', 'chest_width_cm' => 48, 'body_length_cm' => 68, 'stock' => 10]);
        ProductSize::create(['product_id' => $product->id, 'size_label' => 'M', 'chest_width_cm' => 50, 'body_length_cm' => 70, 'stock' => 10]);
        ProductSize::create(['product_id' => $product->id, 'size_label' => 'L', 'chest_width_cm' => 52, 'body_length_cm' => 72, 'stock' => 10]);
        ProductSize::create(['product_id' => $product->id, 'size_label' => 'XL', 'chest_width_cm' => 54, 'body_length_cm' => 74, 'stock' => 10]);

        // 4. Create a Customer & Body Profile
        $customer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password')
        ]);
        $customer->assignRole($customerRole);

        // Budi is 175cm, 75kg, with chest circumference 102cm
        CustomerBodyProfile::create([
            'user_id' => $customer->id,
            'height_cm' => 175,
            'weight_kg' => 75,
            'chest_circumference_cm' => 102
        ]);
    }
}
