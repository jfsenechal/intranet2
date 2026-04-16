<?php

declare(strict_types=1);

namespace AcMarche\News\Listeners;

use AcMarche\News\Events\NewsProcessed;
use AcMarche\News\Mail\NewsEmail;
use AcMarche\News\Models\News;
use Exception;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Address;

final class NewsNotification
{
    public function handle(): void
    {
        // $this->sendMail($event->news());
    }
}
