<?php
namespace App\Repositories\PostType;

use App\Repositories\BaseRepository;

class PostTypeRepository extends BaseRepository implements PostTypeRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\PostType::class;
    }
}
