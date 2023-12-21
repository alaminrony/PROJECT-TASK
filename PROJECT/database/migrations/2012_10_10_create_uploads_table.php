<?php

use App\Enums\FileType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('original')->nullable();
            $table->string('name')->nullable();
            $table->enum('type', FileType::Type)->default(FileType::Type[0]);
            $table->json('paths')->nullable();
            $table->timestamps();

            $table->index('original','type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
