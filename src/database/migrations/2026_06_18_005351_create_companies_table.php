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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('level')
                ->default(3);
            $table->string('address')
                ->nullable();
            $table->string('industry', 50)
                ->nullable();
            $table->integer('salary')
                ->nullable();
            $table->time('start_time')
                ->nullable();
            $table->time('end_time')
                ->nullable();
            $table->integer('break_time')
                ->nullable();
            $table->integer('training_period')
                ->nullable();
            $table->string('ses_level', 16)
                ->default('不明');
            $table->text('benefits_memo')
                ->nullable();
            $table->text('free_memo')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
