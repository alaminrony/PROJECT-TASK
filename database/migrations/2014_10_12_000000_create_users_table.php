<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->enum('user_type',['admin','seller','customer']);
            $table->string('phone', 25);
            $table->string('email', 80)->nullable()->default('NULL');
            $table->timestamp('email_verified_at')->nullable()->comment('null = not verified');
            $table->string('password');

            $table->string('street_address', 250)->nullable()->default('NULL');
            $table->string('country')->nullable()->default('NULL');
            $table->string('city')->nullable()->default('NULL');
            $table->string('zip')->nullable()->default('NULL');

            $table->string('payment_card_last_four', 191)->nullable()->default('NULL');
            $table->string('payment_card_brand', 191)->nullable()->default('NULL');
            $table->tinyInteger('is_phone_verified')->default('0');
            $table->tinyInteger('is_email_verified')->default('0');
            $table->integer('created_by')->nullable();

            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('uploads')->onDelete('set null');

            // Roles Define in  app\Enums\Role.php 'SUPER_ADMIN','ADMIN','SELLER', 'CUSTOMER'
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['full_name','phone','email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
