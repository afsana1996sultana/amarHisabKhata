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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('project_id');
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('project_name')->nullable();
            $table->string('project_value')->nullable();
            $table->integer('paid')->nullable();
            $table->integer('due')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('next_due')->nullable();
            $table->string('payment_type')->nullable();
            $table->date('date')->nullable();
            $table->text('payment_image')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_approve')->default(0)->comment('0=>Not Approve, 1=>Approve');
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
