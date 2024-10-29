<?php

use Indra\RevisorFilament\Filament\PublishTableAction;
use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;

use function Pest\Livewire\livewire;

it('bulk publishes records', function () {
    Page::create(['title' => 'one']);
    Page::create(['title' => 'two']);

    livewire(ListPages::class)
        ->callTableBulkAction(PublishTableAction::class, Page::all());

    Page::all()->each(fn ($page) => expect($page->isPublished())->toBeTrue());
});
