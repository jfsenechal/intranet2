<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-mailing-list')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'contact_id',
    'username',
    'permission',
])]
final class ContactShare extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    /**
     * @return BelongsTo<Contact, $this>
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
