<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id('ContactID');
            $table->unsignedBigInteger('PatientID');
            $table->string('PhoneNumber', 15);
            $table->string('SecondaryPhone', 15)->nullable();
            $table->string('EmailAddress', 100)->nullable();
            $table->text('Address');
            $table->string('City', 50);
            $table->string('State', 50);
            $table->string('PostalCode', 10)->nullable();
            $table->string('Country', 50);
            $table->timestamps();

            $table->foreign('PatientID')->references('PatientID')->on('patients')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
