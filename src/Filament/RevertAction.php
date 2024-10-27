<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Actions\Action;
use Filament\Notifications\Actions\Action as NotificationAction;
use Filament\Notifications\Notification;
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
            ->hidden(fn(Page $livewire) => $livewire->getVersionRecord()->is_current)
            ->requiresConfirmation()
            ->successNotification(function (HasRevisor $record) {
                return Notification::make()
                    ->title("Reverted to version $record->version_number.")
                    ->success()
                    ->actions($this->getSuccessNotificationActions());
            })
            ->icon('heroicon-o-arrow-path');
    }

    public function getSuccessNotificationActions(): array
    {
        $resource = $this->getLivewire()->getResource();
        $record = $this->getRecord();
        $actions = [];

        if ($resource::hasPage('view')) {
            $actions[] = NotificationAction::make('view')
                ->label('View')
                ->url($resource::getUrl('view', ['record' => $record->getKey()]));
        }

        if ($resource::hasPage('edit')) {
            $actions[] = NotificationAction::make('edit')
                ->label('Edit')
                ->url($resource::getUrl('edit', ['record' => $record->getKey()]));
        }

        return $actions;
    }
}
