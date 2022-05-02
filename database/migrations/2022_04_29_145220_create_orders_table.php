<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->double('total_price');
            $table->double('promotion_price')->nullable();
            $table->tinyInteger('status')
                ->unsigned()
                ->default(OrderStatus::NEW_ORDER);
            $table->string('note')->nullable();
            $table->string('payment');
            $table->tinyInteger('payment_status')
                ->unsigned()
                ->default(PaymentStatus::PROCCESSING);
            $table->foreignId('user_id')->constrained();

            $table->unsignedBigInteger('proccess_user_id')->nullable();
            $table->foreign('proccess_user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->foreignId('voucher_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('shipping_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
