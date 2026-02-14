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
        Schema::table('app.users', function (Blueprint $table) {
            $table->foreignId('position_id')
                ->nullable()
                ->constrained('app.positions')
                ->nullOnDelete();

            $table->foreignId('organization_unit_id')
                ->nullable()
                ->constrained('app.organization_units')
                ->nullOnDelete();

            $table->foreignId('direct_superior_id')
                ->nullable()
                ->constrained('app.users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app.users', function (Blueprint $table) {
            if (Schema::hasColumn('app.users', 'organization_unit_id')) {
                $table->dropForeign(['organization_unit_id']);
                $table->dropColumn('organization_unit_id');
            }
    
            if (Schema::hasColumn('app.users', 'position_id')) {
                $table->dropForeign(['position_id']);
                $table->dropColumn('position_id');
            }
        });
    
    }
};
