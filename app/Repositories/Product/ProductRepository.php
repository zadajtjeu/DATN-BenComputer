<?php
namespace App\Repositories\Product;

use Storage;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Product::class;
    }

    public function getProductDetails($slug, $id)
    {
        $result = $this->model
            ->where([
                'id' => $id,
                'slug' => $slug,
            ])
            ->with(['category.parent', 'brand', 'ratings'])
            ->firstOrFail();

        return $result;
    }

    public function getProductRatings($product_id, $rating_per_page)
    {
        $ratings = $this->findOrFail($product_id)
            ->ratings()
            ->with('user')
            ->paginate($rating_per_page);

        return $ratings;
    }

    public function getRelatedProducts($product, $amount)
    {
        $related_products = $this->model
            ->where('category_id', $product->category->id)
            ->where('id', '!=', $product->id)
            ->take($amount)
            ->get();

        return $related_products;
    }

    public function findAndDeleteImage($product_id, $image_id)
    {
        $product = $this->findOrFail($product_id);

        $image = $product->images->find($image_id);

        if ($image && $product->images->count() > 1) {
            Storage::delete('products/' . $image->name);

            $image->delete();

            return true;
        }

        return false;
    }

    public function createImage($product_id, $image_info)
    {
        $product = $this->findOrFail($product_id);

        $product->images()->create([
            'name' => $image_info['name'],
            'url' => $image_info['url'],
        ]);
    }

    public function getWithImages($product_id)
    {
        return $this->model->with('images')->findOrFail($product_id);
    }

    public function getAllIn($array_id)
    {
        return $this->model->with('images')->whereIn('id', $array_id)->get();
    }

    public function updateProductQuantity($product_id, $quantity = 0, $sold = 0)
    {
        $product = $this->find($product_id);

        $product->quantity += $quantity;
        $product->sold += $sold;

        if ($product->save()) {
            return true;
        }

        return false;
    }

    public function searchProduct($search, $paginate)
    {
        return $this->model->FullTextSearch($search)
            ->paginate($paginate)->withQueryString();
    }

    public function searchProductAjax($search, $paginate)
    {
        return $this->model->FullTextSearch($search)->take($paginate)->get();
    }

    public function getProductWithFilter($filter)
    {
        $products = $this->model;

        if (!empty($filter['categories_id'])) {
            $products = $products->whereIn('category_id', $filter['categories_id']);
        }

        if (!empty($filter['brand'])) {
            $products = $products->whereIn('brand_id', $filter['brand']);
        }

        if (!empty($filter['search'])) {
            $products = $products->FullTextSearch($filter['search']);
        }

        if (isset($filter['minPrice']) && !empty($filter['maxPrice'])) {
            $products = $products
                ->whereBetween('price', [$filter['minPrice'], $filter['maxPrice']]);
        }

        // Sort
        if ($filter['sort']) {
            switch ($filter['sort']) {
                case 'newest':
                    $products = $products->orderBy('created_at', 'DESC');
                    break;
                case 'top_seller':
                    $products = $products->orderBy('sold', 'DESC');
                    break;
                case 'price_asc':
                    $products = $products->orderBy('price');
                    break;
                case 'price_desc':
                    $products = $products->orderBy('price', 'DESC');
                    break;
                default:
                    $products = $products->orderBy('created_at', 'DESC');
                    break;
            }
        }

        $products = $products->paginate($filter['paginate'])->withQueryString();


        return $products;
    }
}
