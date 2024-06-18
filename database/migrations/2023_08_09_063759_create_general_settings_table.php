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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->nullable();
            $table->string('app_email')->nullable();
            $table->string('app_contact_number')->nullable();
            $table->string('app_location')->nullable();
            $table->string('app_copyright')->nullable();
            $table->string('app_developed')->nullable();
            $table->string('app_timezone')->nullable();
            $table->string('app_debug')->nullable();
            $table->string('app_date_format')->nullable();
            $table->string('app_time_format')->nullable();
            $table->string('app_preloader')->nullable();
            $table->string('app_logo')->nullable();
            $table->string('app_fav_icon')->nullable();
            $table->string('app_footer_logo')->nullable();
            $table->string('login_left_image')->nullable();
            $table->string('tenant_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('general_settings');
    }
};
