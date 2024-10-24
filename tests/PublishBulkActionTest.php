<?php

use Indra\RevisorFilament\Filament\PublishTableAction;
use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;

use function Pest\Livewire\livewire;

it('bulk publishes records', function () {
    $pages = Page::factory()->count(2)->create();

    livewire(ListPages::class)
        ->callTableBulkAction(PublishTableAction::class, $pages);

    Page::all()->each(fn ($page) => expect($page->isPublished())->toBeTrue());
});
