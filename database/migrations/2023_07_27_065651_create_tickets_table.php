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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_no');
            $table->string('ticket_title');
            $table->longText('ticket_description');
            $table->string('envato_licence')->nullable();
            $table->integer('ticket_type')->default(1)->comment('External = 1, Internal = 2');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('last_reply_id')->nullable();
            $table->unsignedBigInteger('last_reply_by')->nullable();
            $table->timestamp('last_reply_time')->nullable();
            $table->integer('status')->default(0)->comment('Open = 0, In-Progress = 1,Canceled = 2,On-Hold = 3,Closed = 4,Resolved = 5,Re-Open = 6');
            $table->integer('priority')->default(1)->comment('Low = 1, Medium = 2,High = 3,Critical = 4');
            $table->text('file_id')->nullable();
            $table->string('tenant_id');
            $table->integer('label')->default(1);
            $table->softDeletes();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
