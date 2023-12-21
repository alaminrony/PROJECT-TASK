<?php

use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status')->default(App\Enums\Status::ACTIVE);
            $table->timestamps();
        });


        $rolesData = [
            ['id' => 1, 'name' => 'SUPER_ADMIN', 'status' => 1],
            ['id' => 2, 'name' => 'ADMIN', 'status' => 1],
            ['id' => 3, 'name' => 'SELLER', 'status' => 1],
            ['id' => 4, 'name' => 'CUSTOMER', 'status' => 1],
        ];

        Role::insert($rolesData);


    }









    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
