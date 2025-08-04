<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = File::json(database_path('static/data/products.json'));

        collect($products)->each(function (array $data) {
            $file = new UploadedFile(
                database_path("static/assets/products/{$data['image_path']}"),
                $data['image_path'],
            );

            $path = $file->storePublicly('products');

            Product::query()->create([
                ...Arr::except($data, ['image_path']),
                Product::DEFAULT_IMAGE_PATH => $path,
            ]);
        });
    }
}
