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
        Schema::create('selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('step', 50);
            $table->dateTime('selection_datetime')
                ->nullable();
            $table->string('place')
                ->nullable();
            $table->string('station')
                ->nullable();
            $table->boolean('carfare')
                ->default(false);
            $table->integer('carfare_price')
                ->nullable();
            $table->string('clothing')
                ->nullable();
            $table->text('items')
                ->nullable();
            $table->text('free_memo')
                ->nullable();
            $table->string('result_period', 50)
                ->nullable();
            $table->string('status', 20)
                ->default('noFinish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selections');
    }
};
