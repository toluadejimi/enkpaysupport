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
        Schema::create('varities', function (Blueprint $table) {
            $table->id();
            $table->string('schedule_title')->nullable();
            $table->text('schedule_desc')->nullable();
            $table->string('ticket_tracking_no_pre_fixed')->nullable();
            $table->boolean('agent_fake_name')->default(false);
            $table->integer('created_by')->default(true);
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
        Schema::dropIfExists('varities');
    }
};
