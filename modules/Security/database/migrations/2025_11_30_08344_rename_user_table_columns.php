<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'maria-security';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $schema = Schema::connection('maria-security');
        $hasColumn = fn (string $column): bool => $schema->hasColumn('users', $column);

        $schema->table('users', function (Blueprint $table) use ($hasColumn) {
            if ($hasColumn('departement')) {
                $table->removeColumn('departement');
            }
            if (! $hasColumn('departments')) {
                $table->json('departments')->nullable(false);
            }
             if ($hasColumn('nom')) {
                $table->renameColumn('nom', 'last_name');
                $table->string('last_name')->nullable(false)->change();
            } elseif ($hasColumn('last_name')) {
                $table->string('last_name')->nullable(false)->change();
            } else {
                $table->string('last_name')->nullable(false);
            }
            if ($hasColumn('prenom')) {
                $table->renameColumn('prenom', 'first_name');
                $table->string('first_name')->nullable(false)->change();
            } elseif ($hasColumn('first_name')) {
                $table->string('first_name')->nullable(false)->change();
            } else {
                $table->string('first_name')->nullable(false);
            }
        });
return;
        // Modify column properties in users table only if old columns exist (legacy migration)
        $schema->table('users', function (Blueprint $table) use ($hasColumn) {


            if (! $hasColumn('username')) {
                $table->string('username')->unique();
            }

            if ($hasColumn('news_attachment')) {
                $table->string('news_attachment')->nullable(false)->default('0')->change();
            }

            if (! $hasColumn('phone')) {
                $table->string('phone', 50)->nullable();
            }

            if (! $hasColumn('mobile')) {
                $table->string('mobile', 50)->nullable();
            }

            if (! $hasColumn('extension')) {
                $table->string('extension', 50)->nullable();
            }

            if (! $hasColumn('color_primary')) {
                $table->string('color_primary', 50)->nullable();
            }

            if (! $hasColumn('color_secondary')) {
                $table->string('color_secondary', 50)->nullable();
            }

            if ($hasColumn('uuid')) {
                $table->uuid('uuid')->nullable()->change();
            } else {
                $table->uuid()->nullable();
            }

            if (! $hasColumn('is_administrator')) {
                $table->boolean('is_administrator')->default(false);
            }

            if (! $hasColumn('app_authentication_secret')) {
                $table->text('app_authentication_secret')->nullable();
            }

            if (! $hasColumn('app_authentication_recovery_codes')) {
                $table->text('app_authentication_recovery_codes')->nullable();
            }

            if (! $hasColumn('name')) {
                $table->string('name');
            }

            if (! $hasColumn('email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable();
            }

            if (! $hasColumn('remember_token')) {
                $table->rememberToken();
            }

            if (! $hasColumn('created_at')) {
                $table->timestamps();
            }

            if (! $hasColumn('mandatory')) {
                $table->tinyInteger('mandatory')->default(0);
            }
        });

    }
};
