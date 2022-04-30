<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'value',
        'title',
        'start_date',
        'end_date',
        'quantity',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
