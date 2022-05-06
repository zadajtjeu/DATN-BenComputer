<?php
namespace App\Repositories\Post;

use App\Repositories\RepositoryInterface;

interface PostRepositoryInterface extends RepositoryInterface
{
    public function createThumbnail($post_id, $image_info);

    public function updateThumbnail($post_id, $image_info);
}
