<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Models;

use AcMarche\MailingList\Database\Factories\SenderFactory;
use AcMarche\MailingList\Repositories\OwnerScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UseFactory(SenderFactory::class)]
#[ScopedBy(OwnerScope::class)]
final class Sender extends Model
{
    /** @use HasFactory<SenderFactory> */
    use HasFactory;

    protected $connection = 'maria-mailing-list';

    protected $fillable = [
        'username',
        'name',
        'email',
        'footer',
        'logo',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }
}
