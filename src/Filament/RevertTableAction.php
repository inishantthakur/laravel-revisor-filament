<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Tables\Actions\Action;
use Indra\Revisor\Contracts\HasRevisor;

class RevertTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'revert';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->action(function (HasRevisor $record, Action $action) {
                $record->revertDraftToThisVersion();
                $action->success();
            })
            ->hidden(fn (HasRevisor $record) => $record->is_current)
            ->requiresConfirmation()
            ->successNotificationTitle(fn (HasRevisor $record) => "Record reverted to version $record->version_number")
            ->icon('heroicon-o-arrow-path');
    }
}
