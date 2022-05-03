<?php
namespace App\Repositories\PostType;

use App\Repositories\RepositoryInterface;

interface PostTypeRepositoryInterface extends RepositoryInterface
{
    public function getRootPostTypesWith();

    public function getChildrenPostTypesID($parent_id);

    public function updateChildrenNullWhenDetele($parent_id);
}
