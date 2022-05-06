<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Brand\BrandRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $brandRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        CategoryRepositoryInterface $categoryRepo,
        BrandRepositoryInterface $brandRepo
    ) {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->brandRepo = $brandRepo;
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

    public function categoryDetails(Request $request, $slug)
    {
        $paginate = config('pagination.per_page');
        $sort = $request->sort;
        $search = $request->search;
        $brand = $request->brand;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;

        // Number per page
        if ($request->show && is_numeric($request->show)
            && $request->show % 12 == 0
        ) {
            $paginate = $request->show;
        }

        $category = $this->categoryRepo->findBySlug($slug);

        $list_categories_id = $this->categoryRepo
            ->getChildrenCategoriesID($category->id);

        $filter = [
            'paginate' => $paginate,
            'sort' => $sort,
            'search' => $search,
            'brand' => $brand,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'categories_id' => $list_categories_id,
        ];

        $products = $this->productRepo->getProductWithFilter($filter);

        return view('users.products.category', [
            'category' => $category,
            'products' => $products,
        ]);
    }

    public function brandDetails(Request $request, $slug)
    {
        $paginate = config('pagination.per_page');
        $sort = $request->sort;
        $search = $request->search;
        $brand = $request->brand;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;

        // Number per page
        if ($request->show && is_numeric($request->show)
            && $request->show % 12 == 0
        ) {
            $paginate = $request->show;
        }

        $brand = $this->brandRepo->findBySlug($slug);

        $filter = [
            'paginate' => $paginate,
            'sort' => $sort,
            'search' => $search,
            'brand' => [$brand->id],
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
        ];

        $products = $this->productRepo->getProductWithFilter($filter);

        return view('users.products.brand', [
            'brand' => $brand,
            'products' => $products,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->q;

        $paginate = config('pagination.per_page');
        if ($request->show && is_numeric($request->show)
            && $request->show % 12 == 0
        ) {
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
        if ($request->show && is_numeric($request->show)
            && $request->show % 12 == 0
        ) {
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
