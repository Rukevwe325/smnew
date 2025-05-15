<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('next_of_kin', function (Blueprint $table) {
            $table->id('NextOfKinID');
            $table->unsignedBigInteger('PatientID');
            $table->string('Name', 100);
            $table->string('Relationship', 50);
            $table->string('PhoneNumber', 15);
            $table->text('Address')->nullable();
            $table->timestamps();

            $table->foreign('PatientID')->references('PatientID')->on('patients')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('next_of_kin');
    }
};
