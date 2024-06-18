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
        Schema::create('ticket_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ticket_id');
            $table->integer('rating')->default(0);
            $table->text('comment')->nullable();
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('category_id');
            $table->integer('status')->default(1)->comment('Inactive = 0, Active = 1');
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
        Schema::dropIfExists('ticket_ratings');
    }
};
