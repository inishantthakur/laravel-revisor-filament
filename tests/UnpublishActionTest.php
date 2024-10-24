<?php

use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\EditPage;

use function Pest\Livewire\livewire;

it('only shows on published pages', function () {
    $page = Page::create(['title' => 'page']);

    livewire(EditPage::class, ['record' => $page->id])
        ->assertActionHidden('unpublish');

    $page->publish();

    livewire(EditPage::class, ['record' => $page->id])
        ->assertActionVisible('unpublish');
});

it('can unpublish pages', function () {
    $page = Page::create(['title' => 'page'])->publish();

    livewire(EditPage::class, ['record' => $page->id])
        ->callAction('unpublish');

    $this->assertFalse($page->refresh()->isPublished());
});
