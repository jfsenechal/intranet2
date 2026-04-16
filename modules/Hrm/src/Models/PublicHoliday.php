<?php

declare(strict_types=1);

namespace AcMarche\Hrm\Models;

use Illuminate\Database\Eloquent\Model;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-hrm')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'title',
    'holiday_date',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'public_holidays')]
final class PublicHoliday extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    #[\Override]
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'holiday_date' => 'date',
        ];
    }
}
