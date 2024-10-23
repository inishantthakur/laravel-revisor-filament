<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Tests\Resources\PageResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Indra\RevisorFilament\Filament\ListVersionsAction;
use Indra\RevisorFilament\Tests\Resources\PageResource;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ListVersionsAction::make(),
            Actions\DeleteAction::make(),

        ];
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('save')->action('save'),
            Actions\Action::make('publish')->action('publish'),
            $this->getCancelFormAction(),
        ];
    }

    public function liveSave(): void
    {
        $record = $this->getRecord();

        // if the record is publish and not yet revised, save a new version
        // otherwise, save the changes to the current version
        if (($record->isPublished() && ! $record->isRevised())) {
            $record->saveNewVersionOnSaved(true);
        } else {
            $record->saveNewVersionOnSaved(false);
        }

        parent::save(false, false);

        $this->dispatch('page-updated');
    }

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        $this->getRecord()

            ->saveNewVersionOnSaved(true);
        parent::save(false, true);
    }

    public function publish(): void
    {
        $this->getRecord()->publish();

        Notification::make()
            ->success()
            ->title('Page published')
            ->send();
    }
}
