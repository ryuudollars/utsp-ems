<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('form_id');
            $table->string('statement');
            $table->string('category');
            $table->integer('rate');
            $table->string('form_title');
            $table->string('teacher_fname');
            $table->string('teacher_lname');
            $table->string('sub_desc');
            $table->string('rated_by_fname');
            $table->string('rated_by_lname');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_ratings');
    }
}
