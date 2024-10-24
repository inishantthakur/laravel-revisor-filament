<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Indra\Revisor\Contracts\HasRevisor;

class PublishBulkAction extends BulkAction
{
    public static function getDefaultName(): ?string
    {
        return 'publish';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Publish selected')
            ->icon(FilamentIcon::resolve('heroicon-o-arrow-up-tray') ?? 'heroicon-o-arrow-up-tray')
            ->color('success')
            ->deselectRecordsAfterCompletion()
            ->modalHeading(fn (
                Collection $records
            ) => $records->count() === 1 ? 'Publish \'' . $records->first()->title . '\'' : 'Publish pages')
            ->modalIcon(FilamentIcon::resolve('heroicon-o-arrow-up-tray') ?? 'heroicon-o-arrow-up-tray')
            ->modalIconColor('success')
            ->modalDescription(
                function (Collection $records) {
                    $count = $records->count();

                    return $count === 1 ?
                        'Are you sure you want to publish this ' . $this->getModelLabel() :
                        "Are you sure you want to publish $count " . $this->getPluralModelLabel();
                }
            )
            ->modalAlignment(Alignment::Center)
            ->modalFooterActionsAlignment(Alignment::Center)
            ->modalSubmitActionLabel(__('filament-actions::modal.actions.confirm.label'))
            ->modalWidth(MaxWidth::Medium)
            ->action(function (Collection $records, array $data) {
                $records->each(fn (HasRevisor $record) => $record->publish());
                $this->success();
            })
            ->successNotificationTitle(
                fn (array $data, Collection $records) => isset($data['recursive']) || $records->count() > 1 ?
                    $this->getPluralModelLabel() . ' published successfully' :
                    $this->getModelLabel() . ' published successfully'
            );
    }
}
