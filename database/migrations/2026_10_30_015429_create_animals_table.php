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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->default('lost'); // 'lost' atau 'adopt'
            $table->string('title', 150);
            $table->string('latin_name', 150)->nullable();
            $table->string('species', 50); // kucing, burung, reptil, mamalia
            $table->string('identification_code', 100)->nullable();
            $table->string('reward_or_fee', 100)->nullable();
            $table->string('district', 150);
            $table->string('district_label', 150)->nullable();
            $table->unsignedTinyInteger('radius_km')->nullable();
            $table->string('contact_phone', 30);
            $table->text('description');
            $table->string('photo_path', 255)->nullable();
            $table->unsignedTinyInteger('map_x')->nullable();
            $table->unsignedTinyInteger('map_y')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
