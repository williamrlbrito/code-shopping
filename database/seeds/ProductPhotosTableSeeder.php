<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use CodeShopping\Models\Product;
use CodeShopping\Models\ProductPhoto;
use Illuminate\Support\Collection;

class ProductPhotosTableSeeder extends Seeder
{
    private $allFakerPhotos;
    private $fakerPhotosPath = 'app/faker/product_photos';
    public function run()
    {
        $this->allFakerPhotos = $this->getFakerPhotos();
        $products = Product::all();
        $this->deleteAllPhotosInProductsPath();
        $self = $this;
        $products->each(function($product) use ($self) {
            $self->createPhotoDir($product);
            $self->createPhotosModels($product);
        });
    }

    private function getFakerPhotos(): Collection
    {
        $path = storage_path($this->fakerPhotosPath);
        return collect(\File::allFiles($path));
    }

    private function deleteAllPhotosInProductsPath()
    {
        $path = ProductPhoto::PRODUCTS_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }

    private function createPhotoDir(Product $product)
    {
        $path = ProductPhoto::photosPath($product->slug);
        \File::makeDirectory($path, 0777, true);
    }

    private function createPhotosModels(Product $product)
    {
        foreach (range(1, 5) as $v) {
            $this->createPhotoModel($product);
        }
    }

    private function createPhotoModel(Product $product)
    {
        $photo = ProductPhoto::create([
            'product_id' => $product->id,
            'file_name' => 'imagem.jpg'
        ]);
        $this->generatePhoto($photo);
    }

    private function generatePhoto(ProductPhoto $photo)
    {
        $photo->file_name = $this->uploadPhoto($photo->product->slug);
        $photo->save();
    }

    private function uploadPhoto($productSlug): string
    {
        $photoFile = $this->allFakerPhotos->random();
        $uploadFile = new \Illuminate\Http\uploadedFile(
            $photoFile->getRealPath(),
            str_random() . '.' . $photoFile->getExtension()
        );

        return $uploadFile->hashName();
    }
}
