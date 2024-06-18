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
        Schema::create('envatos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('enable_purchase_code')->default(0);
            $table->tinyInteger('envato_expired_on')->default(0);
            $table->string('support_policy_url')->nullable();
            $table->string('personal_api_token')->nullable();
            $table->string('tenant_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('envatos');
    }
};
