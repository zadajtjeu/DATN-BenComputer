<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\VoucherCondition;

class AddAttributeVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->tinyInteger('condition')
                ->default(VoucherCondition::PERCENT)
                ->after('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('condition')) {
            Schema::table('vouchers', function (Blueprint $table) {
                $table->dropColumn('condition');
            });
        }
    }
}
