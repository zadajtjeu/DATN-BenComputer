<?php
namespace App\Repositories\Product;

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
}
