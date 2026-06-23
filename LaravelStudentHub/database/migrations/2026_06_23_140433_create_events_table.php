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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('short_description', 500)->nullable();
            $table->longText('html_content');

            $table->string('image_path')->nullable();

            $table->dateTime('event_date');
            $table->dateTime('publish_from')->nullable();
            $table->dateTime('publish_until')->nullable();

            $table->boolean('requires_registration')->default(false);
            $table->unsignedInteger('max_participants')->nullable();

            $table->enum('recurrence', ['none', 'weekly', 'monthly', 'yearly'])->default('none');

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
