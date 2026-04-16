<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Connection('maria-hrm')]
#[Fillable([
    'uuid',
    'regulation_agreement',
    'it_agreement',
    'street',
    'postal_code',
    'locality',
    'location_type',
    'day_type',
    'fixed_day',
    'variable_day_reason',
    'manager_validated',
    'manager_validated_at',
    'manager_validation_notes',
    'date_college',
    'hr_notes',
    'employee_notes',
    'manager_validator_name',
    'hr_validator_name',
    'user_add',
    'updated_by',
])]
#[Table(name: 'teleworks')]
final class Telework extends Model
{
    use HasFactory;
    protected static function booted(): void
    {
        self::creating(function (Telework $telework): void {
            if (empty($telework->uuid)) {
                $telework->uuid = (string) Str::uuid();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'regulation_agreement' => 'boolean',
            'it_agreement' => 'boolean',
            'manager_validated' => 'boolean',
            'manager_validated_at' => 'date',
            'date_college' => 'date',
        ];
    }
}
