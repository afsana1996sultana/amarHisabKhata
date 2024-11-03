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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('project_id');
            $table->string('expense_head_id');
            $table->string('expense_subhead_id');
            $table->string('amount_head');
            $table->string('quantity');
            $table->double('amount')->nullable();
            $table->text('voucher_image')->nullable();
            $table->text('purpose');
            $table->tinyInteger('is_approve')->default(0)->comment('0=>Not Approve, 1=>Approve');
            $table->unsignedTinyInteger('status')->default(1)->comment('1=>Active, 0=>Inactive');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
