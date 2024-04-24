<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('national_id_no');
            $table->string('email');
            $table->string('contact_no');
            $table->string('nationality');
            $table->string('religion');
            $table->string('gender');
            $table->string('permanent_address');
            $table->string('district');
            $table->string('province');
            $table->string('current_address');
            $table->string('current_district');
            $table->string('current_province');
            $table->string('guardian_name');
            $table->string('guardian_id_no');
            $table->string('guardian_contact_no');
            $table->string('guardian_occupation');
            // Add other columns here
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
        Schema::dropIfExists('students');
    }
};
