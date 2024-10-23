<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Tables\Actions\Action;
use Indra\Revisor\Contracts\HasRevisor;

class RestoreTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'restore';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->action(function (HasRevisor $record, Action $action) {
                $record->restoreDraftToThisVersion();
                $action->success();
            })
            ->hidden(fn(HasRevisor $record) => $record->is_current)
            ->requiresConfirmation()
            ->successNotificationTitle(fn(HasRevisor $record) => "Version $record->version_number restored as Draft")
            ->icon('heroicon-o-arrow-path');
    }
}
