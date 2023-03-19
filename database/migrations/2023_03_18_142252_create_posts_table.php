<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index()->unique();
            $table->string('title', 128)->unique();
            $table->string('author', 128);
            $table->text('thumbnail');
            $table->string('intro', 128);
            $table->text('content');
            $table->timestampTz('published_at')->nullable()->index();
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
