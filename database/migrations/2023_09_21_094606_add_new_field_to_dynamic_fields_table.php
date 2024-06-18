<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dynamic_fields', function (Blueprint $table) {
            $table->string('tenant_id')->nullable();
            $table->string('name')->nullable();
            $table->string('width')->nullable();
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
        Schema::table('dynamic_fields', function (Blueprint $table) {
            $table->dropColumn(['tenant_id']);
        });
    }
};
