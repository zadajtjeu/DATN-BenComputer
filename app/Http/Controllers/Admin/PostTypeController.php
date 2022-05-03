<?php

namespace App\Http\Controllers\Admin;

use DB;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostType\StorePostTypeRequest;
use App\Http\Requests\PostType\UpdatePostTypeRequest;
use App\Repositories\PostType\PostTypeRepositoryInterface;

class PostTypeController extends Controller
{
    protected $postTypeRepo;

    public function __construct(
        PostTypeRepositoryInterface $postTypeRepo
    ) {
        $this->postTypeRepo = $postTypeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postTypes = $this->postTypeRepo->getRootPostTypesWith();

        return view('admins.posttypes.index', [
            'postTypes' => $postTypes,
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
     * @param  \App\Http\Requests\StorePostTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostTypeRequest $request)
    {
        try {
            $this->postTypeRepo->create($request->validated());
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.posttypes.index')
                ->with('success', __('Created Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PostType  $postType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PostType  $postType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $posttype_edit = $this->postTypeRepo->findOrFail($id);

            $postTypes = $this->postTypeRepo->getRootPostTypesWith();
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return view('admins.posttypes.edit', [
            'posttype_edit' => $posttype_edit,
            'postTypes' => $postTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostTypeRequest  $request
     * @param  \App\Models\PostType  $postType
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostTypeRequest $request, $id)
    {
        try {
            $postType = $this->postTypeRepo->update($id, $request->validated());
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.posttypes.index')
            ->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PostType  $postType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Update children cate when delete
            $this->postTypeRepo->updateChildrenNullWhenDetele($id);

            $this->postTypeRepo->delete($id);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.posttypes.index')
            ->with('success', __('Deleted Successfully'));
    }
}
