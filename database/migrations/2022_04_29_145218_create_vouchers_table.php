<?php

use App\Enums\VocherStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->double('value')->default(0);
            $table->string('title');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->integer('quantity');
            $table->integer('used')->default(0);
            $table->tinyInteger('status')
                ->unsigned()
                ->default(VocherStatus::AVAILABLE);
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
        Schema::dropIfExists('vouchers');
    }
}
