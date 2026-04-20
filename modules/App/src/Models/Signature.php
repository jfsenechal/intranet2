<?php

declare(strict_types=1);

namespace AcMarche\App\Models;

use App\Enums\SignatureEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table(name: 'signatures')]
#[Fillable([
    'user_id',
    'nom',
    'prenom',
    'adresse',
    'code_postal',
    'localite',
    'service',
    'fonction',
    'email',
    'username',
    'telephone',
    'gsm',
    'fax',
    'website',
    'logo',
    'logotitle',
    'ukraine',
])]
final class Signature extends Model
{
    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'logo' => SignatureEnum::class,
            'ukraine' => 'boolean',
            'code_postal' => 'integer',
        ];
    }
}
