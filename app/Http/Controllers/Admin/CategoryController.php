<?php

namespace App\Http\Controllers\Admin;

use DB;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->categoryRepo->getRootCategoriesWith();

        return view('admins.categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $this->categoryRepo->create($request->validated());
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.categories.index')
                ->with('success', __('Add category successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category_edit = $this->categoryRepo->findOrFail($id);

            $categories = $this->categoryRepo->getRootCategoriesWith();
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return view('admins.categories.edit', [
            'category_edit' => $category_edit,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = $this->categoryRepo->update($id, $request->validated());
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.categories.index')
            ->with('success', __('Update category successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Update children cate when delete
            $this->categoryRepo->updateChildrenNullWhenDetele($id);

            $this->categoryRepo->delete($id);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.categories.index')
            ->with('success', __('Delete category successfully'));
    }
}
