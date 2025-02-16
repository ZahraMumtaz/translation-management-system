<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->text('key');
            $table->string('context');
            $table->string('locale');
            $table->text('content');
            $table->timestamps();

            $table->fullText('key');
            $table->fullText('content');
            $table->index('context');
            $table->index('locale');
            $table->index(['context', 'locale']);

            $table->unique(['key', 'context', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
