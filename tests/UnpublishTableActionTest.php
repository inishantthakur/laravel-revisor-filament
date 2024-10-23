<?php

use Indra\Revisor\Facades\Revisor;
use Indra\RevisorFilament\Filament\UnpublishTableAction;
use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;
use function Pest\Livewire\livewire;

it('only shows on published pages', function () {
    Revisor::draftContext();
    $page = Page::create(['title' => 'page']);

    livewire(ListPages::class)
        ->assertTableActionDoesNotExist(UnpublishTableAction::class, record: $page);

    $page->publish();

    livewire(ListPages::class)
        ->assertTableActionExists(UnpublishTableAction::class, record: $page);
});

it('can unpublish pages', function () {
    $page = Page::create(['title' => 'draft'])->publish();

    livewire(ListPages::class)
        ->callTableAction(UnpublishTableAction::class, record: $page)
        ->assertHasNoTableActionErrors();

    expect($page->refresh()->isPublished())->toBeFalse();
});
