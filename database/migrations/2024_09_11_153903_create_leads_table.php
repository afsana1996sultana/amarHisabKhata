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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_name');
            $table->string('lead_phone');
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('priority');
            $table->text('description')->nullable();
            $table->tinyInteger('is_customer')->default(0)->comment('0=not customer, 1=customer');
            $table->tinyInteger('status')->default(0)->comment('0=inactive, 1=active');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
