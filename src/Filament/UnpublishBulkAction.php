<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Indra\Revisor\Contracts\HasRevisor;

class UnpublishBulkAction extends BulkAction
{
    public static function getDefaultName(): ?string
    {
        return 'unpublish';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Unpublish selected')
            ->icon(FilamentIcon::resolve('heroicon-o-arrow-down-tray') ?? 'heroicon-o-arrow-down-tray')
            ->color('warning')
            ->deselectRecordsAfterCompletion()
            ->modalHeading(
                fn (Collection $records) => $records->count() === 1 ?
                    'Unpublish ' . $records->first()->title :
                    'Unpublish ' . $this->getPluralModelLabel()
            )
            ->modalIcon(FilamentIcon::resolve('heroicon-o-arrow-down-tray') ?? 'heroicon-o-arrow-down-tray')
            ->modalIconColor('warning')
            ->modalDescription(
                function (Collection $records) {
                    $count = $records->count();

                    return $count === 1 ?
                        'Are you sure you want to unpublish this ' . $this->getModelLabel() :
                        "Are you sure you want to unpublish $count " . $this->getPluralModelLabel();
                }
            )
            ->modalAlignment(Alignment::Center)
            ->modalFooterActionsAlignment(Alignment::Center)
            ->modalSubmitActionLabel(__('filament-actions::modal.actions.confirm.label'))
            ->modalWidth(MaxWidth::Medium)
            ->action(function (Collection $records, array $data) {
                $records->each(fn (HasRevisor $record) => $record->unpublish());
                $this->success();
            })
            ->successNotificationTitle(
                fn (array $data, Collection $records) => $records->count() > 1 ?
                    $this->getPluralModelLabel() . ' unpublished successfully' :
                    $this->getModelLabel() . ' unpublished successfully'
            );
    }
}
