<?php
namespace App\Repositories\Image;

use App\Repositories\BaseRepository;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Image::class;
    }
}
