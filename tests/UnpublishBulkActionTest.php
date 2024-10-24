<?php

use Indra\RevisorFilament\Filament\UnpublishBulkAction;
use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;

use function Pest\Livewire\livewire;

it('bulk unpublishes records', function () {
    $pages = Page::factory()->count(2)->create();
    $pages->each->publish();

    livewire(ListPages::class)
        ->callTableBulkAction(UnpublishBulkAction::class, $pages);

    Page::all()->each(fn ($page) => expect($page->isPublished())->toBeFalse());
});
