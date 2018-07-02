<?php

declare(strict_types=1);

namespace CodeShopping\Models;

use Illuminate\Database\Eloquent\Collection;
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

    public static function createWithPhotosFiles(int $productId, array $files)
    {
        $product = Product::find($productId);
        self::uploadFiles($product->slug, $files);
        $photos = self::createPhotosModels($product->id, $files);
        return new Collection($photos);
    }

    private static function createPhotosModels(int $productId, array $files): array
    {
        $photos = [];
        foreach($files as $file) {
            $photos[] = self::create([
                'product_id' => $productId,
                'file_name' => $file->hashName()
            ]);
        }
        return $photos;
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
        return asset("storage/{$path}/{$this->file_name}");
    }

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }
}
