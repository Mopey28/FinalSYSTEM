<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->nullable();
            $table->text('description')->nullable();
            $table->string('brand_model')->nullable();
            $table->string('engine_serial_no')->unique()->nullable();
            $table->string('inventory_tag_no')->unique()->nullable();
            $table->string('purchased_by');
            $table->text('remarks')->nullable();
            $table->string('status')->nullable()->default('available'); // Add status field with default value
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
