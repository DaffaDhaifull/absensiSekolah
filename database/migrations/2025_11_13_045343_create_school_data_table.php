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
        Schema::create('school_data', function (Blueprint $table) {
            $table->id();
            $table->string('namaSekolah');
            $table->string('namaSingkat');
            $table->string('NPSN');
            $table->string('jenjang');
            $table->enum('status',['Swasta','Negeri']);
            $table->string('telepon');
            $table->string('email');
            $table->string('kepalaSekolah');
            $table->string('logo');
            $table->text('alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_data');
    }
};
