<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('module_names', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $sql = "INSERT INTO `module_names` (`id`, `name`, `created_at`, `updated_at`) VALUES (NULL, 'user', NULL, NULL)";

        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_names');
    }
};
