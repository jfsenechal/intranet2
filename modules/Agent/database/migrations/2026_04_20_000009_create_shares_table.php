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
        if (Schema::connection('maria-agent')->hasTable('share')) {
            Schema::connection('maria-agent')->table('share', function (Blueprint $table): void {
                $table->rename('shares');
            });
            Schema::connection('maria-agent')->table('shares', function (Blueprint $table): void {
                $table->renameColumn('shareBy', 'shared_by');
                $table->renameColumn('shareFor', 'shared_for');
                if (! Schema::connection('maria-agent')->hasColumn('shares', 'created_at')) {
                    $table->timestamps();
                }
            });
        } elseif (! Schema::connection('maria-agent')->hasTable('shares')) {
            Schema::connection('maria-agent')->create('shares', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('agent_id');
                $table->string('shared_by', 100);
                $table->string('shared_for', 100);
                $table->timestamps();

                $table->foreign('agent_id')->references('id')->on('agents')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::connection('maria-agent')->dropIfExists('shares');
    }
};
