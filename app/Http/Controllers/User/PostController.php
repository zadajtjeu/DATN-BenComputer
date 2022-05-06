<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\PostType\PostTypeRepositoryInterface;

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

    public function index()
    {
        $posts = $this->postRepo
            ->paginate(config('pagination.per_page'));

        return view('users.posts.news', [
            'posts' => $posts,
        ]);
    }

    public function viewPostType($slug)
    {
        $postType = $this->postTypeRepo->getPostTypeWithParent($slug);

        $list_post_type_id = $this->postTypeRepo
            ->getChildrenPostTypesID($postType->id);

        $posts = $this->postRepo
            ->getAllPostsPaginate($list_post_type_id, config('pagination.per_page'));

        return view('users.posts.news', [
            'posts' => $posts,
            'postType' => $postType,
        ]);
    }

    public function viewPost($slug)
    {
        $post = $this->postRepo->findBySlug($slug);

        return view('users.posts.details', [
            'post' => $post,
        ]);
    }
}
