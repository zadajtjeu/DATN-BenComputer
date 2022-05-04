<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_code',
        'total_price',
        'promotion_price',
        'note',
        'payment',
        'user_id',
        'proccess_user_id',
        'voucher_id',
        'shipping_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processUser()
    {
        return $this->belongsTo(User::class, 'proccess_user_id', 'id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot('quantity', 'buying_price', 'rate_status');
    }
}
