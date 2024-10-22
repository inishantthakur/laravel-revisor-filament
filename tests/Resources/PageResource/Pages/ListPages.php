<?php

namespace Indra\RevisorFilament\Tests\Resources\PageResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Indra\RevisorFilament\Tests\Resources\PageResource;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    protected ?string $maxContentWidth = 'full';
}
