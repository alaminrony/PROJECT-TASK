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
        Schema::create('role_to_accesses', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id');
            $table->integer('module_id');
            $table->integer('module_operation_id');
            $table->timestamps();
        });

        $sql = "INSERT INTO `role_to_accesses` (`id`, `role_id`, `module_id`, `module_operation_id`, `created_at`, `updated_at`) VALUES (NULL, '1', '1', '1', NULL, NULL), (NULL, '1', '1', '2', NULL, NULL)";

        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_to_accesses');
    }
};
