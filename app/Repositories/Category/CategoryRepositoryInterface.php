<?php
namespace App\Repositories\Category;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getRootCategoriesWith();

    public function getChildrenCategoriesID($parent_id);

    public function updateChildrenNullWhenDetele($parent_id);
}
