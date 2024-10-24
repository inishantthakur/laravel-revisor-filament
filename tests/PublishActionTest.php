<?php

use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\EditPage;

use function Pest\Livewire\livewire;

it('only shows on unpublishedOrRevised pages', function () {
    $page = Page::create(['title' => 'page']);

    livewire(EditPage::class, ['record' => $page->id])
        ->assertActionVisible('publish');

    $page->publish();

    livewire(EditPage::class, ['record' => $page->id])
        ->assertActionHidden('publish');

    $this->travel(1)->seconds();

    $page->update(['title' => 'updated page']);

    livewire(EditPage::class, ['record' => $page->id])
        ->assertActionVisible('publish');
});

it('can publish pages', function () {
    $page = Page::create(['title' => 'page']);

    livewire(EditPage::class, ['record' => $page->id])
        ->callAction('publish');

    $this->assertTrue($page->refresh()->isPublished());
});
