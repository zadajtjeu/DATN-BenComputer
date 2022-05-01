<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductController extends Controller
{
    public function __construct(
        ProductRepositoryInterface $productRepo
    ) {
        $this->productRepo = $productRepo;
    }

    public function getDetails($slug, $id)
    {
        $product = $this->productRepo->getProductDetails($slug, $id);

        dd($product);

        return true;
    }
}
