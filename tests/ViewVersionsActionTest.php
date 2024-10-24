<?php

use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\EditPage;

use function Pest\Livewire\livewire;

it('shows correct number of versions', function () {
    $page = Page::create(['title' => 'page']);

    livewire(EditPage::class, ['record' => $page->id])
        ->assertActionHasLabel('versions', 'History (1)');

    $page->update(['title' => 'updated page']);

    livewire(EditPage::class, ['record' => $page->id])
        ->assertActionHasLabel('versions', 'History (2)');
});
