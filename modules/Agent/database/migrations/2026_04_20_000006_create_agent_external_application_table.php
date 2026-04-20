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
        if (Schema::connection('maria-agent')->hasTable('agent_applicationexterne')) {
            Schema::connection('maria-agent')->table('agent_applicationexterne', function (Blueprint $table): void {
                $table->rename('agent_external_application');
            });
            Schema::connection('maria-agent')->table('agent_external_application', function (Blueprint $table): void {
                $table->renameColumn('applicationexterne_id', 'external_application_id');
            });
        } elseif (! Schema::connection('maria-agent')->hasTable('agent_external_application')) {
            Schema::connection('maria-agent')->create('agent_external_application', function (Blueprint $table): void {
                $table->unsignedBigInteger('agent_id');
                $table->unsignedBigInteger('external_application_id');

                $table->primary(['agent_id', 'external_application_id']);
                $table->foreign('agent_id')->references('id')->on('agents')->cascadeOnDelete();
                $table->foreign('external_application_id')->references('id')->on('external_applications')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::connection('maria-agent')->dropIfExists('agent_external_application');
    }
};
