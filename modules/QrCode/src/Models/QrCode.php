<?php

declare(strict_types=1);

namespace AcMarche\QrCode\Models;

use AcMarche\QrCode\Database\Factories\QrCodeFactory;
use AcMarche\QrCode\Enums\QrCodeTypeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UseFactory(QrCodeFactory::class)]
#[Fillable([
    'user_id',
    'username',
    'name',
    'type',
    'color',
    'background_color',
    'pixels',
    'format',
    'style',
    'margin',
    'label_text',
    'label_color',
    'label_size',
    'label_alignment',
    'file_path',
    'message',
    'phone_number',
    'email',
    'subject',
    'iban',
    'amount',
    'recipient',
    'latitude',
    'longitude',
    'ssid',
    'password',
    'encryption',
    'hidden',
])]
final class QrCode extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'qr_codes';

    /**
     * @return BelongsTo<User, QrCode>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function casts(): array
    {
        return [
            'type' => QrCodeTypeEnum::class,
            'pixels' => 'integer',
            'margin' => 'integer',
            'label_size' => 'integer',
            'hidden' => 'boolean',
        ];
    }
}
