<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ViewVersion extends ViewRecord
{
    //    protected function getHeaderActions(): array
    //    {
    //        return [
    //            Actions\DeleteAction::make(),
    //            Actions\Action::make('versions')
    //                ->label(fn (HasRevisor $record) => 'History (' . $record->versionRecords()->count() . ')')
    //                ->url(fn (ChordPage $record) => PageResource::getUrl('versions', ['record' => $record->{$record->getRouteKeyName()}]))
    //                ->icon('heroicon-o-clock'),
    //            Actions\Action::make('open')
    //                ->label('Open')
    //                ->url(fn (ChordPage $record) => $record->getLink(true))
    //                ->icon('heroicon-o-arrow-top-right-on-square')
    //                ->iconPosition(IconPosition::After)
    //                ->openUrlInNewTab()
    //                ->color('primary'),
    //            EditPageSettingsAction::make(),
    //        ];
    //    }

    protected function resolveRecord(int | string $key): Model
    {
        $record = app(static::getModel())->withVersionContext()->find(request()->version);

        if ($record === null) {
            throw (new ModelNotFoundException)->setModel($this->getModel(), [$key]);
        }

        return $record;
    }
}
