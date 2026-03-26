<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'mariadb';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::connection('mariadb')->hasTable('profile')) {
            Schema::connection('mariadb')->table('profile', function (Blueprint $table) {
                $table->rename('profiles');
            });
            Schema::connection('mariadb')->table('profiles', function (Blueprint $table) {
                $table->renameColumn('plaque1', 'car_license_plate1');
                $table->renameColumn('plaque2', 'car_license_plate2');
                $table->renameColumn('rue', 'street');
                $table->renameColumn('code_postal', 'postal_code');
                $table->renameColumn('localite', 'city');
                $table->renameColumn('deplacement_date_college', 'college_trip_date');
            });
        }
        // not use anymore
    }
};
