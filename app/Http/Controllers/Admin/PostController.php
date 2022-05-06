<?php

namespace App\Http\Controllers\Admin;

use DB;
use Storage;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\PostType\PostTypeRepositoryInterface;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected $postRepo;
    protected $postTypeRepo;

    public function __construct(
        PostRepositoryInterface $postRepo,
        PostTypeRepositoryInterface $postTypeRepo
    ) {
        $this->postRepo = $postRepo;
        $this->postTypeRepo = $postTypeRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postRepo
            ->paginate(config('pagination.per_page'));

        return view('admins.posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $postTypes = $this->postTypeRepo->getRootPostTypesWith();

        return view('admins.posts.create', [
            'postTypes' => $postTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        if (!Storage::exists('posts')) {
            Storage::makeDirectory('posts');
        }

        try {
            DB::beginTransaction();

            $post = $this->postRepo->create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'description'=> $request->description,
                'post_type_id'=> $request->post_type_id,
                'user_id' => $request->user_id,
            ]);

            if ($request->has('image')) {
                $file = $request->image;
                $new_name = time() . "-post-"
                    . Str::slug($request->title) . '.'
                    . $file->getClientOriginalExtension();

                $file->storeAs('posts', $new_name);

                $this->postRepo->createThumbnail($post->id, [
                    'name' => $new_name,
                    'url' => Storage::url('posts/' . $new_name),
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.posts.index')->with('success', __('Created Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->postRepo->findOrFail($id);

        $postTypes = $this->postTypeRepo->getRootPostTypesWith();

        return view('admins.posts.edit', [
            'post' => $post,
            'postTypes' => $postTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        $post = $this->postRepo->findOrFail($id);

        if (!Storage::exists('posts')) {
            Storage::makeDirectory('posts');
        }

        try {
            DB::beginTransaction();

            if ($request->has('image')) {
                $file = $request->image;
                $new_name = time() . '-post-' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();

                $file->storeAs('posts', $new_name);

                $this->postRepo->updateThumbnail($post->id, [
                    'name' => $new_name,
                    'url' => Storage::url('posts/' . $new_name),
                ]);
            }

            $this->postRepo->update($post->id, [
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'description'=> $request->description,
                'post_type_id'=> $request->post_type_id,
                'user_id' => $request->user_id,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }


        return redirect()->route('admin.posts.index')->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $post = $this->postRepo->delete($id);
        } catch (Exception $e) {
            return redirect()->back()->with('error', __('An error has occurred please try again later'));
        }

        return redirect()->route('admin.posts.index')
            ->with('success', __('Deleted Successfully'));
    }
}
