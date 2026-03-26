<?php

declare(strict_types=1);

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    AcMarche\Security\Providers\SecurityPanelProvider::class,
    AcMarche\MailingList\Providers\Filament\MailingListPanelProvider::class,
    AcMarche\Pst\Providers\Filament\PstPanelProvider::class,
    AcMarche\Courrier\Providers\CourrierPanelProvider::class,
    AcMarche\Document\Providers\DocumentPanelProvider::class,
    AcMarche\Hrm\Providers\HrmPanelProvider::class,
    AcMarche\Mileage\Providers\MileagePanelProvider::class,
    AcMarche\News\Providers\NewsPanelProvider::class,
    AcMarche\Publication\Providers\PublicationPanelProvider::class,
];
