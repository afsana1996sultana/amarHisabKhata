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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('lead_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('address')->nullable();
            $table->string('description')->nullable();
            $table->string('project_name');
            $table->integer('project_value');
            $table->integer('advance')->nullable();
            $table->integer('paid')->nullable();
            $table->integer('due')->nullable();
            $table->string('project_duration')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=>Started, 1=>Completed');
            $table->tinyInteger('is_approve')->default(0)->comment('0=>Not Approve, 1=>Approve');
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
