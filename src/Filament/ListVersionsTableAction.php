<?php

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class ListVersionsTableAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'versions';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('History')
            ->icon('heroicon-o-clock')
            ->url(function (Model $record, Page $livewire) {
                $resource = $livewire->getResource();
                if (! $resource::hasPage('versions')) {
                    throw new \Exception("$resource does not have a versions page defined on the Resource");
                }

                return $resource::getUrl('versions', ['record' => $record->{$record->getRouteKeyName()}]);
            });
    }
}
