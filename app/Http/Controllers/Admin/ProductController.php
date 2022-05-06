<?php

namespace App\Http\Controllers\Admin;

use DB;
use Storage;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $productRepo;
    protected $brandRepo;
    protected $categoryRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        BrandRepositoryInterface $brandRepo,
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepo
            ->paginate(config('pagination.per_page'));

        return view('admins.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepo->getRootCategoriesWith();
        $brands = $this->brandRepo->getAll();

        return view('admins.products.create', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        if (!Storage::exists('products')) {
            Storage::makeDirectory('products');
        }

        try {
            DB::beginTransaction();

            $product = $this->productRepo->create([
                'title' => $request->title,
                'slug' => $request->slug,
                'quantity' => $request->quantity,
                'price'=> $request->price,
                'promotion_price'=> $request->promotion_price,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'content' => $request->content,
                'specifications'=> $request->specifications,
            ]);

            if ($request->has('image')) {
                $files = $request->image;
                foreach ($files as $key => $file) {
                    $new_name = time() . "-product-$key-"
                        . Str::slug($request->name) . '.'
                        . $file->getClientOriginalExtension();

                    $file->storeAs('products', $new_name);

                    $this->productRepo->createImage($product->id, [
                        'name' => $new_name,
                        'url' => Storage::url('products/' . $new_name),
                    ]);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.products.index')->with('success', __('Created Successfully'));
    }

    /**
     * Delete image.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($product_id, $image_id)
    {
        try {
            if ($this->productRepo->findAndDeleteImage($product_id, $image_id)) {
                return redirect()->back()->with('success', __('Deleted Successfully'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->back()->with('error', __('Cannot delete'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->productRepo->findOrFail($id);
        $categories = $this->categoryRepo->getRootCategoriesWith();
        $brands = $this->brandRepo->getAll();

        return view('admins.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productRepo->findOrFail($id);

        if (!Storage::exists('products')) {
            Storage::makeDirectory('products');
        }

        try {
            DB::beginTransaction();

            $this->productRepo->update($product->id, [
                'title' => $request->title,
                'slug' => $request->slug,
                'quantity' => $request->quantity,
                'price'=> $request->price,
                'promotion_price'=> $request->promotion_price,
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'content' => $request->content,
                'specifications'=> $request->specifications,
            ]);

            if ($request->has('image')) {
                $files = $request->image;
                foreach ($files as $key => $file) {
                    $new_name = time() . "-product-$key-"
                        . Str::slug($request->name) . '.'
                        . $file->getClientOriginalExtension();

                    $file->storeAs('products', $new_name);

                    $this->productRepo->createImage($product->id, [
                        'name' => $new_name,
                        'url' => Storage::url('products/' . $new_name),
                    ]);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.products.index')->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = $this->productRepo->delete($id);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.products.index')
            ->with('success', __('Deleted Successfully'));
    }
}
