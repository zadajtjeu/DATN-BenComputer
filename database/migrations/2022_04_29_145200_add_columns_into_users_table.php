<?php

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone');
            $table->string('address')->nullable();
            $table->tinyInteger('role')->unsigned()->default(UserRole::USER);
            $table->boolean('status')->default(UserStatus::ACTIVE);
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
        if (Schema::hasColumn('phone', 'address', 'role', 'status')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['phone', 'address', 'role', 'status']);
            });
        }
    }
}
