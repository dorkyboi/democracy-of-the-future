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
        Schema::create('laws_pdf', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 256);
            $table->text('pdf_tex');
            $table->dateTime('changeDate');
            $table->integer('term');
            $table->integer('doc_number');
            $table->string('attachment_file_title',255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laws_pdf');
    }
};
