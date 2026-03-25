<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Models;

use AcMarche\MailingList\Database\Factories\EmailRecipientFactory;
use AcMarche\MailingList\Enums\RecipientStatus;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UseFactory(EmailRecipientFactory::class)]
final class EmailRecipient extends Model
{
    /** @use HasFactory<EmailRecipientFactory> */
    use HasFactory;

    protected $connection = 'maria-mailing-list';

    protected $fillable = [
        'email_id',
        'contact_id',
        'email_address',
        'name',
        'status',
        'error',
        'sent_at',
    ];

    /**
     * @return BelongsTo<Email, $this>
     */
    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }

    /**
     * @return BelongsTo<Contact, $this>
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => RecipientStatus::class,
            'sent_at' => 'datetime',
        ];
    }
}
