<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Logistica']);
        Role::create(['name' => 'Publicidad']);
        Role::create(['name' => 'Intendencia']);
        Role::create(['name' => 'Compras']);
        Role::create(['name' => 'Rover']);
        Role::create(['name' => 'Ex-rover']);
        Role::create(['name' => 'DIOS']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::whereIn('name', ['Admin', 'Logistica', 'Publicidad', 'Intendencia', 'Compras', 'Rover', 'Ex-rover', 'DIOS'])->delete();
    }
};
