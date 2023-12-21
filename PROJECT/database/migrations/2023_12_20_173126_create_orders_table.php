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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('payment_status')->default(App\Enums\PaymentStatus::UN_PAID);
            $table->string('order_status')->default(App\Enums\OrderStatus::PENDING);
            $table->string('payment_method')->nullable()->default('NULL');
            $table->unsignedBigInteger('transaction_id')->nullable()->unique();

            $table->float('total_order_amount',8,2)->default('0');
            $table->float('advance_payment',8,2)->default('0');

            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();

            $table->float('discount_amount',8,2)->default('0');
            $table->string('discount_type', 30)->nullable()->default('NULL');
            $table->string('coupon_code', 191)->nullable()->default('NULL');
            $table->float('shipping_cost',8,2)->default('0');

            $table->string('challan_no', 191)->nullable()->default('NULL');
            $table->unsignedBigInteger('courier_id')->nullable();


            // All forign key
            $table->foreign('customer_id')->references('id')->on('users');

            $table->foreign('courier_id')->references('id')->on('courier_services');

            $table->index('customer_id');
            $table->index('payment_status');
            $table->index('order_status');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
