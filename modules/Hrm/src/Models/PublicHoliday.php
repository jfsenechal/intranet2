<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use Illuminate\Database\Eloquent\Attributes\Connection;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;

#[Connection('maria-hrm')]
#[Fillable([
    'title',
    'holiday_date',
])]
#[Table(name: 'public_holidays')]
final class PublicHoliday extends Model
{
    use HasFactory;

    #[Override]
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'holiday_date' => 'date',
        ];
    }
}
