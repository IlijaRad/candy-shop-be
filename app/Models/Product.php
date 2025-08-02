<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public const TABLE = 'products';

    public const ID = 'id';
    public const NAME = 'name';
    public const SLUG = 'slug';
    public const SKU = 'sku';
    public const STOCK = 'stock';
    public const DESCRIPTION = 'description';
    public const DEFAULT_IMAGE_PATH = 'default_image_path';
    public const PRICE = 'price';
    public const DISCOUNTED_PRICE = 'discounted_price';
    public const CATEGORY_ID = 'category_id';
    public const BRAND_ID = 'brand_id';
    public const PUBLISHED_AT = 'published_at';
    public const NUTRITIONAL_VALUES = 'nutritional_values';
    public const INGREDIENTS = 'ingredients';
    public const ALLERGENS = 'allergens';
    public const COUNTRY_OF_ORIGIN = 'country_of_origin';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'price',
        'discounted_price',
        'stock',
        'description',
        // 'category_id',
        // 'brand_id',
        'product_information',
    ];

    protected $casts = [
        'product_information' => 'array',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
