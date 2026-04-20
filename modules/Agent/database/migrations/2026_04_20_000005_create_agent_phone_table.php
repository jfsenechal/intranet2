<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'maria-agent';

    public function up(): void
    {
        if (Schema::connection('maria-agent')->hasTable('agent_telephonie')) {
            Schema::connection('maria-agent')->table('agent_telephonie', function (Blueprint $table): void {
                $table->rename('agent_phone');
            });
            Schema::connection('maria-agent')->table('agent_phone', function (Blueprint $table): void {
                $table->renameColumn('numero_existant', 'existing_number');
                $table->renameColumn('numero_nouveau', 'new_number');
                $table->renameColumn('numero_exterieur', 'external_number');
                $table->renameColumn('numero_mobile', 'mobile_number');
                if (! Schema::connection('maria-agent')->hasColumn('agent_phone', 'created_at')) {
                    $table->timestamps();
                }
            });
        } elseif (! Schema::connection('maria-agent')->hasTable('agent_phone')) {
            Schema::connection('maria-agent')->create('agent_phone', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('agent_id')->nullable();
                $table->string('existing_number')->nullable();
                $table->boolean('new_number')->nullable();
                $table->boolean('external_number')->nullable();
                $table->string('mobile_number')->nullable();
                $table->timestamps();

                $table->foreign('agent_id')->references('id')->on('agents')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::connection('maria-agent')->dropIfExists('agent_phone');
    }
};
