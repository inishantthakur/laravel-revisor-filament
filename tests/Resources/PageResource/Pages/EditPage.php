<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Tests\Resources\PageResource\Pages;

use Filament\Actions;
use Indra\RevisorFilament\Filament\EditRecord;
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
}
