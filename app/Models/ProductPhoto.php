<?php

namespace CodeShopping\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    const BASE_PATH = 'app/public';
    const DIR_PRODUCTS = 'products';

    const PRODUCTS_PATH = self::BASE_PATH . '/' . self::DIR_PRODUCTS;

    protected $fillable = ['product_id', 'file_name'];

    public static function photosPath($productSlug)
    {
        $path = self::PRODUCTS_PATH;
        return storage_path("{$path}/{$productSlug}");
    }

    public static function uploadFiles($productSlug, array $files)
    {
        $dir = self::photosDir($productSlug);
        foreach ($files as $file) {
            $file->store($dir,['disk' => 'public']);
        }
    }

    public static function photosDir($productSlug)
    {
        $dir = self::DIR_PRODUCTS;
        return "{$dir}/{$productSlug}";
    }

    public function getPhotoUrlAttribute() 
    {
        $path = self::photosDir($this->product->slug);
        return asset("william/{$path}/{$this->file_name}");
    }

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }
}
