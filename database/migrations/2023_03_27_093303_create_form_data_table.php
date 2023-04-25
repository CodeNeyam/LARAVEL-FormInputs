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
        // Create the form_data submit that contains all the data
        Schema::create('form_data', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('email');
            $table->integer('number');
            $table->string('select');
            $table->string('img');
            $table->string('file');
            $table->string('url');
            $table->string('checkboxes')->nullable();
            $table->string('radio')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_data');
    }
};
