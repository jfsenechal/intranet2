<?php

declare(strict_types=1);

namespace AcMarche\Pst\Models;

use AcMarche\Pst\Database\Factories\MediaFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

#[UseFactory(MediaFactory::class)]
final class Media extends Model
{
    use HasFactory, Notifiable;

    protected $connection = 'maria-pst';

    protected $fillable = [
        'name',
        'action_id',
        'uuid',
        'file_name',
        'mime_type',
        'disk',
        'size',
    ];

    /**
     * @return BelongsTo<Action>
     */
    public function action(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }
}
