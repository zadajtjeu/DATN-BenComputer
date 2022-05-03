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

    public function getRootPostTypesWith()
    {
        return $this->model->with('children')->whereNull('parent_id')->get();
    }

    public function getChildrenPostTypesID($parent_id)
    {
        if ($parent_id) {
            $list_category_id[] = (int)$parent_id;
            $list_children = $this->model->where('parent_id', $parent_id)->get();

            if ($list_children->isNotEmpty()) {
                foreach ($list_children as $sub_cate) {
                    $list_category_id = array_merge($list_category_id, $this->getChildrenPostTypesID($sub_cate->id));
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
}
