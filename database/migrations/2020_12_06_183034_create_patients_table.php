<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->bigInteger('doctor_id')->unsigned()->index();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            //$table->string('doctor_name')->unsigned();
            $table->string('doctor_name')->references('name')->on('doctors');
            $table->string('name');
            $table->string('age');
            $table->string('gender');
            $table->bigInteger('contact_no');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('medical_history');
            $table->timestamps();

        });

        // Schema::table('patients', function($table) {
        //     $table->foreign('doctor_name')->references('name')->on('doctors');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
