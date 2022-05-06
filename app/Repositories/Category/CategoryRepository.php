<?php
namespace App\Repositories\Category;

use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Category::class;
    }

    public function getRootCategoriesWith()
    {
        return $this->model->with('children')->whereNull('parent_id')->get();
    }

    public function getChildrenCategoriesID($parent_id)
    {
        if ($parent_id) {
            $list_category_id[] = (int)$parent_id;
            $list_children = $this->model->where('parent_id', $parent_id)->get();

            if ($list_children->isNotEmpty()) {
                foreach ($list_children as $sub_cate) {
                    $list_category_id = array_merge($list_category_id, $this->getChildrenCategoriesID($sub_cate->id));
                }
            }

            return $list_category_id;
        }

        return [];
    }

    public function updateChildrenNullWhenDetele($parent_id)
    {
        if ($parent_id) {
            $this->model->where('parent_id', $parent_id)
                ->update(['parent_id' => null]);

            return true;
        }

        return false;
    }

    public function findBySlug($slug)
    {
        return $this->model->with('children')
            ->where('slug', $slug)->firstOrFail();
    }
}
