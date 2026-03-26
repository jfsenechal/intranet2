<?php

declare(strict_types=1);

namespace AcMarche\Pst\Console\Commands;

use AcMarche\Pst\Enums\RoleEnum;
use AcMarche\Security\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Command\Command as SfCommand;

final class FixCommand extends Command
{
    protected $signature = 'pst:migration';

    protected $description = 'Migrate action_user and action_mandatory tables from user_id to username';

    public function handle(): int
    {
        $adminRole = Role::factory()->create([
            'name' => RoleEnum::ADMIN->value,
        ]);
        $adminRole = Role::factory()->create([
            'name' => RoleEnum::MANDATAIRE->value,
        ]);
        $adminRole = Role::factory()->create([
            'name' => RoleEnum::PST->value,
        ]);

        $tables = ['action_user', 'action_mandatory'];

        foreach ($tables as $table) {
           // $this->migrateTable($table);
        }

        $this->info('Migration completed successfully.');

        return SfCommand::SUCCESS;
    }

    private function migrateTable(string $table): void
    {
        if (! Schema::hasColumn($table, 'user_id')) {
            $this->warn("Table {$table} does not have user_id column, skipping.");

            return;
        }

        if (Schema::hasColumn($table, 'username')) {
            $this->warn("Table {$table} already has username column, skipping.");

            return;
        }

        $this->info("Migrating {$table}...");

        // Add username column
        Schema::table($table, function ($blueprint) {
            $blueprint->string('username')->nullable()->after('action_id');
        });

        // Populate username from users table
        DB::table($table)
            ->join('users', "{$table}.user_id", '=', 'users.id')
            ->update(["{$table}.username" => DB::raw('users.username')]);

        // Remove orphaned rows where user no longer exists
        $orphaned = DB::table($table)->whereNull('username')->count();
        if ($orphaned > 0) {
            $this->warn("Removing {$orphaned} orphaned rows from {$table} (user no longer exists).");
            DB::table($table)->whereNull('username')->delete();
        }

        // Drop old FK, unique index, and user_id column
        Schema::table($table, function ($blueprint) use ($table) {
            $blueprint->dropForeign(["{$table}_user_id_foreign"]);
            $blueprint->dropUnique(["{$table}_action_id_user_id_unique"]);
            $blueprint->dropColumn('user_id');
        });

        // Make username non-nullable and add new unique constraint
        Schema::table($table, function ($blueprint) {
            $blueprint->string('username')->nullable(false)->change();
            $blueprint->unique(['action_id', 'username']);
        });

        $count = DB::table($table)->count();
        $this->info("Migrated {$table}: {$count} rows.");
    }
}
