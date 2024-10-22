<?php

use Indra\Revisor\Facades\Revisor;
use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;

use function Pest\Livewire\livewire;

it('can renders correct published statuses', function () {
    Revisor::draftContext();

    $this->get(PageResource::getUrl('index'))->assertSuccessful();

    $draft = Page::create(['title' => 'draft']);
    $published = Page::create(['title' => 'published'])->publish();
    $revised = Page::create(['title' => 'revise'])->publish();

    $this->travel(5)->seconds();
    $revised->update(['title' => 'revised']);

    livewire(ListPages::class)
        ->assertTableColumnStateSet('published_status', '["draft"]', $draft)
        ->assertTableColumnStateSet('published_status', '["published"]', $published)
        ->assertTableColumnStateSet('published_status', '["published","revised"]', $revised);
});
