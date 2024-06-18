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
        Schema::create('chat_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('chat_title')->nullable();
            $table->string('message_title')->nullable();
            $table->string('message_discription')->nullable();
            $table->string('tenant_id')->nullable();
            $table->integer('status')->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('chat_configurations');
    }
};
