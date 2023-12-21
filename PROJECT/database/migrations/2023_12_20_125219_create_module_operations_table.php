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
        Schema::create('module_operations', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id');
            $table->string('operation');
            $table->string('route');
            $table->timestamps();
        });


        $sql = "INSERT INTO `module_operations` (`id`, `module_id`, `operation`, `route`, `created_at`, `updated_at`) VALUES (NULL, '1', 'list', 'users.index', NULL, NULL), (NULL, '1', 'store', 'users.store', NULL, NULL), (NULL, '1', 'update', 'users.update', NULL, NULL), (NULL, '1', 'delete', 'users.delete', NULL, NULL)";

        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_operations');
    }
};
