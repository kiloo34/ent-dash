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
        DB::statement('CREATE SCHEMA IF NOT EXISTS rekon');
        
        Schema::create('rekon.rekon_qris_aj', function (Blueprint $table) {
            $table->id();

            $table->string('ref_core', 50)->nullable();
            $table->string('ref_biller', 50)->nullable();

            $table->string('merchant_pan', 30)->nullable();
            $table->string('customer_pan', 30)->nullable();

            $table->string('merchant_name', 150)->nullable();
            $table->string('merchant_location', 100)->nullable();

            $table->timestamp('transaction_date')->nullable();
            $table->decimal('transaction_amount', 18, 2)->nullable();

            $table->string('description', 100)->nullable();
            $table->string('jenis', 10)->nullable();          // ISS / ACQ
            $table->string('status', 20)->nullable();         // FAILED / SUCCEED
            $table->string('qris_switching', 10)->nullable(); // AJ
            $table->string('response_code', 5)->nullable();

            $table->decimal('interchange_fee', 18, 2)->nullable();
            $table->decimal('convenience_fee', 18, 2)->nullable();

            $table->string('institution', 50)->nullable();
            $table->string('merchant_criteria', 50)->nullable();
            $table->string('trx_code', 20)->nullable();

            $table->string('status_rekon', 50)->nullable();

            $table->string('issuer_name', 100)->nullable();
            $table->string('acq_name', 100)->nullable();

            $table->decimal('merchant_mdr', 10, 2)->nullable();

            $table->boolean('is_biller')->default(false);
            $table->boolean('is_echannel')->default(false);
            $table->boolean('is_cbs')->default(false);

            $table->string('porefn', 50)->nullable();
            $table->string('desc_core', 150)->nullable();

            $table->string('rekening_sumber', 30)->nullable();
            $table->string('rekening_nasabah', 30)->nullable();

            $table->string('potecn', 20)->nullable();
            $table->string('pobchn', 20)->nullable();
            $table->string('podtpo', 20)->nullable();
            $table->string('potime', 20)->nullable();
            $table->string('poprog', 20)->nullable();

            $table->string('bic', 20)->nullable();

            $table->bigInteger('external_id')->nullable(); // kolom "ID"
            $table->timestamp('report_datetime')->nullable();

            $table->timestamps();

            // Optional indexes (kalau data sudah jutaan row)
            $table->index('transaction_date');
            $table->index('ref_core');
            $table->index('merchant_pan');
            $table->index('customer_pan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekon.rekon_qris_aj');
    }
};
