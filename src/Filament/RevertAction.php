<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Indra\Revisor\Contracts\HasRevisor;

class RevertAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'revert';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->action(function (HasRevisor $record, Action $action, Page $livewire) {
                $record->revertToVersion($livewire->version);
                $action->success();
            })
            ->hidden(fn (Page $livewire) => $livewire->getVersionRecord()->is_current)
            ->requiresConfirmation()
            ->successNotificationTitle(fn (HasRevisor $record) => "Record reverted to version $record->version_number")
            ->icon('heroicon-o-arrow-path');
    }
}
