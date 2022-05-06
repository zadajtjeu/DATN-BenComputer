<?php
namespace App\Repositories\Post;

use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Post::class;
    }

    public function createThumbnail($post_id, $image_info)
    {
        $thumbnail = $this->findOrFail($post_id);

        $thumbnail->thumbnail()->create([
            'name' => $image_info['name'],
            'url' => $image_info['url'],
        ]);
    }

    public function updateThumbnail($post_id, $image_info)
    {
        $thumbnail = $this->findOrFail($post_id);

        $thumbnail->thumbnail()->update([
            'name' => $image_info['name'],
            'url' => $image_info['url'],
        ]);
    }

    public function getAllPostsPaginate($list_post_type_id, $paginate)
    {
        return $this->model
            ->whereIn('post_type_id', $list_post_type_id)
            ->paginate($paginate);
    }

    public function findBySlug($slug)
    {
        return $this->model
            ->where('slug', $slug)
            ->with('postType.parent')
            ->firstOrFail();
    }
}
