<?php

namespace App\Http\Controllers\Admin;

use DB;
use Storage;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Repositories\Brand\BrandRepositoryInterface;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    protected $brandRepo;

    public function __construct(
        BrandRepositoryInterface $brandRepo
    ) {
        $this->brandRepo = $brandRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->brandRepo
            ->paginate(config('pagination.per_page'));

        return view('admins.brands.index', [
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admins.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBrandRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $file = $request->image;
        $new_name = time() . '-brand-' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();

        if (!Storage::exists('brands')) {
            Storage::makeDirectory('brands');
        }
        try {
            DB::beginTransaction();

            $brand = $this->brandRepo->create([
                'name' => $request->name,
                'slug' => $request->slug
            ]);

            $file->storeAs('brands', $new_name);

            $brand->logo()->create([
                'name' => $new_name,
                'url' => Storage::url('brands/' . $new_name),
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.brands.create')->with('success', __('Created Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand_edit = $this->brandRepo->findOrFail($id);

        return view('admins.brands.edit', [
            'brand_edit' => $brand_edit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBrandRequest  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, $id)
    {
        $brand = $this->brandRepo->findOrFail($id);
        $currentFile = $brand->logo->name;

        try {
            DB::beginTransaction();

            if ($request->has('image')) {
                $file = $request->image;
                $new_name = time() . '-brand-' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();

                Storage::delete('brands/' . $currentFile);
                $file->storeAs('brands', $new_name);

                $brand->logo()->update([
                    'name' => $new_name,
                    'url' => Storage::url('brands/' . $new_name),
                ]);
            }

            $brand->update([
                'name' => $request->name,
                'slug' => $request->slug
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }


        return redirect()->route('admin.brands.index')->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $brand = $this->brandRepo->delete($id);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.brands.index')
            ->with('success', __('Deleted Successfully'));
    }
}
