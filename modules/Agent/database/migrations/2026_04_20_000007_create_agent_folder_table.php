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
        if (Schema::connection('maria-agent')->hasTable('agent_dossier')) {
            Schema::connection('maria-agent')->table('agent_dossier', function (Blueprint $table): void {
                $table->rename('agent_folder');
            });
            Schema::connection('maria-agent')->table('agent_folder', function (Blueprint $table): void {
                $table->renameColumn('dossier_id', 'folder_id');
            });
        } elseif (! Schema::connection('maria-agent')->hasTable('agent_folder')) {
            Schema::connection('maria-agent')->create('agent_folder', function (Blueprint $table): void {
                $table->unsignedBigInteger('agent_id');
                $table->unsignedBigInteger('folder_id');

                $table->primary(['agent_id', 'folder_id']);
                $table->foreign('agent_id')->references('id')->on('agents')->cascadeOnDelete();
                $table->foreign('folder_id')->references('id')->on('folders')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::connection('maria-agent')->dropIfExists('agent_folder');
    }
};
