<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Enums;

enum RecipientStatus: string
{
    case Pending = 'pending';
    case Sent = 'sent';
    case Failed = 'failed';
}
