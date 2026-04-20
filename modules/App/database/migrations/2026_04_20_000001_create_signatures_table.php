<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('signatures')) {
            return;
        }

        Schema::create('signatures', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('nom');
            $table->string('prenom');
            $table->string('adresse');
            $table->unsignedSmallInteger('code_postal');
            $table->string('localite');
            $table->string('service')->nullable();
            $table->string('fonction')->nullable();
            $table->string('email');
            $table->string('username')->nullable();
            $table->string('telephone')->nullable();
            $table->string('gsm')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('logotitle')->nullable();
            $table->boolean('ukraine')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signatures');
    }
};
