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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_website');
            $table->string('email');
            $table->string('no_telp');
            $table->text('alamat');
            $table->text('desk_singkat');
            $table->string('judul_header');
            $table->string('gambar_header');
            $table->string('logo');
            $table->string('favicon');
            $table->string('bg_login');
            $table->string('bg_register');
            $table->string('facebook');
            $table->string('instagram');
            $table->string('youtube');
            $table->string('twitter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
