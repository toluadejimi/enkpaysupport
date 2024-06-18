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
        Schema::create('frontend_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('title')->nullable();
            $table->string('slug');
            $table->string('has_image')->nullable();
            $table->longText('description')->nullable();
            $table->integer('image')->nullable();
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->string('tenant_id')->nullable();
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
        Schema::dropIfExists('frontend_sections');
    }
};
