<?php
namespace App\Repositories\Rating;

use App\Repositories\RepositoryInterface;

interface RatingRepositoryInterface extends RepositoryInterface
{
    public function updateOrCreate(
        $attributes1 = [],
        $attributes2 = []
    );

    public function avgRate($product_id);
}
