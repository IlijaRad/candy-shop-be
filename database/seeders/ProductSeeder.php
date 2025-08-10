<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Database\Factories\ReviewFactory;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = File::json(database_path('static/data/products.json'));

        collect($products)->each(function (array $data) {
            $filePath = database_path("static/assets/products/{$data['image_path']}");

            $file = new UploadedFile(
                $filePath,
                $data['image_path'],
                mime_content_type($filePath),
                null,
                true
            );

            Storage::disk('s3')->put('products/' . $data['image_path'], file_get_contents($file));
            $path = Storage::disk('s3')->url('products/' . $data['image_path']);

            $product = Product::query()->create([
                ...Arr::except($data, ['image_path']),
                Product::DEFAULT_IMAGE_PATH => $path,
            ]);

            Review::factory()->for($product)->count(10)->create();
        });
    }
}
