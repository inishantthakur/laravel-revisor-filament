<?php

use Indra\RevisorFilament\PublishTableAction;
use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;

use function Pest\Livewire\livewire;

it('only shows on unpublishedOrRevised pages', function () {
    $page = Page::create(['title' => 'page']);

    livewire(ListPages::class)
        ->assertTableActionExists(PublishTableAction::class, record: $page);

    $page->publish();

    livewire(ListPages::class)
        ->assertTableActionDoesNotExist(PublishTableAction::class, record: $page);

    $page->update(['title' => 'updated page']);

    livewire(ListPages::class)
        ->assertTableActionExists(PublishTableAction::class, record: $page);
});

it('can publish pages', function () {
    $page = Page::create(['title' => 'draft']);

    livewire(ListPages::class)
        ->callTableAction(PublishTableAction::class, $page)
        ->assertHasNoTableActionErrors();

    expect($page->refresh()->isPublished())->toBeTrue();
});
