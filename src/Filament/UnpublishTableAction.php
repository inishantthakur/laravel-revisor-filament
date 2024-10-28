<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\Page;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Indra\Revisor\Contracts\HasRevisor;

class UnpublishTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'unpublish';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Unpublish')
            ->icon(FilamentIcon::resolve('heroicon-o-arrow-down-tray') ?? 'heroicon-o-arrow-down-tray')
            ->color('warning')
            ->deselectRecordsAfterCompletion()
            ->modalHeading(
                fn (
                    Model $record,
                    Page $livewire
                ) => 'Unpublish ' . $livewire::getResource()::getRecordTitle($record)
            )
            ->modalIcon(FilamentIcon::resolve('heroicon-o-arrow-down-tray') ?? 'heroicon-o-arrow-down-tray')
            ->modalIconColor('warning')
            ->modalDescription('Are you sure you want to unpublish this page?')
            ->modalAlignment(Alignment::Center)
            ->modalFooterActionsAlignment(Alignment::Center)
            ->modalSubmitActionLabel(__('filament-actions::modal.actions.confirm.label'))
            ->modalWidth(MaxWidth::Medium)
            ->hidden(fn (HasRevisor $record) => ! $record->isPublished())
            ->action(function (HasRevisor $record, array $data) {
                $record->unpublish();
                $this->success();
            })
            ->successNotificationTitle(fn (array $data) => $this->getModelLabel() . ' unpublished successfully');
    }
}
