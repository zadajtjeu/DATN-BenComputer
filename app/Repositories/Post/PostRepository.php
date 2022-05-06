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
}
