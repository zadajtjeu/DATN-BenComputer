<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo
    ) {
        $this->productRepo = $productRepo;
    }

    public function getDetails($slug, $id)
    {
        $product_details = $this->productRepo->getProductDetails($slug, $id);

        $product_ratings = $this->productRepo
            ->getProductRatings(
                $product_details->id,
                config('pagination.rating_per_page')
            );

        $related_products = $this->productRepo
            ->getRelatedProducts(
                $product_details,
                config('pagination.related')
            );

        return view('users.productdetails', [
            'product_details' => $product_details,
            'product_ratings' => $product_ratings,
            'related_products' => $related_products,
        ]);
    }

    public function brandDetails($slug)
    {
        //
    }

    public function categoryDetails($slug)
    {
        //
    }

    public function search(Request $request)
    {
        $search = $request->q;

        $paginate = config('pagination.per_page');
        if ($request->show && is_int($request->show)) {
            $paginate = $request->show;
        }

        if ($search) {
            $list_products = $this->productRepo
                ->searchProduct($search, $paginate);
        } else {
            return redirect()->back();
        }

        return view('users.search', [
            'list_products' => $list_products,
        ]);
    }

    public function searchAjax(Request $request)
    {
        $search = $request->q;

        $paginate = config('pagination.per_page');
        if ($request->show && is_int($request->show)) {
            $paginate = $request->show;
        }

        if ($search) {
            $list_products = $this->productRepo
                ->searchProductAjax($search, $paginate);
        } else {
            return redirect()->back();
        }

        return response()->json($list_products);
    }
}
