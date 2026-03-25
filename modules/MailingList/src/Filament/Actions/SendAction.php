<?php

declare(strict_types=1);

namespace AcMarche\MailingList\Filament\Actions;

use AcMarche\MailingList\Enums\EmailStatus;
use AcMarche\MailingList\Handler\MailerHandler;
use AcMarche\MailingList\Models\Email;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

final class SendAction
{
    public static function make(Email|Model $email): Action
    {
        return Action::make('send')
            ->label('Envoyer')
            ->icon(Heroicon::PaperAirplane)
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Envoyer la newsletter')
            ->modalDescription(
                fn (): string => "Cet e-mail sera envoyé à {$email->total_count} destinataires. Continuer ?"
            )
            ->visible(
                fn (
                ): bool => $email->status === EmailStatus::Draft || $email->status === EmailStatus::Failed
            )
            ->action(fn () => MailerHandler::sendEmail($email));
    }
}
