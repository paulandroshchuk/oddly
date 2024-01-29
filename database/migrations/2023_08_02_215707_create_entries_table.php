<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->enum('status', [
                \App\Enums\EntryStatus::PROCESSING->value,
                \App\Enums\EntryStatus::DONE->value,
                \App\Enums\EntryStatus::FAILED->value,
            ])->nullable();
            $table->enum('type', [
                \App\Enums\EntryType::WORD_MEANING_IN_PHRASE->value,
            ])->nullable();
            $table->text('meaning')->nullable();
            $table->text('context')->nullable();
            $table->text('input');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
