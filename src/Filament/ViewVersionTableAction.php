<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Filament;

use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Model;

class ViewVersionTableAction extends ViewAction
{
    public static function getDefaultName(): ?string
    {
        return 'view';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->url(function (Model $record, Page $livewire) {
            return $livewire::getResource()::getUrl('view_version', [
                'record' => $record->{config('revisor.versioning.table_columns.record_id')},
                'version' => $record->getKey(),
            ]);
        });
    }
}
