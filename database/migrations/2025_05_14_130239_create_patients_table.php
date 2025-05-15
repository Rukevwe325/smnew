<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id('PatientID');
            $table->unsignedBigInteger('FamilyID')->nullable();
            $table->unsignedBigInteger('CompanyID')->nullable();
            $table->string('RegistrationType', 20);
            $table->string('Surname', 50);
            $table->string('FirstName', 50);
            $table->string('MiddleName', 50)->nullable();
            $table->date('DOB');
            $table->integer('Age')->nullable();
            $table->string('Gender', 10);
            $table->string('MaritalStatus', 20);
            $table->string('Nationality', 50)->nullable();
            $table->string('LGA', 50);
            $table->text('ProfilePhoto')->nullable();
            $table->enum('Status', ['Active', 'Inactive', 'Deceased'])->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
