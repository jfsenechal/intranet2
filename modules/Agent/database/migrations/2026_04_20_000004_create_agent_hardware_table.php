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
        if (Schema::connection('maria-agent')->hasTable('agent_materiel')) {
            Schema::connection('maria-agent')->table('agent_materiel', function (Blueprint $table): void {
                $table->rename('agent_hardware');
            });
            Schema::connection('maria-agent')->table('agent_hardware', function (Blueprint $table): void {
                $table->renameColumn('pc_existant', 'existing_pc');
                $table->renameColumn('pc_nouveau', 'new_pc');
                $table->renameColumn('autre', 'other');
                if (! Schema::connection('maria-agent')->hasColumn('agent_hardware', 'created_at')) {
                    $table->timestamps();
                }
            });
        } elseif (! Schema::connection('maria-agent')->hasTable('agent_hardware')) {
            Schema::connection('maria-agent')->create('agent_hardware', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('agent_id')->nullable();
                $table->string('existing_pc')->nullable();
                $table->string('new_pc')->nullable();
                $table->longText('other')->nullable();
                $table->boolean('vpn')->nullable();
                $table->timestamps();

                $table->foreign('agent_id')->references('id')->on('agents')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::connection('maria-agent')->dropIfExists('agent_hardware');
    }
};
