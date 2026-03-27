<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Models;

use AcMarche\MailingList\Database\Factories\ContactFactory;
use AcMarche\MailingList\Repositories\OwnerScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UseFactory(ContactFactory::class)]
#[ScopedBy(OwnerScope::class)]
final class Contact extends Model
{
    /** @use HasFactory<ContactFactory> */
    use HasFactory;

    protected $connection = 'maria-mailing-list';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'last_name',
        'first_name',
        'email',
        'description',
        'phone',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    /**
     * @return BelongsToMany<AddressBook, $this>
     */
    public function addressBooks(): BelongsToMany
    {
        return $this->belongsToMany(AddressBook::class)->withTimestamps();
    }

    /**
     * @return HasMany<ContactShare, $this>
     */
    public function shares(): HasMany
    {
        return $this->hasMany(ContactShare::class);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function sharedWithUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'contact_shares', 'contact_id', 'username', 'id', 'username')
            ->withPivot('permission')
            ->withTimestamps();
    }
}
