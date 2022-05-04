<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getProductDetails($slug, $id);

    public function getProductRatings($product_id, $rating_per_page);

    public function getRelatedProducts($product, $amount);

    public function findAndDeleteImage($product_id, $image_id);

    public function createImage($product_id, $image_info);

    public function getWithImages($product_id);

    public function getAllIn($array_id);

    public function updateProductQuantity($product_id, $quantity = 0, $sold = 0);
}
