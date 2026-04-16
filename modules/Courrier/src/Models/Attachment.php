<?php

declare(strict_types=1);

namespace AcMarche\Courrier\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-courrier')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'incoming_mail_id',
    'file_name',
    'mime',
])]
final class Attachment extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    public const UPDATED_AT = null;

    public function incomingMail(): BelongsTo
    {
        return $this->belongsTo(IncomingMail::class);
    }
}
