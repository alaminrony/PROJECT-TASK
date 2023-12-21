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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->enum('is_featured',['0','1'])->default(0)->comment('1 = featured category, 0 = non featured');

            $table->string('meta_title');
            $table->string('meta_description');

            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('uploads')->onDelete('set null');

            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('status')->default(App\Enums\Status::ACTIVE)->comment('ACTIVE = 1');

            $table->softDeletes();
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
