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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->unsignedBigInteger('image')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('status')->default(STATUS_ACTIVE);
            $table->bigInteger('created_by')->nullable();
            $table->tinyInteger('role')->default(USER_ROLE_ADMIN);
            $table->tinyInteger('email_verification_status')->default(0);
            $table->tinyInteger('phone_verification_status')->default(0);
            $table->Integer('otp')->nullable();
            $table->dateTime('otp_expiry')->nullable();
            $table->tinyInteger('google_auth_status')->default(0);
            $table->text('google2fa_secret')->nullable();
            $table->tinyInteger('passport_verification_status')->default(0);
            $table->tinyInteger('driving_license_verification_status')->default(0);
            $table->tinyInteger('national_id_verification_status')->default(0);
            $table->tinyInteger('total_document_verification_count')->default(0);
            $table->string('ref_code')->unique()->nullable();
            $table->string('ref_level')->default(1);
            $table->string('tenant_id')->nullable();
            $table->string('app_timezone')->nullable();
            $table->string('username')->nullable();
            $table->string('announcement_seen')->default('0');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
