<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Models;

use Database\Factories\SenderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Sender extends Model
{
    /** @use HasFactory<SenderFactory> */
    use HasFactory;

    protected $connection = 'maria-mailinglist';

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
