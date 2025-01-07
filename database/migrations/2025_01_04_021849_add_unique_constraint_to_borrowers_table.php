<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrowers', function (Blueprint $table) {
            // Drop the existing unique constraint if it exists
            $table->dropUnique('borrowers_student_id_unique');

            // Add a unique constraint for student_id where return_date is null
            $table->unique(['student_id', 'return_date'], 'borrowers_student_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrowers', function (Blueprint $table) {
            // Drop the unique constraint
            $table->dropUnique('borrowers_student_id_unique');
        });
    }
}
