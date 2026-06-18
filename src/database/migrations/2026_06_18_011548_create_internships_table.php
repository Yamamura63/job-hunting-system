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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->dateTime('start_datetime')
                ->nullable();
            $table->dateTime('end_datetime')
                ->nullable();
            $table->string('place');
            $table->string('station')
                ->nullable();
            $table->text('content')
                ->nullable();
            $table->boolean('carfare')
                ->default(false);
            $table->boolean('lunch')
                ->default(false);
            $table->boolean('applied')
                ->default(false);
            $table->boolean('joined')
                ->default(false);
            $table->text('joined_memo')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
