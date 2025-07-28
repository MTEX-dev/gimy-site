<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('site_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('name');
            $table->string('path');
            $table->string('mime_type')->nullable();
            $table->bigInteger('size')->nullable();
            $table->timestamps();

            $table->unique(['site_id', 'path']);
        });


        Schema::create('page_asset', function (Blueprint $table) {
            $table->foreignUuid('page_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignUuid('asset_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();

            $table->primary(['page_id', 'asset_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
        Schema::dropIfExists('page_asset');
    }
};