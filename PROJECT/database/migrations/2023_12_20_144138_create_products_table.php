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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 120);
            $table->string('code')->unique();
            $table->string('product_type', 20)->default('physical')->comment('physical/digital');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable()->default(0);
            $table->float('unit_price', 8, 2);
            $table->string('unit', 191)->nullable()->default('NULL');
            $table->integer('min_qty')->default('1');

            $table->string('flash_deal')->nullable()->default('NULL');
            $table->string('attributes')->nullable()->default('NULL');

            $table->tinyInteger('refundable')->default('1');
            $table->tinyInteger('free_shipping')->default('0');

            $table->enum('discount_type', ['flat', 'percent'])->nullable();
            $table->float('discount', 8, 2)->default('0.00');
            $table->integer('current_stock')->nullable()->default(0);
            $table->integer('minimum_order_qty')->default('1');
            $table->text('details');

            $table->string('status')->default(App\Enums\Status::ACTIVE)->comment('ACTIVE = published product');
            $table->string('is_featured')->default(App\Enums\Status::NOT_FEATURED)->comment('FEATURED = 1,NOT_FEATURED = 0');
            $table->enum('is_emi', ['0', '1'])->default('0')->comment('1 = emi product');

            $table->string('meta_title', 191)->nullable()->default('NULL');
            $table->string('meta_description', 191)->nullable()->default('NULL');
            $table->string('meta_image', 191)->nullable()->default('NULL');

            $table->enum('added_by',['admin','seller']);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');


            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('uploads')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
            $table->index('unit_price');
            $table->index('category_id');
            $table->index('brand_id');
            $table->fullText('details');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
