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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coin_id');
            $table->string('title');
            $table->string('slug');
            $table->decimal('base_price', 16, 8);
            $table->decimal('current_price', 16, 8);
            $table->string('description')->nullable();
            $table->tinyInteger('duration_type')->default(DURATION_TYPE_DAY);
            $table->tinyInteger('return_type')->default(RETURN_TYPE_RANDOM);
            $table->decimal('return_amount_per_day', 16,8)->default(0);
            $table->decimal('min_return_amount_per_day', 16,8)->default(0);
            $table->decimal('max_return_amount_per_day', 16,8)->default(0);
            $table->integer('duration');
            $table->tinyInteger('status')->default(STATUS_ACTIVE);
            $table->softDeletes();
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
        Schema::dropIfExists('plans');
    }
};
