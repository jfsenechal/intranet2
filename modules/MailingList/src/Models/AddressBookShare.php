<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class AddressBookShare extends Model
{
    protected $connection = 'maria-mailing-list';

    protected $fillable = [
        'address_book_id',
        'username',
        'permission',
    ];

    /**
     * @return BelongsTo<AddressBook, $this>
     */
    public function addressBook(): BelongsTo
    {
        return $this->belongsTo(AddressBook::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
