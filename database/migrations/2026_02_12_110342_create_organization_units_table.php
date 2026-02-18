<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app.organization_units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('pluck_code')->unique();

            $table->enum('type', ['directorate', 'sevp', 'division', 'subdivision']);

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('app.organization_units')
                ->nullOnDelete();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('app.organization_units', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        Schema::dropIfExists('app.organization_units');
    }
};
