<?php

declare(strict_types=1);

namespace CodeShopping\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

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
        try {
            \DB::beginTransaction();
            $product = Product::find($productId);
            self::uploadFiles($product->slug, $files);
            $photos = self::createPhotosModels($product->id, $files);
            \DB::commit();
            return new Collection($photos);
        } catch (\Exception $e) {
            \DB::rollBack();
            self::deleteFiles($product->slug, $files);
            throw $e;
        }
        
    }

    public function updateWithPhoto(UploadedFile $file): ProductPhoto
    {
        try {
            \DB::beginTransaction();
            self::uploadFiles($this->product->slug, [$file]);
            $this->deletePhoto($this->file_name);
            $this->file_name = $file->hashName();
            $this->save();
            \DB::commit();
            return $this;
        } catch (\Exception $e) {
            \DB::rollBack();
            self::deleteFiles($this->product->slug, [$file]);
            throw $e;
        }
    }

    public function deleteWithPhoto(): bool 
    {
        try {
            \DB::beginTransaction();
            $this->deletePhoto($this->file_name);
            $result = $this->delete();
            \DB::commit();
            return $result;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    private function deletePhoto($fileName)
    {
        $dir = self::photosDir($this->product->slug);
        \Storage::disk('public')->delete("{$dir}/{$fileName}");
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

    private static function deleteFiles($productSlug, array $files)
    {
        foreach ($files as $file) {
            $path = self::photosPath($productSlug);
            $filePath = "{$path}/{$file->hashName()}";
            if (file_exists($filePath)) {
                \File::delete($filePath);
            }
        }
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
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
