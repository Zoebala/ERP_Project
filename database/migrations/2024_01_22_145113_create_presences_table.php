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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->boolean("BtnArrivee")->default(0);
            $table->datetime("arrivee")->nullable();
            $table->boolean("BtnDepart")->default(0);
            $table->datetime("depart")->nullable();
            $table->unsignedBigInteger("employe_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
