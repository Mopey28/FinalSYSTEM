<?php

// database/migrations/xxxx_xx_xx_create_borrower_history_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowerHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('borrower_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('borrower_id');
            $table->date('borrow_date');
            $table->date('return_date')->nullable();
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            $table->foreign('borrower_id')->references('id')->on('borrowers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrower_history');
    }
}

