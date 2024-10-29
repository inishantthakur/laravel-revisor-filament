<?php

use Indra\RevisorFilament\Filament\UnpublishBulkAction;
use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;

use function Pest\Livewire\livewire;

it('bulk unpublishes records', function () {
    Page::create(['title' => 'one'])->publish();
    Page::create(['title' => 'two'])->publish();

    livewire(ListPages::class)
        ->callTableBulkAction(UnpublishBulkAction::class, Page::all());

    Page::all()->each(fn ($page) => expect($page->isPublished())->toBeFalse());
});
