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
        Schema::create('stasis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('foto')->nullable();
            $table->string('website')->nullable();
            $table->unsignedBigInteger('paroki_id');
            $table->timestamps();

            $table->foreign('paroki_id')->references('id')->on('parokis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stasis');
    }
};
