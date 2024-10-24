<?php

use Indra\Revisor\Facades\Revisor;
use Indra\RevisorFilament\Tests\Models\Page;
use Indra\RevisorFilament\Tests\Resources\PageResource\Pages\ListPages;

use function Pest\Livewire\livewire;

beforeEach(function () {
    Revisor::draftContext();
});

it('renders correct publisher information', function () {
    $page = Page::create(['title' => 'published']);

    livewire(ListPages::class)->assertTableColumnStateSet('publish_info', '-', $page);

    $page->publish();

    livewire(ListPages::class)
        ->assertTableColumnStateSet(
            'publish_info',
            'By ' . $page->publisher->name,
            $page
        )
        ->assertTableColumnHasDescription(
            'publish_info',
            $page->published_at,
            $page
        );
});

//it('sets default placeholder for non-published pages', function () {
//    // Create a draft page without a publisher
//    $draft = Page::create(['title' => 'draft']);
//
//    // Visit the page resource index
//    $this->get(PageResource::getUrl('index'))->assertSuccessful();
//
//    // Check that the publish info column displays placeholder for draft
//    livewire(ListPages::class)
//        ->assertTableColumnStateSet('publish_info', '-', $draft);
//});
//        ->assertTableColumnStateSet('published_status', '["draft"]', $draft)
//        ->assertTableColumnStateSet('published_status', '["published"]', $page)
//        ->assertTableColumnStateSet('published_status', '["published","revised"]', $revised);
//});
